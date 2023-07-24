<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index() {
        $data['users'] = auth()->user();
        $data['users_data'] = DB::table('users')
                                ->select('id', 'name', 'email', 'created_at', 'updated_at', 'role', 'level')
                                ->orderBy('name', 'desc')
                                ->paginate(15);
        return view('user.user', $data);
    }

    public function userList(Request $request) {
        $name = $request->name;
        $data['users_data'] = DB::table('users')
                                ->select('id', 'name', 'email', 'created_at', 'updated_at', 'role', 'level')
                                ->where(DB::raw('lower(name)'), 'like',  '%'.strtolower($name).'%')
                                ->orderBy('name', 'desc')
                                ->get();    
        
        return response()->json($data);
    }

    public function userForm() {
        $data['users'] = auth()->user();

        return view('user.user-form', $data);
    }

    public function addUser(Request $request) {
        $name = $request->name;
        $email = $request->email;
        $role = $request->role;
        $level = $request->level;
        $password = $request->password;
        date_default_timezone_set("Asia/Jakarta");
        $datetime = date('Y-m-d H:i:s', time());

        $insert_user = DB::table('users')->insert(
            [
                'name' => $name,
                'email' => $email,
                'role' => $role,
                'level' => $level,
                'password' => Hash::make($password),
                'created_at' => $datetime
            ]
        );

        if ($insert_user) {
            return response()->json($insert_user, 200);
        } else {
            return response()->json($insert_user, 500);
        }
    }
}
