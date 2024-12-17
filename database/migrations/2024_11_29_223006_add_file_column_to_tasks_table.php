<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileColumnToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->string('file')->nullable(); // Menambahkan kolom 'file'
    });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    

public function down()
{
    Schema::table('tasks', function (Blueprint $table) {
        $table->dropColumn('file'); // Menghapus kolom 'file' jika rollback
    });
}
}
