<?php

namespace App\Http\Controllers;

use App\DataTables\LevelDataTable;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index(LevelDataTable $dataTable)
    {
        return $dataTable->render('level.index');
    }

    public function create()
    {
        return view('level.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'levelKode' => 'required|max:10',
            'levelNama' => 'required|max:100',
        ]);

        LevelModel::create([
            'level_kode' => $request->levelKode,
            'level_nama' => $request->levelNama,
        ]);
        
        return redirect()->route('level.index')->with('success', 'Level berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $level = LevelModel::findOrFail($id);
        return view('level.edit', compact('level'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'levelKode' => 'required|max:10',
            'levelNama' => 'required|max:100',
        ]);

        $level = LevelModel::findOrFail($id);
        $level->update([
            'level_kode' => $request->levelKode,
            'level_nama' => $request->levelNama,
        ]);
        
        return redirect()->route('level.index')->with('success', 'Level berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $level = LevelModel::findOrFail($id);
        $level->delete();
        
        return redirect()->route('level.index')->with('success', 'Level berhasil dihapus.');
    }
}