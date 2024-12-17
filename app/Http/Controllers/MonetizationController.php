<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MonetizationController extends Controller
{
    // Halaman utama monetisasi
    public function index()
    {
        return view('monetisasi.index'); // Pastikan Anda membuat view ini
    }

    // Menampilkan daftar produk/layanan
    public function showProducts()
    {
        $products = [
            ['id' => 1, 'name' => 'Paket Premium', 'price' => 50000],
            ['id' => 2, 'name' => 'Paket Pro', 'price' => 100000],
        ];

        return view('monetisasi.produk', compact('products'));
    }

    // Memproses pembayaran
    public function processPayment(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'payment_method' => 'required|string',
        ]);

        // Logika pembayaran (contoh sederhana)
        $paymentStatus = 'success'; // Anda bisa mengintegrasikan dengan gateway pembayaran seperti Midtrans, Stripe, dll.

        return response()->json([
            'message' => 'Pembayaran berhasil',
            'status' => $paymentStatus,
        ]);
    }
}