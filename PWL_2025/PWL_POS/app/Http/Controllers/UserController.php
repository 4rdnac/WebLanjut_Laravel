<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        $data = [
            // 'username' => 'customer-1',
            // 'nama' => 'Pelanggan',
            // 'Password' => Hash::make('12345'),
            // 'level_id' => 4
            //  'level_id'=>2,
            //  'username'=>'manager_2',
            //  'nama'=>'Manager 2',
            //  'password'=>Hash::make('12345')
            'level_id' => 2,
            'username' => 'manager_3',
            'nama' => 'Manager 3',
            'password' => Hash::make('12345')
        ];
        UserModel::create($data);
        $user = UserModel::all();
        return view('user', ['data' => $user]);
    }
}
