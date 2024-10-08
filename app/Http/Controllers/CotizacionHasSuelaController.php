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

            if( isset( $request->suelas ) && count( $request->suelas ) > 0 ){

                foreach($request->suelas as $suela){

                    $cotizacionHasSuela = CotizacionHasSuela::create([
    
                        'idCotizacion' => $idCotizacion,
                        'idSuela' => $suela
    
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
    public function edit(CotizacionHasSuela $cotizacionHasSuela)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CotizacionHasSuela $cotizacionHasSuela)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasSuela $cotizacionHasSuela)
    {
        //
    }
}
