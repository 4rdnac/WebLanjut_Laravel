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
            // 'level_id' => 2,
            // 'username' => 'manager_3',
            // 'nama' => 'Manager 3',
            // 'password' => Hash::make('12345')
        ];
        // UserModel::create($data);
        // $user = UserModel::where(1);
        // $user = UserModel::where('level_id',1)->first();
        // $user = UserModel::firstWhere('level_id',1);
        // $user = UserModel::findOr(20, ['username', 'nama'], function () {
        //     abort(404);
        // });
        $user = UserModel::where('username','manager')->firstOrFail();
        return view('user', ['data' => $user]);
    }
}
