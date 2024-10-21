<?php

namespace App\Http\Controllers;

use App\Models\NotaHasCotizacion;
use Illuminate\Http\Request;
use App\Http\Requests\NotaHasCotizacion\Assign;
use App\Http\Requests\NotaHasCotizacion\Delete;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\NotaController;

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
                'totalPares' => 0,
                'monto' => 0,
                'descuento' => 0,

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
                    'totalPares' => 0,
                    'monto' => 0,
                    'descuento' => 0,
    
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
    public function update(Request $request)
    {
        try {
            
            $total = 0;
            $pares = 0;
            $idNota = 0;

            foreach( $request->pares as $par ){

                $notaHasCotizacion = NotaHasCotizacion::where('idNota', '=', $par['idNota'])
                                    ->where('idCotizacion', '=', $par['idCotizacion'])
                                    ->update([

                                        'totalPares' => $par['pares']

                                    ]);

                $pares += $par['pares'];
                $idNota = $par['idNota'];

            }

            foreach( $request->montos as $monto ){

                $notaHasCotizacion = NotaHasCotizacion::where('idNota', '=', $monto['idNota'])
                                    ->where('idCotizacion', '=', $monto['idCotizacion'])
                                    ->update([

                                        'monto' => $monto['monto']

                                    ]);

                $total += $monto['monto'];

            }

            foreach( $request->descuentos as $descuento ){

                $notaHasCotizacion = NotaHasCotizacion::where('idNota', '=', $descuento['idNota'])
                                    ->where('idCotizacion', '=', $descuento['idCotizacion'])
                                    ->update([

                                        'descuento' => $descuento['descuento'],

                                    ]);
            }

            $nota = new NotaController();
            
            if( $nota->update( $pares, $total, $idNota, $request->dias ) ){

                return true;

            }else{

                return false;

            }

        } catch (\Throwable $th) {
            
            return false;

        }
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
