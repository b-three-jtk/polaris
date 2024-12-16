<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        $user = Auth::user()->load('submitter');
        return view('auth.profile', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, $id)
    {
        //
        $request->validated();
    
        $user = User::findOrFail($id);
        $user->fill($request->all());
    
        if($request->hasFile('avatar')) {
            $path = $request->avatar->store('user', 'public');
            $user->avatar = $path;
        }
    
        $user->save();

        if ($user->submitter) {
            $user->submitter->update([
                'position_in_organization' => $request->input('position_in_organization'),
            ]);
        }
        
        return redirect()->back()->with('success', 'Anda berhasil memperbarui profil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    
    public function signOut(Request $request)
    {
        Auth::logout(); // Logout user dari session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $title = 'Logout:(';
        $text = "Apakah kamu yakin akan logout?";
        confirmDelete($title, $text);
        return redirect('/')->with('success', 'Anda telah berhasil logout.');
    }
}
