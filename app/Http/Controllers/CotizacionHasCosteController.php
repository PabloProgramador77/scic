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
    public function update(Request $request, CotizacionHasCoste $cotizacionHasCoste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasCoste $cotizacionHasCoste)
    {
        //
    }
}
