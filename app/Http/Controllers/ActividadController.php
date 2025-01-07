<?php

namespace App\Http\Controllers;

use App\Models\Actividad;
use Illuminate\Http\Request;
use App\Http\Requests\Actividades\Create;
use App\Http\Requests\Actividades\Update;
use App\Http\Requests\Actividades\Delete;
use App\Models\User;

class ActividadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $actividades = Actividad::all();
            $usuarios = User::all();

            return view('actividades.index', compact('actividades', 'usuarios'));

        } catch (\Throwable $th) {
            
            return redirect()->route('login');

        }
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
    public function store(Create $request)
    {
        try {
            
            $actividad = Actividad::create([

                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'orden' => $request->orden,
                'duracion' => $request->duracion,
                'idProceso' => $request->idProceso,
                'idUsuario' => $request->idUsuario,
                'tipo' => $request->tipo

            ]);

            if( $actividad->id ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Display the specified resource.
     */
    public function show(Actividad $actividad)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Actividad $actividad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $actividad = Actividad::find($request->id);

            $actividad->nombre = $request->nombre;
            $actividad->descripcion = $request->descripcion;
            $actividad->orden = $request->orden;
            $actividad->duracion = $request->duracion;
            $actividad->idUsuario = $request->idUsuario;
            $actividad->tipo = $request->tipo;

            if( $actividad->save() ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();
        }

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $actividad = Actividad::find($request->id);

            if( $actividad->delete() ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }
}
