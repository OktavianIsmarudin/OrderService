<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function index() {
        return Order::all();
    }

    public function store(Request $request) {
        $request->validate([
            'siswa_id' => 'required|integer',
            'produk_id' => 'required|integer',
            'jumlah' => 'required|integer|min:1',
        ]);

        // Cek data siswa dari UserService
        $siswaResponse = Http::get("http://localhost:8001/api/siswas/" . $request->siswa_id);
        if (!$siswaResponse->ok()) {
            return response()->json(['error' => 'Siswa tidak ditemukan'], 404);
        }

        // Cek data produk dari ProductService
        $produkResponse = Http::get("http://localhost:8002/api/produks/" . $request->produk_id);
        if (!$produkResponse->ok()) {
            return response()->json(['error' => 'Produk tidak ditemukan'], 404);
        }

        $produk = $produkResponse->json();

        // Hitung total harga
        $total_harga = $produk['harga'] * $request->jumlah;

        // Simpan Order
        $order = Order::create([
            'siswa_id' => $request->siswa_id,
            'produk_id' => $request->produk_id,
            'jumlah' => $request->jumlah,
            'total_harga' => $total_harga,
        ]);

        return response()->json($order, 201);
    }
}
