<?php
namespace App\Http\Controllers;

use App\Models\LevelModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class LevelController extends Controller

    {
        // Menampilkan halaman daftar level
        public function index()
        {
            $breadcrumb = (object) [
                'title' => 'Daftar Level',
                'list' => ['Home', 'Level']
            ];
            $page = (object) [
                'title' => 'Daftar level yang tersedia dalam sistem'
            ];
            $activeMenu = 'level';
    
            return view('level.index', compact('breadcrumb', 'page', 'activeMenu'));
        }
    
        // Ambil data level dalam bentuk JSON untuk DataTables
        public function list(Request $request)
        {
            $levels = LevelModel::select('level_id', 'level_kode', 'level_nama');
    
            return DataTables::of($levels)
                ->addIndexColumn()
                ->addColumn('aksi', function ($level) {
                    $btn = '<a href="' . url('/level/' . $level->level_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                    $btn .= '<a href="' . url('/level/' . $level->level_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                    $btn .= '<form class="d-inline-block" method="POST" action="' . url('/level/' . $level->level_id) . '">'
                        . csrf_field() . method_field('DELETE') . 
                        '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    
        // Menampilkan halaman tambah level
        public function create()
        {
            $breadcrumb = (object) [
                'title' => 'Tambah Level',
                'list' => ['Home', 'Level', 'Tambah Level']
            ];
            $page = (object) [
                'title' => 'Tambah Level Baru'
            ];
            $activeMenu = 'level';
    
            return view('level.create', compact('breadcrumb', 'page', 'activeMenu'));
        }
    
        // Menyimpan level baru
        public function store(Request $request)
        {
            $request->validate([
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode',
                'level_nama' => 'required|string|min:3|unique:m_level,level_nama'
            ]);
    
            LevelModel::create([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama
            ]);
    
            return redirect('/level')->with('success', 'Level berhasil ditambahkan');
        }
    
        // Menampilkan detail level
        public function show(string $level_id)
        {
            $level = LevelModel::find($level_id);
            if (!$level) {
                return redirect('/level')->with('error', 'Data level tidak ditemukan');
            }
    
            $breadcrumb = (object) [
                'title' => 'Detail Level',
                'list' => ['Home', 'Level', 'Detail Level']
            ];
            $page = (object) [
                'title' => 'Detail Level'
            ];
            $activeMenu = 'level';
    
            return view('level.show', compact('breadcrumb', 'page', 'level', 'activeMenu'));
        }
    
        // Menampilkan halaman edit level
        public function edit(string $level_id)
        {
            $level = LevelModel::find($level_id);
            if (!$level) {
                return redirect('/level')->with('error', 'Data level tidak ditemukan');
            }
    
            $breadcrumb = (object) [
                'title' => 'Ubah Level',
                'list' => ['Home', 'Level', 'Ubah Level']
            ];
            $page = (object) [
                'title' => 'Ubah Level'
            ];
            $activeMenu = 'level';
    
            return view('level.edit', compact('breadcrumb', 'page', 'level', 'activeMenu'));
        }
    
        // Menyimpan perubahan level
        public function update(Request $request, string $level_id)
        {
            $level = LevelModel::find($level_id);
            if (!$level) {
                return redirect('/level')->with('error', 'Data level tidak ditemukan');
            }
    
            $request->validate([
                'level_kode' => 'required|string|max:10|unique:m_level,level_kode,' . $level_id . ',level_id',
                'level_nama' => 'required|string|min:3|unique:m_level,level_nama,' . $level_id . ',level_id'
            ]);
    
            $level->update([
                'level_kode' => $request->level_kode,
                'level_nama' => $request->level_nama
            ]);
    
            return redirect('/level')->with('success', 'Level berhasil diperbarui');
        }
    
        // Menghapus level
        public function destroy(string $level_id)
        {
            $level = LevelModel::find($level_id);
            if (!$level) {
                return redirect('/level')->with('error', 'Data level tidak ditemukan');
            }
    
            try {
                $level->delete();
                return redirect('/level')->with('success', 'Level berhasil dihapus');
            } catch (\Illuminate\Database\QueryException $e) {
                return redirect('/level')->with('error', 'Level tidak dapat dihapus karena masih terhubung dengan data lain');
            }
        }
    }
    
