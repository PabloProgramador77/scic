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
    public function update(Request $request, CotizacionHasPiezas $cotizacionHasPiezas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CotizacionHasPiezas $cotizacionHasPiezas)
    {
        //
    }
}
