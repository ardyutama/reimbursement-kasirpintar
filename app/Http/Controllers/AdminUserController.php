<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        if (auth()->user()->jabatan === 'DIREKTUR') {
            return view('users.create');
        }

        return redirect('/users')->with('error', 'You do not have permission to create users.');
    }

    public function store(Request $request)
    {
        if (auth()->user()->jabatan === 'DIREKTUR') {
            $validatedData = $request->validate([
                'NIP' => 'required|unique:users',
                'nama' => 'required',
                'jabatan' => 'required',
                'password' => 'required|min:6',
            ]);

            $user = new User;
            $user->NIP = $validatedData['NIP'];
            $user->nama = $validatedData['nama'];
            $user->jabatan = $validatedData['jabatan'];
            $user->password = Hash::make($validatedData['password']);
            $user->save();

            return redirect('/users')->with('success', 'User created successfully.');
        }
        return redirect('/users')->with('error', 'You do not have permission to create users.');
    }

    public function edit(User $user)
    {
        if (auth()->user()->jabatan === 'DIREKTUR') {
            return view('users.edit', compact('user'));
        }

        return redirect('/users')->with('error', 'You do not have permission to edit users.');
    }

    public function update(Request $request, User $user)
    {
        if (auth()->user()->jabatan === 'DIREKTUR') {
            $validatedData = $request->validate([
                'NIP' => 'required|unique:users,NIP,' . $user->id,
                'nama' => 'required',
                'jabatan' => 'required',
                'password' => 'sometimes|min:6',
            ]);

            $user->NIP = $validatedData['NIP'];
            $user->nama = $validatedData['nama'];
            $user->jabatan = $validatedData['jabatan'];
            
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            return redirect('/users')->with('success', 'User updated successfully.');
        }

        return redirect('/users')->with('error', 'You do not have permission to edit users.');
    }

    public function destroy(User $user)
    {
        if (auth()->user()->jabatan === 'DIREKTUR') {
            $user->delete();

            return redirect('/users')->with('success', 'User deleted successfully.');
        }

        return redirect('/users')->with('error', 'You do not have permission to delete users.');
    }
}
