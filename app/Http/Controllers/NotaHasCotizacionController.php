<?php

namespace App\Http\Controllers;

use App\Models\NotaHasCotizacion;
use Illuminate\Http\Request;
use App\Http\Requests\NotaHasCotizacion\Assign;
use App\Http\Requests\NotaHasCotizacion\Delete;
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
    public function create( Assign $request)
    {
        try {
            
            $notaHasCotizacion = NotaHasCotizacion::create([

                'idNota' => $request->nota,
                'idCotizacion' => $request->cotizacion,

            ]);

            $cotizacionController = new CotizacionController();

            if( $cotizacionController->update( $request ) ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
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
    public function destroy(Delete $request)
    {
        try {
            
            $notaHasCotizacion = NotaHasCotizacion::find( $request->id );

            if( $notaHasCotizacion->id ){

                $notaHasCotizacion->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
