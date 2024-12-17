<?php

use App\Http\Controllers\{
    ActivityController,
    Auth\AuthController,
    DashboardController,
    ManagementPeranController,
    SettingsController,
    TaskController,
    TeamController,
    BantuanController,
    KinerjaController,
    ReportController,
    MonetizationController,
    NotificationController,
    RolePermissionController,
};
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmail;

// Rute Login dan Register

Route::middleware('check.login')->group(function () {
    Route::get('/login', fn() => view('auth.login'))->name('login');
    Route::get('/register', fn() => view('auth.register'))->name('register');
    Route::get('/forgot-password', fn() => view('auth.forgot-password'))->name('forgot.password');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
    Route::get('/reset-password/{token}', fn() => view('auth.reset-password'))->name('show.reset.password');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.password');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::get('/user/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->middleware('auth', 'check.role')->name('dashboard');

// Aktivitas
Route::get('/activity-history', [ActivityController::class, 'index'])
    ->middleware('auth', 'permission:package_log_activity')
    ->name('activity.history');

// Admin Routes
Route::prefix('admin')->middleware(['check.role', 'roles:admin'])->group(function () {
    Route::get('/management-peran', [ManagementPeranController::class, 'index'])->name('admin.management_peran');
    Route::get('/management-peran/{role}', [ManagementPeranController::class, 'detail'])->name('admin.management_peran.detail');
    Route::get('/management-peran/{role}/user/{user}/edit', [ManagementPeranController::class, 'editUserRole'])->name('admin.management_peran.edit_user_role');
    Route::put('/management-peran/{role}/user/{user}', [ManagementPeranController::class, 'updateUserRole'])->name('admin.management_peran.update_user_role');
    Route::delete('/management-peran/{role}/user/{user}', [ManagementPeranController::class, 'deleteUserRole'])
        ->name('admin.management_peran.delete_user_role');
    Route::delete('/management_peran/{roleId}/delete', [ManagementPeranController::class, 'deletePeran'])
        ->name('admin.management_peran.delete');
    Route::get('/management-peran/add/user', [ManagementPeranController::class, 'index_add'])->name('admin.management_peran.add_user');
    Route::post('/management-peran/add/user', [ManagementPeranController::class, 'add'])->name('admin.management_peran.add_user');
    Route::get('/roles/create', [RolePermissionController::class, 'create'])->name('roles.create');
    Route::post('/roles', [RolePermissionController::class, 'store'])->name('roles.store');
    Route::get('/roles/{id}/edit', [RolePermissionController::class, 'edit'])->name('roles.edit');
    Route::put('/roles/{id}', [RolePermissionController::class, 'update'])->name('roles.update');
});

// Settings
Route::prefix('settings')->middleware('auth')->group(function () {
    Route::get('/', [SettingsController::class, 'index'])->name('settings.index');
    Route::put('/update-profile', [SettingsController::class, 'updateProfile'])->name('settings.updateProfile');
    Route::put('/update-password', [SettingsController::class, 'updatePassword'])->name('settings.updatePassword');
    Route::any('/profile-picture', [SettingsController::class, 'deleteProfilePicture'])->name('settings.deleteProfilePicture');
});

// Teams Routes
Route::middleware(['auth', 'check.role.permission:admin,permission:package_leader'])->prefix('teams')->group(function () {
    Route::get('/', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/create', [TeamController::class, 'create'])->middleware('permission:package_leader')->name('teams.create');
    Route::post('/', [TeamController::class, 'store'])->middleware('permission:package_leader')->name('teams.store');
    Route::get('/{team}', [TeamController::class, 'show'])->name('teams.show');
    Route::get('/{team}/edit', [TeamController::class, 'edit'])->middleware('permission:package_edit_team')->name('teams.edit');
    Route::put('/{team}', [TeamController::class, 'update'])->name('teams.update');
    Route::any('/destroy/{team}', [TeamController::class, 'destroyTeam'])->middleware('permission:package_delete_team')->name('teams.destroy');
    Route::get('/{team}/edit', [TeamController::class, 'edit'])->name('teams.edit');

    // Menambah anggota tim
    Route::get('/{team}/add-member', [TeamController::class, 'showAddMemberForm'])->middleware('permission:package_add_member')->name('teams.addMemberForm');
    Route::post('/{team}/add-member', [TeamController::class, 'addMember'])->name('teams.addMember');
    Route::any('/{team}/remove-member/{user}', [TeamController::class, 'removeMember'])->middleware('permission:package_delete_member')->name('teams.removeMember');
    Route::any('/tasks/{task}', [TaskController::class, 'removeTask'])->middleware('permission:package_delete_task')->name('teams.removeTask');

    // Memberikan tugas ke tim (TaskController)
    Route::get('/{team}/tasks/assign', [TaskController::class, 'create'])->middleware('permission:package_create_task')->name('teams.tasks.create');
    Route::post('/{team}/tasks', [TaskController::class, 'store'])->middleware('permission:package_create_task')->name('teams.tasks.store');
});

Route::get('/bantuan', [BantuanController::class, 'index'])->name('bantuan');
Route::get('/home', fn() => view('landing-page'))->name('landing.page');
Route::middleware(['auth', 'check.role'])->group(function () {
    Route::get('/workload/{userId?}', [TaskController::class, 'workload'])->middleware('permission:package_workload')->name('workload');
    Route::get('/tasks/{id}', [TaskController::class, 'show'])->middleware('permission:package_workload')->name('tasks.show');
    Route::post('/tasks/{id}/update-status', [TaskController::class, 'updateStatus'])->middleware('permission:package_workload')->name('tasks.updateStatus');
    Route::post('/tasks/{id}/upload-file', [TaskController::class, 'uploadFile'])->middleware('permission:package_workload')->name('tasks.uploadFile');
    Route::get('/kinerja', [KinerjaController::class, 'index'])->middleware('permission:package_performance')->name('kinerja');
    Route::get('/notifications', [NotificationController::class, 'index'])->middleware('permission:package_notification')->name('notifications.index');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->middleware('permission:package_notification')->name('notifications.markAllAsRead');
    Route::post('/notification/{notification}/read', [NotificationController::class, 'markAsRead'])->middleware('permission:package_notification')->name('notifications.markAsRead');
    Route::get('/reports', [ReportController::class, 'index'])->middleware('permission:package_reports')->name('reports.index');
    Route::get('/reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('reports/export/pdf', [ReportController::class, 'exportPdf'])->name('reports.export.pdf');
    Route::get('/reports/export/csv', [ReportController::class, 'exportCsv'])->name('reports.export.csv');
});


Route::prefix('monetisasi')->middleware(['check.role'])->group(function () {
    Route::get('/', [MonetizationController::class, 'index'])->name('monetisasi.index');
});

// Route::group(['middleware' => ['permission:view_reports']], function () {
//     Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
// });
