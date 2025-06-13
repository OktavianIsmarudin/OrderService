<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class OrderUIController extends Controller
{
    public function index() {
        return view('home');
    }

    public function listOrders() {
        $orders = Order::all();

        // Ambil semua siswa dari UserService
        $siswas = Http::get('http://user-nginx/api/siswas/')->json();




        // Ambil semua produk dari ProductService
        $produks = Http::get('http://product-nginx/api/produks/')->json();
        return view('orders', compact('orders', 'siswas', 'produks'));
    }

    public function storeOrder(Request $request) {
        dd(session()->all());

    $request->validate([
        'siswa_id' => 'required|integer',
        'produk_id' => 'required|integer',
        'jumlah' => 'required|integer|min:1',
    ]);

    // Ambil data produk dari ProductService
    $produk = Http::get('http://product-nginx/api/produks/' . $request->produk_id)->json();

    if (!$produk) {
        return redirect('/orders')->with('error', 'Produk tidak ditemukan.');
    }

    // Cek stok produk cukup atau tidak
    if ($produk['stok'] < $request->jumlah) {
        return redirect('/orders')->with('error', 'Stok produk tidak cukup.');
    }

    $total_harga = $produk['harga'] * $request->jumlah;

    // Buat order dulu
    Order::create([
        'siswa_id' => $request->siswa_id,
        'produk_id' => $request->produk_id,
        'jumlah' => $request->jumlah,
        'total_harga' => $total_harga,
    ]);

    // Kurangi stok produk lewat API product-service
    $response = Http::post('http://product-nginx/api/produks/' . $request->produk_id . '/reduce-stock', [
    'quantity' => $request->jumlah,
]);

    if ($response->failed()) {
        // Jika gagal update stok, bisa rollback order atau beri peringatan
        // Contoh sederhana, beri pesan error dan redirect
        return redirect('/orders')->with('error', 'Gagal mengurangi stok produk.');
    }

    return redirect('/orders')->with('success', 'Order berhasil dibuat dan stok produk berkurang!');
}

}
