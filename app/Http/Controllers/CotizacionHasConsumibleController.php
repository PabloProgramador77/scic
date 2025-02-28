<?php

namespace App\Http\Controllers;

use App\Models\CotizacionHasConsumible;
use Illuminate\Http\Request;

class CotizacionHasConsumibleController extends Controller
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

            $cotizacionHasConsumibles = CotizacionHasConsumible::where('idCotizacion', $idCotizacion)->get();

            if( count( $cotizacionHasConsumibles ) > 0 ){

                foreach($cotizacionHasConsumibles as $cotizacionHasConsumible){

                    $nuevaCotizacionHasConsumible = $cotizacionHasConsumible->replicate();
                    $nuevaCotizacionHasConsumible->idCotizacion = $cotizacionId;
                    $nuevaCotizacionHasConsumible->save();
    
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

            if( isset( $request->consumibles) && count( $request->consumibles ) > 0 ){

                foreach($request->consumibles as $consumible){

                    $cotizacionHasConsumible = CotizacionHasConsumible::create([
    
                        'idCotizacion' => $idCotizacion,
                        'idConsumible' => $consumible
    
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
    public function show(CotizacionHasConsumible $cotizacionHasConsumible)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionHasConsumible $cotizacionHasConsumible)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{

            $consumiblesCotizacion = CotizacionHasConsumible::where('idCotizacion', '=', $request->id)->get();

            if( count( $consumiblesCotizacion ) > 0 ){

                foreach( $consumiblesCotizacion as $consumible ){
                    
                    $consumible->delete();

                }

                foreach( $request->consumibles as $consumible ){
                    
                    CotizacionHasConsumible::create([
    
                        'idCotizacion' => $request->id,
                        'idConsumible' => $consumible
    
                    ]);

                }

            }else{

                foreach( $request->consumibles as $consumible ){
                    
                    CotizacionHasConsumible::create([
    
                        'idCotizacion' => $request->id,
                        'idConsumible' => $consumible
    
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
    public function destroy(CotizacionHasConsumible $cotizacionHasConsumible)
    {
        //
    }
}
