<?php

namespace App\Http\Controllers;

use App\Models\ModeloHasCosto;
use App\Models\Costo;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloHasCostos\Create;

class ModeloHasCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            if( auth()->user()->id ){

                $costos = Costo::all();

                if( count( $costos ) > 0 ){

                    $datos['exito'] = true;
                    $datos['costos'] = $costos;

                }

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Sin costos registrados. Agregalos ahora';
                $datos['url'] = '/costos';

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
    public function store(Create $request)
    {
        try {
            
            foreach( $request->costos as $costo ){

                $modeloHasCosto = ModeloHasCosto::create([

                    'idModelo' => $request->modelo,
                    'idCosto' => $costo

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
    public function show(ModeloHasCosto $modeloHasCosto)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModeloHasCosto $modeloHasCosto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeloHasCosto $modeloHasCosto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloHasCosto $modeloHasCosto)
    {
        //
    }
}
