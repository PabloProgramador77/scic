<?php

namespace App\Http\Controllers;

use App\Models\CotizacionHasSuela;
use Illuminate\Http\Request;

class CotizacionHasSuelaController extends Controller
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

            $cotizacionHasSuelas = CotizacionHasSuela::where('idCotizacion', $idCotizacion)->get();

            if( count( $cotizacionHasSuelas ) > 0 ){

                foreach($cotizacionHasSuelas as $cotizacionHasSuela){

                    $nuevaCotizacionHasSuela = $cotizacionHasSuela->replicate();
                    $nuevaCotizacionHasSuela->idCotizacion = $cotizacionId;
                    $nuevaCotizacionHasSuela->save();
    
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

            if( isset( $request->suelas ) && count( $request->suelas ) > 0 ){

                foreach($request->suelas as $suela){

                    CotizacionHasSuela::create([
    
                        'idCotizacion' => $idCotizacion,
                        'idSuela' => $suela,
                        'colorPiso' => $request->piso,
                        'colorCuna' => $request->cuna,
    
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
    public function show(CotizacionHasSuela $cotizacionHasSuela)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( Request $request )
    {
        try{

            CotizacionHasSuela::where('idCotizacion', '=', $request->id)
                                ->update([

                                    'colorPiso' => $request->piso,
                                    'colorCuna' => $request->cuna,

                                ]);

            $datos['exito'] = true;

        }catch(\Throwable $th){

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }finally{

            return response()->json( $datos );
            
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            
            $suelasCotizacion = CotizacionHasSuela::where('idCotizacion', $request->id)->get();

            if( count( $suelasCotizacion ) > 0 ){

                foreach( $suelasCotizacion as $suela ){

                    $suela->delete();

                }

                foreach( $request->suelas as $suela ){

                    CotizacionHasSuela::create([

                        'idCotizacion' => $request->id,
                        'idSuela' => $suela,
                        'colorPiso' => $request->piso,
                        'colorCuna' => $request->cuna,

                    ]);

                }

            }else{

                foreach( $request->suelas as $suela ){

                    CotizacionHasSuela::create([

                        'idCotizacion' => $request->id,
                        'idSuela' => $suela,
                        'colorPiso' => $request->piso,
                        'colorCuna' => $request->cuna,
                        
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
    public function destroy(CotizacionHasSuela $cotizacionHasSuela)
    {
        //
    }
}
