<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(request $request)
    {
        //
        $data_user = User::all();
        //pencarian data user berdasarkan nama user
        if ($request->has('search')) {
            $data_user = User::where('name', 'LIKE', '%'. $request->search.'%')->orderby('name','ASC')->simplePaginate(5);
        }

        //mengatur pengurutan data user berdasarkan role
        if ($request->has('role')) {
            $data_user = User::where('role', '',$request->role)->orderby('name','ASC')->simplePaginate(5);
        }
        //mengatur pengurutan data user berdasarkan role dan nama user
        if ($request->has('role') && $request->has('search')) {
            $data_user = User::where('role', $request->role)->where('name', 'LIKE', '%'. $request->search.'%')->orderby('name','ASC')->simplePaginate(5);
        }
        

        return view('users.index', compact('data_user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // @dd($request->all());
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email|max:50|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|string|in:admin,user'
        ], [
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password harus minimal 8 karakter',
            'role.required' => 'Role harus diisi',
            'role.in' => 'Role harus admin atau user',
        ]);
            


        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,   
            'role' => $request->role
        ]);
        return redirect()->route('user.data_user');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //mengambil data user berdasarkan ID untuk diedit
        $data = User::find($id);
        
        // Mengembalikan view untuk form edit obat
        return view('users.edit', [
            'item' => $data
        ]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // Validasi input dari form edit
        $data = $request->validate([
            'name' => 'required|string|max:100',    // Nama harus diisi dan maksimal 100 karakter
            'email' => 'required|email|max:100|unique:users,email,' . $id,     // Email harus diisi dan maximal 100 karakter
            'role' => 'required|string|in:admin,user', // Role harus diisi dan minimal 3 karakter
            'password' => 'nullable|string|min:8' // Password boleh kosong dan minimal 8 karakter
        ], [
            // Pesan kesalahan validasi
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'role.required' => 'Role harus diisi',
            'name.max' => 'Maksimal 100 karakter',
            'password.min' => 'Password minimal 8 karakter'
        ]);
        
        //mengupdate data user berdasarkan ID 
        $user = User::where('id', $id)->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->password) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        
        return redirect()->route('user.data_user')->with('success', 'Berhasil Mengedit Data!');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        {
            // Mencari data obat berdasarkan ID
            $deletedata = User::find($id);
    
            // Jika data ditemukan dan berhasil dihapus
            if ($deletedata && $deletedata->delete()) {
                return redirect()->back()->with('success', 'Berhasil Menghapus Data!');
            } else {
                // Jika gagal menghapus data
                return redirect()->back()->with('error', 'Gagal Menghapus Data');
            }
        }
    }
}
