<?php

namespace App\Http\Controllers;

use App\Models\ModeloHasNumeraciones;
use App\Models\Numeracion;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloHasNumeraciones\Read;
use App\Http\Requests\ModeloHasNumeraciones\Create;

class ModeloHasNumeracionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Read $request)
    {
        try {
            
            $numeraciones = Numeracion::all();

            if( count( $numeraciones ) > 0 ){

                $datos['exito'] = true;
                $datos['numeraciones'] = $numeraciones;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Sin numeraciones registradas. Agregalas ahora.';
                $datos['url'] = '/numeraciones';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
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
    public function store(create $request)
    {
        try {
            
            foreach($request->numeraciones as $numeracion){

                $modeloHasNumeraciones = ModeloHasNumeraciones::create([

                    'idModelo' => $request->modelo,
                    'idNumeracion' => $numeracion,

                ]);

            }

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
    public function show(ModeloHasNumeraciones $modeloHasNumeraciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModeloHasNumeraciones $modeloHasNumeraciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeloHasNumeraciones $modeloHasNumeraciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloHasNumeraciones $modeloHasNumeraciones)
    {
        //
    }
}
