<?php

namespace App\Http\Controllers;

use App\Models\CotizacionHasNumeraciones;
use Illuminate\Http\Request;
use App\Http\Requests\CotizacionHasNumeraciones\Create;

class CotizacionHasNumeracionesController extends Controller
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
            
            foreach( $request->cotizaciones as $cotizacion ){

                foreach( $request->numeraciones as $numeracion ){

                    $cotizacionHasNumeraciones = CotizacionHasNumeraciones::create([

                        'idCotizacion' => $cotizacion,
                        'idNumeracion' => $numeracion['id'],
                        'cantidad' => $numeracion['cantidad'],

                    ]);

                }

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
    public function show(CotizacionHasNumeraciones $cotizacionHasNumeraciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionHasNumeraciones $cotizacionHasNumeraciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotizacionHasNumeraciones $cotizacionHasNumeraciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasNumeraciones $cotizacionHasNumeraciones)
    {
        //
    }
}
