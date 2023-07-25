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
                                ->orderBy('name', 'asc')
                                ->paginate(15);
        return view('user.user', $data);
    }

    public function userList(Request $request) {
        $name = $request->name;
        $data['users_data'] = DB::table('users')
                                ->select('id', 'name', 'email', 'created_at', 'updated_at', 'role', 'level')
                                ->where(DB::raw('lower(name)'), 'like',  '%'.strtolower($name).'%')
                                ->orderBy('name', 'asc')
                                ->get();    
        
        return response()->json($data);
    }

    public function editUserPage(Request $request) {
        $data['users'] = auth()->user();
        $data['user_data'] = DB::table('users')
                                ->select('id', 'name', 'email', 'role', 'level')
                                ->where('id', $request->id_user)
                                ->get(); 

        return view('user.edit-user', $data);
    }

    public function changePasswordPage(Request $request) {
        $data['users'] = auth()->user();
        $data['id'] = $request->id_user;

        return view('user.change-password', $data);
        // return response()->json($data, 200);
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

    public function editUser(Request $request) {
        $id = $request->id;
        $name = $request->name;
        $email = $request->email;
        $role = $request->role;
        $level = $request->level;
        date_default_timezone_set("Asia/Jakarta");
        $datetime = date('Y-m-d H:i:s', time());

        $update_user = DB::table('users')
                            ->where('id', $id)
                            ->update([
                                'name' => $name,
                                'email' => $email,
                                'role' => $role,
                                'level' => $level,
                                'updated_at' => $datetime
                        ]);
        
        if ($update_user >= 0) {
            return response()->json($update_user, 200);
        } else {
            return response()->json($update_user, 500);
        }
    }

    public function changePassword(Request $request) {
        $id = $request->id;
        $password = $request->password;
        $retype_password = $request->retype_password;
        date_default_timezone_set("Asia/Jakarta");
        $datetime = date('Y-m-d H:i:s', time());

        $update_password = DB::table('users')
                            ->where('id', $id)
                            ->update([
                                'password' => Hash::make($password),
                                'updated_at' => $datetime
                        ]);
        
        if ($update_password >= 0) {
            return response()->json($update_password, 200);
        } else {
            return response()->json($update_password, 500);
        }
    }
}
