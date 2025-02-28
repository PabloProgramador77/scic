<?php

namespace App\Http\Controllers;

use App\Models\CotizacionHasCoste;
use Illuminate\Http\Request;

class CotizacionHasCosteController extends Controller
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

            $cotizacionHasCostes = CotizacionHasCoste::where('idCotizacion', $idCotizacion)->get();

            if( count( $cotizacionHasCostes ) > 0 ){

                foreach($cotizacionHasCostes as $cotizacionHasCoste){

                    $nuevaCotizacionHasCoste = $cotizacionHasCoste->replicate();
                    $nuevaCotizacionHasCoste->idCotizacion = $cotizacionId;
                    $nuevaCotizacionHasCoste->save();
    
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

            if( isset( $request->costes) && count( $request->costes ) > 0 ){

                foreach( $request->costes as $coste ){

                    $cotizacionHasCostes = CotizacionHasCoste::create([
    
                        'idCotizacion' => $idCotizacion,
                        'idCoste' => $coste
    
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
    public function show(CotizacionHasCoste $cotizacionHasCoste)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CotizacionHasCoste $cotizacionHasCoste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try{

            $costesCotizacion = CotizacionHasCoste::where('idCotizacion', '=', $request->id)->get();

            if( count( $costesCotizacion ) > 0 ){

                foreach( $costesCotizacion as $coste ){
                    
                    $coste->delete();

                }

                foreach( $request->costes as $coste ){
                    
                    CotizacionHasCoste::create([
    
                        'idCotizacion' => $request->id,
                        'idCoste' => $coste
    
                    ]);

                }

            }else{

                foreach( $request->costes as $coste ){
                    
                    CotizacionHasCoste::create([
    
                        'idCotizacion' => $request->id,
                        'idCoste' => $coste
    
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
    public function destroy(CotizacionHasCoste $cotizacionHasCoste)
    {
        //
    }
}
