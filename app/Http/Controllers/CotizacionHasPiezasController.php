<?php

namespace App\Http\Controllers;

use App\Models\CotizacionHasPiezas;
use Illuminate\Http\Request;

class CotizacionHasPiezasController extends Controller
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
    public function create( $idCotizacion, $cotizacionId )
    {
        try {

            $cotizacionHasPiezas = CotizacionHasPiezas::where('idCotizacion', $idCotizacion)->get();

            if( count( $cotizacionHasPiezas ) > 0 ){

                foreach($cotizacionHasPiezas as $cotizacionHasPieza){

                    $nuevaCotizacionHasPieza = $cotizacionHasPieza->replicate();
                    $nuevaCotizacionHasPieza->idCotizacion = $cotizacionId;
                    $nuevaCotizacionHasPieza->save();
    
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

            if( isset( $request->piezas) && count( $request->piezas ) > 0 ){

                $piezas = $request->piezas;
                $materiales = $request->materiales;
                $colores = $request->colores;
                
                for($i = 0; $i < count($request->piezas); $i++){

                    $cotizacionHasPiezas = CotizacionHasPiezas::create([

                        'idCotizacion' => $idCotizacion,
                        'idPieza' => $piezas[$i],
                        'idMaterial' => $materiales[$i],
                        'colorMaterial' => $colores[$i],

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
    public function show(CotizacionHasPiezas $cotizacionHasPiezas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionHasPiezas $cotizacionHasPiezas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
    
            $cotizacionHasPiezas = CotizacionHasPiezas::where('idCotizacion', '=', $request->id)->get();

            if( count( $cotizacionHasPiezas ) > 0 ){

                foreach( $cotizacionHasPiezas as $pieza ){
                    
                    $pieza->delete();   

                }

                $piezas = $request->piezas;
                $materiales = $request->materiales;
                $colores = $request->colores;
                
                for($i = 0; $i < count($request->piezas); $i++){

                    $cotizacionHasPiezas = CotizacionHasPiezas::create([

                        'idCotizacion' => $request->id,
                        'idPieza' => $piezas[$i],
                        'idMaterial' => $materiales[$i],
                        'colorMaterial' => $colores[$i],

                    ]);

                }

            }else{

                $piezas = $request->piezas;
                $materiales = $request->materiales;
                $colores = $request->colores;
                
                for($i = 0; $i < count($request->piezas); $i++){

                    $cotizacionHasPiezas = CotizacionHasPiezas::create([

                        'idCotizacion' => $request->id,
                        'idPieza' => $piezas[$i],
                        'idMaterial' => $materiales[$i],
                        'colorMaterial' => $colores[$i],

                    ]);

                }

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasPiezas $cotizacionHasPiezas)
    {
        //
    }
}
