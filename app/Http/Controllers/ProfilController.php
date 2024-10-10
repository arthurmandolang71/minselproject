<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Gate;

class ProfilController extends Controller
{
    public function show(User $user)
    {

        Gate::authorize('profil');

        return view('user.profil', [
            'title' => 'My Profil',
            'profil' => $user,
        ]);
    }

    public function edit(User $user)
    {
        Gate::authorize('profil');

        return view('user.edit', [
            'title' => 'Edit Password',
            'profil' => $user,
        ]);
    }

    public function update(Request $request, User $user)
    {
        Gate::authorize('profil');

        $update = ['password' => bcrypt($request->password)];

        User::where('id', $user->id)->update($update);

        return redirect("/profil/$user->id")->with('pesan', 'password berhasil di ganti');
    }
}
