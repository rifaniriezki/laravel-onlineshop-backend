<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){

        $users = User::where('name', 'like', '%' . request('name') . '%')
        ->orderBy('id', 'desc')
        ->paginate(5);
        return view('pages.users.index', compact('users'));
    }

    public function create(){
        return view('pages.users.create');
    }

    public function store(Request $request){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'roles' => $request->roles,
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('users.index')->with('success', 'User Created Successfully!');
    }

    public function show($id){
        return view('pages.dashboard');
    }

    public function edit(User $user){
        return view('pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user){
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'roles' => $request->roles,
        ]);

        if ($request->password){
            $user->update([
                'password' => Hash::make($request->password)
            ]);
        }

        return redirect()->route('users.index')->with('success', 'User Update Successfully!');
    }

    public function destroy(User $user){
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User Delete Successfully!');
    }
}
