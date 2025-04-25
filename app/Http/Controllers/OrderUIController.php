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
        $siswas = Http::get('http://localhost:8001/api/siswas')->json();

        // Ambil semua produk dari ProductService
        $produks = Http::get('http://localhost:8002/api/produks')->json();

        return view('orders', compact('orders', 'siswas', 'produks'));
    }

    public function storeOrder(Request $request) {
        $request->validate([
            'siswa_id' => 'required|integer',
            'produk_id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Ambil harga produk dari ProductService
        $produk = Http::get('http://localhost:8002/api/produks/' . $request->produk_id)->json();

        $total_harga = $produk['harga'] * $request->jumlah;

        Order::create([
            'siswa_id' => $request->siswa_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
        ]);

        return redirect('/orders')->with('success', 'Order berhasil dibuat!');
    }
}
