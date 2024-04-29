<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Modelo;
use App\Models\Pieza;
use App\Models\Material;
use App\Models\Costo;
use App\Models\Nota;
use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Requests\Cotizacion\Modelos;
use App\Http\Requests\Cotizacion\Create;
use App\Http\Requests\Cotizacion\Delete;
use App\Http\Controllers\CotizacionHasPiezasController;
use App\Http\Controllers\CotizacionHasCostosController;
use App\Http\Controllers\CotizacionHasConsumibleController;
use App\Http\Controllers\CotizacionHasSuelaController;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $cotizaciones = Cotizacion::all();
            $clientes = Cliente::all();

            return view('cotizacion.index', compact('cotizaciones', 'clientes'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            
            $modelos = Modelo::all();

            return view('cotizacion.cotizador', compact('modelos'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {
            
            $cotizacion = Cotizacion::create([

                'precio' => $request->total,
                'estado' => 'Pendiente',
                'idModelo' => $request->modelo,

            ]);

            $idCotizacion = $cotizacion->id;

            $cotizacionHasPiezaController = new CotizacionHasPiezasController();

            if( $cotizacionHasPiezaController->store( $request, $idCotizacion ) ){

                $cotizacionHasCostosController = new CotizacionHasCostosController();

                if( $cotizacionHasCostosController->store( $request, $idCotizacion ) ){

                    $cotizacionHasConsumibleController = new CotizacionHasConsumibleController();

                    if( $cotizacionHasConsumibleController->store( $request, $idCotizacion ) ){

                        $cotizacionHasSuelaController = new CotizacionHasSuelaController();

                        if( $cotizacionHasSuelaController->store( $request, $idCotizacion ) ){

                            $datos['exito'] = true;

                        }else{

                            $datos['exito'] = false;
                            $datos['mensaje'] = 'Suelas no registradas';

                        }

                    }else{

                        $datos['exito'] = false;
                        $datos['mensaje'] = 'Consumibles no registrados';

                    }

                }else{

                    $datos['exito'] = false;
                    $datos['mensaje'] = 'Costos no registrados';

                }

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Piezas no registradas.';

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
    public function show(Modelos $request)
    {
        try {
            
            $piezas = Pieza::select('piezas.id', 'piezas.nombre', 'piezas.alto', 'piezas.largo', 'piezas.idModelo', 'piezas.cantidad')
                            ->where('piezas.idModelo', '=', $request->id)
                            ->get();

            $materiales = Material::all();

            $datos['exito'] = true;
            $datos['piezas'] = $piezas;
            $datos['materiales'] = $materiales;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $cotizacion = Cotizacion::find( $request->id );

            if( $cotizacion->id ){

                $cotizacion->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
