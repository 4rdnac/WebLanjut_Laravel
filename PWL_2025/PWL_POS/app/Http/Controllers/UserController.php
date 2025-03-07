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
        // $data = [
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
        // ];
        // UserModel::create($data);
        // $user = UserModel::where(1);
        // $user = UserModel::where('level_id',1)->first();
        // $user = UserModel::firstWhere('level_id',1);
        // $user = UserModel::findOr(20, ['username', 'nama'], function () {
        //     abort(404);
        // });
        // $user = UserModel::where('username','manager')->firstOrFail();
        // $user = UserModel::where('level_id', 2)->count();
        // dd($user);
        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'Manager'
        //     ]
        // );
        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager33',
        //         'nama' => 'Manager Tiga Tiga',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // $user = UserModel::create([
        //     'username' => 'manager55',
        //     'nama' => 'Manager55',
        //     'password' => Hash::make('12345'),
        //     'level_id' => 2,
        // ]);
        // $user->username = 'manager56';

        // $user->isDirty(); // true 
        // $user->isDirty('username'); // true 
        // $user->isDirty('nama'); // false 
        // $user->isDirty(['nama', 'username']); // true 

        // $user->save();

        // $user->isClean(); // false 
        // $user->isClean('username'); // false 
        // $user->isClean('nama'); // true 
        // $user->isClean(['nama', 'username']); // false 

        $user = UserModel::create([
            'username' => 'manager11',
            'nama' => 'Manager11',
            'password' => Hash::make('12345'),
            'level_id' => 2,
        ]);
        $user->username = 'manager12';

        $user->save();

        $user->wasChanged(); // true 
        $user->wasChanged('username'); // true 
        $user->wasChanged(['username', 'level_id']); // true 
        $user->wasChanged('nama'); // false 
        dd($user->wasChanged(['nama', 'username']));
       
    }
}
