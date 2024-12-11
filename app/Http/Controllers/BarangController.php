<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use Illuminate\Http\Request;

class BarangController extends Controller
{
    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|max:100',
            'jumlah_barang' => 'required|integer',
            'detail' => 'nullable|string',
        ]);

        $barang = Barang::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil ditambahkan!',
            'data' => $barang
        ]);
    }

    // Menampilkan data barang untuk diubah
    public function edit($id)
    {
        $barang = Barang::find($id);

        if (!$barang) {
            return response()->json(['error' => 'Data tidak ditemukan'], 404); // Jika data tidak ditemukan
        }

        return response()->json($barang); // Mengembalikan data dalam format JSON
    }

    // Memperbarui data barang
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|max:100',
            'jumlah_barang' => 'required|integer',
            'detail' => 'nullable|string',
        ]);

        $barang = Barang::findOrFail($id);
        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil diperbarui!',
            'data' => $barang
        ]);
    }

    // Menghapus data barang
    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Barang berhasil dihapus!'
        ]);
    }
}