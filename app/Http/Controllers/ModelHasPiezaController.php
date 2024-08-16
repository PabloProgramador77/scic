<?php

namespace App\Http\Controllers;

use App\Models\ModelHasPieza;
use Illuminate\Http\Request;
use App\Http\Requests\Modelo\Piezas;

class ModelHasPiezaController extends Controller
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
    public function create( $request, $piezas )
    {
        try {
            
            if( count( $piezas ) > 0 ){

                foreach( $piezas as $pieza){

                    $modelHasPieza = ModelHasPieza::create([

                        'idModelo' => $request->id,
                        'idPieza' => $pieza->id,
                        'cantidad' => $pieza->cantidad,

                    ]);

                }

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Piezas $request)
    {
        try {
            
            $modHasPza = ModelHasPieza::create([

                'idModelo' => $request->idModelo,
                'idPieza' => $request->idPieza,
                'cantidad' => $request->cantidad

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
    public function show(ModelHasPieza $modelHasPieza)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModelHasPieza $modelHasPieza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModelHasPieza $modelHasPieza)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModelHasPieza $modelHasPieza)
    {
        //
    }
}
