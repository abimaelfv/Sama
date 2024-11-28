<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CompletarRegistro
{
    public function create()
    {
        $user = Auth::user();
        if (empty($user->se_registro)) {
            return Inertia::render(
                'Auth/CompletarRegistro',
                compact('user')
            );
        }
        return redirect()->route('panel');
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'integer', 'digits:9'],
        ])->validate();

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->se_registro = 1;

        $user->save();
        return redirect()->intended(route('panel'));
    }
}
