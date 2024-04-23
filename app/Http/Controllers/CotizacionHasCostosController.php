<?php

namespace App\Http\Controllers;

use App\Models\CotizacionHasCostos;
use Illuminate\Http\Request;

class CotizacionHasCostosController extends Controller
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
    public function store(Request $request, $idCotizacion)
    {
        try {
            
            foreach( $request->costos as $costo ){

                $cotizacionHasCostos = CotizacionHasCostos::create([

                    'idCotizacion' => $idCotizacion,
                    'idCosto' => $costo

                ]);

            }

            return true;

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

            return false;
            
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CotizacionHasCostos $cotizacionHasCostos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionHasCostos $cotizacionHasCostos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotizacionHasCostos $cotizacionHasCostos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasCostos $cotizacionHasCostos)
    {
        //
    }
}
