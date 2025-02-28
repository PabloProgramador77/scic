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
    public function create( $idCotizacion, $cotizacionId)
    {
        try {

            $cotizacionHasCostos = CotizacionHasCostos::where('idCotizacion', $idCotizacion)->get();

            if( count( $cotizacionHasCostos ) > 0 ){

                foreach($cotizacionHasCostos as $cotizacionHasCosto){

                    $nuevaCotizacionHasCosto = $cotizacionHasCosto->replicate();
                    $nuevaCotizacionHasCosto->idCotizacion = $cotizacionId;
                    $nuevaCotizacionHasCosto->save();
    
                }

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $idCotizacion)
    {
        try {
            
            if( isset( $request->costos) && count( $request->costos ) > 0 ){

                foreach( $request->costos as $costo ){

                    $cotizacionHasCostos = CotizacionHasCostos::create([
    
                        'idCotizacion' => $idCotizacion,
                        'idCosto' => $costo
    
                    ]);
    
                }
    
                return true;

            }else{

                return true;

            }

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
    public function update(Request $request)
    {
        try{

            $costosCotizacion = CotizacionHasCostos::where('idCotizacion', '=', $request->id)->get();

            if( count( $costosCotizacion ) > 0 ){

                foreach( $costosCotizacion as $costo ){
                    
                    $costo->delete();

                }

                foreach( $request->costos as $costo ){
                    
                    CotizacionHasCostos::create([
    
                        'idCotizacion' => $request->id,
                        'idCosto' => $costo
    
                    ]);

                }

            }else{

                foreach( $request->costos as $costo ){
                    
                    CotizacionHasCostos::create([
    
                        'idCotizacion' => $request->id,
                        'idCosto' => $costo
    
                    ]);

                }

            }

        }catch(\Throwable $th){

            echo $th->getMessage();

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasCostos $cotizacionHasCostos)
    {
        //
    }
}
