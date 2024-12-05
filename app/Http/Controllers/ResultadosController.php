<?php

namespace App\Http\Controllers;

use App\Mail\EnviarResultados;
use App\Models\Archivos;
use App\Models\Envios;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

class ResultadosController extends Controller
{
    public function index()
    {
        $users = User::with('envios')->get()->map(function ($user) {
            $user->se_envio = $user->envios()->where('env_estado', 1)->exists();
            return $user;
        });

        return inertia('Resultados', [
            'users' => $users
        ]);
    }

    public function consultar($documento)
    {
        $user = User::where('documento', $documento)->first();
        $envios = Envios::with('archivos')
            ->where('user_id', $user->id)
            ->get();

        return inertia('Resultados/Consultar', [
            'envios' => $envios
        ]);
    }

    public function descargar($file)
    {
        $documento = Archivos::where('arc_file', $file)->where('arc_estado', 1)->first();

        if (!$documento) {
            abort(404);
        } else {
            $name = $documento->arc_nombre;
            $filePath = storage_path('app/public/archivos/' . $documento->arc_file);
            if (File::exists($filePath)) {
                return response()->download($filePath, $name);
            } else {
                abort(404);
            }
        }
    }

    public function enviar(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'archivos' => 'required|array|min:1'
        ]);

        $user = User::findOrFail($request->id);

        $envio = Envios::create([
            'user_id' => $user->id,
            'env_estado' => 1,
            'env_fecha' => now(),
        ]);

        foreach ($request->file('archivos', []) as $file) {
            if ($file) {
                $nombreArchivo = $file->getClientOriginalName();
                $extension = $file->getClientOriginalExtension();
                $nameUnico = uniqid() . '.' . $extension;

                $file->move(storage_path('app/public/archivos'), $nameUnico);

                $envio->archivos()->create([
                    'arc_nombre' => $nombreArchivo,
                    'arc_file' => $nameUnico,
                ]);
            }
        }

        Mail::to($user->email, $user->name)->send(
            new EnviarResultados($envio->env_id, $user->id)
        );

        return redirect()->back();
    }
}
