<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\Modelo\Create;
use App\Http\Requests\Modelo\Read;
use App\Http\Requests\Modelo\Update;
use App\Http\Requests\Modelo\Delete;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $modelos = Modelo::all();

            return view('modelos.index', compact('modelos'));

        } catch (\Throwable $th) {
            
            return redirect('/');

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
            
            $modelo = Modelo::create([

                'nombre' => $request->nombre,
                'numero' => $request->numero,
                'descripcion' => $request->descripcion

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
    public function show(Read $request)
    {
        try {
            
            $modelo = Modelo::find( $request->id );

            if( $modelo->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $modelo->nombre;
                $datos['numero'] = $modelo->numero;
                $datos['descripcion'] = $modelo->descripcion;
                $datos['id'] = $modelo->id;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Modelo $modelo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $modelo = Modelo::where('id', '=', $request->id )
                    ->update([

                        'nombre' => $request->nombre,
                        'numero' => $request->numero,
                        'descripcion' => $request->descripcion

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
            
            $modelo = Modelo::find( $request->id );

            if( $modelo->id ){

                $modelo->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
