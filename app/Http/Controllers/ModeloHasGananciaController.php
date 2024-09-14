<?php

namespace App\Http\Controllers;

use App\Models\ModeloHasGanancia;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloHasGanancia\Create;

class ModeloHasGananciaController extends Controller
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
    public function store(Create $request)
    {
        try {
        
            $modeloHasGanancia = ModeloHasGanancia::where('id', '=', 1)
                                ->update([

                'ganancia' => $request->ganancia,

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
    public function show(Request $request)
    {
        try {
            
            $modeloHasGanancia = ModeloHasGanancia::find( 1 );

            $datos['exito'] = true;
            $datos['ganancia'] = $modeloHasGanancia->ganancia;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModeloHasGanancia $modeloHasGanancia)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeloHasGanancia $modeloHasGanancia)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloHasGanancia $modeloHasGanancia)
    {
        //
    }
}
