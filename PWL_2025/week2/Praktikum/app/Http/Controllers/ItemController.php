<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index()// Menampilkan daftar semua item
    {
        $items = Item::all();// Mengambil semua data item dari database
        return view('items.index', compact('items'));// Mengirim data ke tampilan 'items.index'
    }

    public function create()// Menampilkan halaman form untuk menambahkan item baru
    {
        return view('items.create');// Mengarahkan ke tampilan 'items.create'
    }

    public function store(Request $request)// Menyimpan item baru ke database
    {
        $request->validate([ // Validasi input agar 'name' dan 'description' tidak kosong
            'name' => 'required',
            'description' => 'required',
        ]);

        // Hanya masukkan atribut yang diizinkan
        Item::create($request->only(['name', 'description']));

        return redirect()->route('items.index')->with('success', 'Item added successfully.');   // Redirect ke halaman daftar item dengan pesan sukses
    }

    public function show(Item $item) // Menampilkan detail item tertentu
    {
        return view('items.show', compact('item'));// Mengirim data item ke tampilan 'items.show'
    }

    public function edit(Item $item) // Menampilkan form edit item
    {
        return view('items.edit', compact('item'));// Mengirim data item ke tampilan 'items.edit'
    }

    public function update(Request $request, Item $item)// Memperbarui data item di database
    {
        $request->validate([// Validasi input agar 'name' dan 'description' tidak kosong
            'name' => 'required',
            'description' => 'required',
        ]);


        $item->update($request->only(['name', 'description'])); // Memperbarui item dengan data yang diizinkan
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');// Redirect ke halaman daftar item dengan pesan sukses
    }

    public function destroy(Item $item)// Menghapus item dari database
    {
        $item->delete();// Menghapus item dari database
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');// Redirect dengan pesan sukses
    }
}
