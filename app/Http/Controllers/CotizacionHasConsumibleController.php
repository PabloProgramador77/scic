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
    public function update(Request $request, CotizacionHasConsumible $cotizacionHasConsumible)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasConsumible $cotizacionHasConsumible)
    {
        //
    }
}
