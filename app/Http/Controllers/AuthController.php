<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function user()
    {
        return view('admin.user.user-view');
    }

    public function registrasi()
    {
        return view('auth.registrasi');
    }

    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error_message', 'Error inputan silahkan perbaiki')->withErrors($validator)->withInput();
        }
        $user = User::where('username', $request->username)->first();
         if(Auth::attempt(array('username' => $input['username'], 'password' => $input['password']))){
            if(Auth::user()->role == 1){
                return redirect()->route('dashboard');
            }else{
                 return redirect()->route('home');
            }
         }else{
             return redirect()->back()->with('error_message', 'email / password salah');
         }
    }

    public function getUser()
    {
         $users = User::orderBy('created_at','desc')->get();
         return response()->json($users);
    }

    public function store(Request $request)
    {
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'no_hp' => 'required|numeric',
            'role' => 'required|numeric'
        ]);
            if($validator->fails()){
                return response()->json([
                        'errors' =>  $validator->errors()
                    ], 400);
            }

        $name = $request->name;
        $username = $request->username;
        $email = $request->email;
        $role = $request->role;
        $password = Hash::make($request->password);
        $no_hp = $request->no_hp;
        $users = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'no_hp' => $no_hp,
            'password' => $password,
            'role' => $role
        ];
        User::create($users);
        return redirect()->back()->with('success_message', 'User create successfully!');
    }

    public function show($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function detail($id)
    {
        $userDetail = User::find($id);
         if (!$userDetail) {
            abort(404, 'User not found');
        }
        // Debug sementara
        $data = [
            'userDetail' => $userDetail
        ];
        return view('admin.user.user-detail', $data);
    }

    public function update(Request $request, $id)
    {
        
         $validator = Validator::make($request->all(), [
            'name' => 'required',
            'no_hp' => 'required|numeric',
            'role' => 'required|numeric'
        ]);
            if($validator->fails()){
                return response()->json([
                        'errors' =>  $validator->errors()
                    ], 400);
            }

        $user = User::findOrFail($id);
        $name = $request->name;
        $role = $request->role;
        $password = $user->password;
        $no_hp = $request->no_hp;
        $users = [
            'name' => $name,
            'no_hp' => $no_hp,
            'password' => $password,
            'role' => $role
        ];
        User::where('id', $user->id)->update($users);
        return response()->json([
            'message' => 'User updated successfully!'
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|regex:/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/',
            'no_hp' => 'required|numeric'
        ]);
        if($validator->fails()){
            return redirect()->back()->with('error_message', 'Error inputan silahkan perbaiki')->withErrors($validator)->withInput();
        }

        $name = $request->input('name');
        $username = $request->input('username');
        $email = $request->input('email');
        $password = Hash::make($request->input('password'));
        $no_hp = $request->input('no_hp');
        $users = [
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'no_hp' => $no_hp,
            'password' => $password,
            'role' => 2
        ];
        User::create($users);
        return redirect()->back()->with('success_message', 'Pendaftaran berhasil!');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        $user->delete();
        return response()->json(['success_message' => 'Data deleted successfully'], 200);
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->to('/login');
    }
}
