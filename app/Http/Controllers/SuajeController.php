<?php

namespace App\Http\Controllers;

use App\Models\Suaje;
use Illuminate\Http\Request;
use App\Http\Requests\Suaje\Create;
use App\Http\Requests\Suaje\Read;
use App\Http\Requests\Suaje\Update;
use App\Http\Requests\Suaje\Delete;

class SuajeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $suajes = Suaje::orderBy('nombre', 'asc')->get();

            return view('suajes.index', compact('suajes'));

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

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
            
            $suaje = Suaje::create([

                'nombre' => $request->nombre,
                'numero' => $request->numero,
                'descripcion' => $request->descripcion,

            ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Display the specified resource.
     */
    public function show(Read $suaje)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suaje $suaje)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $suaje = Suaje::where('id', '=', $request->id)
                    ->update([

                        'nombre' => $request->nombre,
                        'numero' => $request->numero,
                        'descripcion' => $request->descripcion,

                    ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $suaje = Suaje::find( $request->id );

            if( $suaje->id ){

                $suaje->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
