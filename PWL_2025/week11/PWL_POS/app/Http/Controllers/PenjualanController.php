<?php

namespace App\Http\Controllers;

use App\Models\PenjualanModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class PenjualanController extends Controller
{
    //
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Daftar Penjualan',
            'list' => ['Home', 'Penjualan']
        ];

        $page = (object)[
            'title' => 'Daftar Penjualan Barang',
        ];

        $activeMenu = 'penjualan';

        $penjualan = PenjualanModel::all();
        $user = UserModel::all();

        return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'penjualan' => $penjualan, 'user'=> $user]);
    }

    public function list(Request $request)
    {
        $penjualan = PenjualanModel::select('penjualan_id', 'user_id', 'pembeli', 'penjualan_kode', 'penjualan_tanggal');

        if ($request->penjualan_id) {
            $penjualan->where('penjualan_id', $request->penjualan_id);
        }

        return DataTables::of($penjualan)
            ->addIndexColumn()
            ->addColumn('aksi', function ($penjualan) {
                // $btn = '<a href="' . url('/penjualan/' . $penjualan->penjualan_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                // $btn .= '<a href="' . url('/penjualan/' . $penjualan->penjualan_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/penjualan/' . $penjualan->penjualan_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                    $btn = '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                    $btn .= '<button onclick="modalAction(\'' . url('/penjualan/' . $penjualan->penjualan_id . '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button>';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }


    public function create_ajax()
    {
        $penjualan = PenjualanModel::all();
        $user = UserModel::where('level_id', 4)->get();

        return view('penjualan.create_ajax', ['penjualan'=> $penjualan,'user'=> $user]);
    }
    
    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
             $rules = [            
                'user_id' => 'required|exists:m_user,user_id',
                'pembeli'=> 'required|string|max:50',
                'penjualan_kode' => 'required|string|max:20',
                'penjualan_tanggal'=> 'required|date'                                
                
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, 
                    'message' => 'Validasi Gagal', 
                    'msgField' => $validator->errors()
                ]);
            }

            PenjualanModel::create([
                'user_id'     => $request->user_id,
                'pembeli'       => $request->pembeli,
                'penjualan_kode'  => $request->penjualan_kode,
                'penjualan_tanggal'   => $request->penjualan_tanggal,
            ]);
            
            return response()->json(['status' => true, 'message' => 'Data Penjualan berhasil disimpan']);
        }

        return redirect('/');
    }

    public function show_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);

        if (!$penjualan) {return response()->json([
            'error' => 'Data tidak ditemukan', 
            'message' => 'Data tidak ditemukan'
        ], 404);}   

        return view('penjualan.show_ajax', compact('penjualan'));
    }

    public function edit_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        $user = UserModel::all();
        return view('penjualan.edit_ajax', compact('penjualan', 'barang', 'user'));
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'user_id' => 'required|exists:m_user,user_id',
                'pembeli'=> 'required|string|max:50',
                'penjualan_kode' => 'required|string|max:20',
                'penjualan_tanggal'=> 'required|date'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json(['status' => false, 'message' => 'Validasi gagal.', 'msgField' => $validator->errors()]);
            }

            $check = PenjualanModel::find($id);
            if ($check) {
                $check->update($request->all());
                return response()->json([
                    'status' => true, 
                    'message' => 'Data berhasil diupdate'
                ]);
            } else {
                return response()->json(['status' => false, 'message' => 'Data tidak ditemukan']);
            }
        }

        return redirect('/');
    }
    public function confirm_ajax($id)
    {
        $penjualan = PenjualanModel::find($id);
        return view('penjualan.confirm_ajax', compact('penjualan'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $penjualan = PenjualanModel::find($id);
            if ($penjualan) {
                $penjualan->delete();
                return response()->json([
                    'status' => true, 
                    'message' => 'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'=> false, 
                    'message'=> 'Data tidak ditemukan'
                ]);    
            }
        }

        return redirect('/');
    }
}