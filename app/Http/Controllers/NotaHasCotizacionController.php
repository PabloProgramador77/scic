<?php

namespace App\Http\Controllers;

use App\Models\NotaHasCotizacion;
use Illuminate\Http\Request;
use App\Http\Controllers\CotizacionController;

class NotaHasCotizacionController extends Controller
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
    public function store( $idNota, Request $request)
    {
        try {
            
            foreach( $request->cotizaciones as $cotizacion ){

                $notaHasCotizacion = NotaHasCotizacion::create([

                    'idNota' => $idNota,
                    'idCotizacion' => $cotizacion,
    
                ]);

            }

            $cotizacionController = new CotizacionController();
            if( $cotizacionController->edit( $request ) ){

                return true;

            }

        } catch (\Throwable $th) {
            
            return false;

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(NotaHasCotizacion $notaHasCotizacion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotaHasCotizacion $notaHasCotizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, NotaHasCotizacion $notaHasCotizacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotaHasCotizacion $notaHasCotizacion)
    {
        //
    }
}
