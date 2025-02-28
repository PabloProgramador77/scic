<?php

namespace App\Http\Controllers;

use App\Models\CotizacionHasNumeraciones;
use Illuminate\Http\Request;
use App\Http\Requests\CotizacionHasNumeraciones\Create;
use App\Http\Controllers\NotaHasCotizacionController;

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
    public function create( $idCotizacion, $cotizacionId)
    {
        try {

            $cotizacionHasNumeraciones = CotizacionHasNumeraciones::where('idCotizacion', $idCotizacion)->get();

            if( count( $cotizacionHasNumeraciones ) > 0 ){

                foreach($cotizacionHasNumeraciones as $cotizacionHasNumeracione){

                    $nuevaCotizacionHasNumeracione = $cotizacionHasNumeracione->replicate();
                    $nuevaCotizacionHasNumeracione->idCotizacion = $cotizacionId;
                    $nuevaCotizacionHasNumeracione->save();
    
                }

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {
            
            
            foreach( $request->numeraciones as $numeracion ){

                $cotizacionHasNumeraciones = CotizacionHasNumeraciones::where('idCotizacion', '=', $numeracion['idCotizacion'] )
                                            ->where('idNumeracion', '=', $numeracion['idNumeracion'])
                                            ->first();

                if( $cotizacionHasNumeraciones ){

                    $cotizacionHasNumeraciones->update([

                        'cantidad' => $numeracion['cantidad']

                    ]);
                    
                }else{

                    $cotizacionHasNumeraciones = CotizacionHasNumeraciones::create([

                        'idCotizacion' => $numeracion['idCotizacion'],
                        'idNumeracion' => $numeracion['idNumeracion'],
                        'cantidad' => $numeracion['cantidad'],
    
                    ]);

                }

            }

            $notaHasCotizacionController = new NotaHasCotizacionController();
            if( $notaHasCotizacionController->update( $request ) ){

                $datos['exito'] = true;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Montos de nota incompletos';

            }

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
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $idCotizacion )
    {
        try {
            
            $cotizacionHasNumeraciones = CotizacionHasNumeraciones::where('idCotizacion', '=', $idCotizacion )->get();

            if( count( $cotizacionHasNumeraciones ) > 0 ){

                foreach( $cotizacionHasNumeraciones as $numeracion ){

                    $numeracion->delete();

                }

            }

            return true;

        } catch (\Throwable $th) {
            
            return false;

        }
    }
}
