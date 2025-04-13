<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use App\Models\LevelModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Daftar User',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'Daftar User yang terdaftar dalam sistem'
        ];

        $activeMenu = 'user';
        $level = LevelModel::all();

        return view('user.index', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function list(Request $request)
    {
        $users = UserModel::select('user_id', 'username', 'nama', 'level_id')->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->addColumn('aksi', function ($user) {
                $url = url('/user/' . $user->user_id);
                return '
                    <button onclick="modalAction(\'' . $url . '/show_ajax\')" class="btn btn-info btn-sm">Detail</button>
                    <button onclick="modalAction(\'' . $url . '/edit_ajax\')" class="btn btn-warning btn-sm">Edit</button>
                    <button onclick="modalAction(\'' . $url . '/delete_ajax\')" class="btn btn-danger btn-sm">Hapus</button>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah User']
        ];

        $page = (object) ['title' => 'Tambah User baru'];
        $level = LevelModel::all();
        $activeMenu = 'user';

        return view('user.create', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function create_ajax()
    {
        $level = LevelModel::select('level_id', 'level_nama')->get();
        return view('user.create_ajax', compact('level'));
    }

    public function store_ajax(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|string|min:3|max:20|unique:m_user,username',
            'password' => 'required|min:5|max:20',
            'nama' => 'required|string|max:100',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => "Validasi Gagal",
                'msgField' => $validator->errors(),
            ]);
        }

        try {
            $userData = [
                'username' => $request->username,
                'nama' => $request->nama,
                'password' => bcrypt($request->password),
                'level_id' => $request->level_id
            ];

            if ($request->hasFile('foto')) {
                $file = $request->file('foto');
                $filename = Str::slug($request->username) . '.' . $file->getClientOriginalExtension();
                $uploadPath = public_path('uploads/profile');

                if (!file_exists($uploadPath)) mkdir($uploadPath, 0755, true);
                if (file_exists("$uploadPath/$filename")) unlink("$uploadPath/$filename");

                $file->move($uploadPath, $filename);
                $userData['foto'] = $filename;
            }

            UserModel::create($userData);

            return response()->json([
                'status' => true,
                'message' => "Data user berhasil disimpan",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => "Gagal menyimpan data: " . $e->getMessage(),
            ]);
        }
    }

    public function show_ajax(string $id)
    {
        $user = UserModel::with('level')->find($id);
        return view('user.show_ajax', compact('user'));
    }

    public function edit(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::all();

        $breadcrumb = (object) [
            'title' => 'Ubah User',
            'list' => ['Home', 'User', 'Ubah User']
        ];

        $page = (object) ['title' => 'Ubah User'];
        $activeMenu = 'user';

        return view('user.edit', compact('breadcrumb', 'page', 'user', 'level', 'activeMenu'));
    }

    public function edit_ajax(string $id)
    {
        $user = UserModel::find($id);
        $level = LevelModel::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', compact('user', 'level'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);

        $user = UserModel::find($id);
        if (!$user) return redirect('/user')->with('error', 'User tidak ditemukan');

        $user->update([
            'username' => $request->username,
            'nama' => $request->nama,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'level_id' => $request->level_id
        ]);

        return redirect('/user')->with('success', 'User berhasil diubah');
    }

    public function update_ajax(Request $request, string $id)
    {
        if (!$request->ajax()) return redirect('/');

        $rules = [
            'level_id' => 'required|integer',
            'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
            'nama' => 'required|max:100',
            'password' => 'nullable|min:6|max:20',
            'foto' => 'nullable|image|mimes:jpeg,jpg,png|max:2048'
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validasi gagal.',
                'msgField' => $validator->errors()
            ]);
        }

        $user = UserModel::find($id);
        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ]);
        }

        $userData = [
            'username' => $request->username,
            'nama' => $request->nama,
            'level_id' => $request->level_id
        ];

        if ($request->filled('password')) {
            $userData['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');
            $filename = Str::slug($request->username) . '.' . $file->getClientOriginalExtension();

            if ($user->foto && file_exists(public_path('uploads/profile/' . $user->foto))) {
                unlink(public_path('uploads/profile/' . $user->foto));
            }

            $filePath = public_path('uploads/profile/' . $filename);
            if (file_exists($filePath) && $user->foto != $filename) {
                unlink($filePath);
            }

            $file->move(public_path('uploads/profile'), $filename);
            $userData['foto'] = $filename;
        } elseif ($user->foto && $user->username != $request->username) {
            $oldPath = public_path('uploads/profile/' . $user->foto);
            $extension = pathinfo($user->foto, PATHINFO_EXTENSION);
            $newFilename = Str::slug($request->username) . '.' . $extension;
            $newPath = public_path('uploads/profile/' . $newFilename);

            if (file_exists($oldPath)) {
                if (file_exists($newPath)) unlink($newPath);
                rename($oldPath, $newPath);
                $userData['foto'] = $newFilename;
            }
        }

        $user->update($userData);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }

    public function destroy(string $id)
    {
        $check = UserModel::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }

        try {
            UserModel::destroy($id);
            return redirect('/user')->with('success', 'User berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect('/user')->with('error', 'User tidak dapat dihapus karena masih terhubung dengan data lain');
        }
    }

    public function confirm_ajax(string $id)
    {
        $user = UserModel::find($id);
        return view('user.confirm_ajax', compact('user'));
    }

    public function delete_ajax(Request $request, $id)
    {
        if (!$request->ajax()) return redirect('/');

        $user = UserModel::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => true,
                'message' => 'Data berhasil dihapus'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Data tidak ditemukan'
        ]);
    }
}
