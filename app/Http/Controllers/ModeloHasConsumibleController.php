<?php

namespace App\Http\Controllers;

use App\Models\ModeloHasConsumible;
use App\Models\Consumible;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloHasConsumible\Create;
use App\Http\Requests\ModeloHasConsumible\Read;

class ModeloHasConsumibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        try {
            
            if( auth()->user()->id ){

                $modelo = Modelo::find( $request->id );

                $configurados = $modelo->consumibles;

                $consumibles = Consumible::all();
    
                if( count( $consumibles ) > 0 ){

                    $datos['exito'] = true;
                    $datos['consumibles'] = $consumibles;
                    $datos['configurados'] = $configurados;

                }   
    
            }else{
    
                $datos['exito'] = false;
                $datos['mensaje'] = 'Sin consumibles registrados. Agregalos ahora.';
                $datos['url'] = '/consumibles';
    
            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
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
    public function store(Create $request)
    {
        try {

            $consumibles = ModeloHasConsumible::where('idModelo', '=', $request->modelo)->get();

            if( count( $consumibles ) > 0 ){

                foreach( $consumibles as $consumible ){

                    $consumible->delete();

                }

                foreach( $request->consumibles as $consumible ){

                    $modeloHasConsumible = ModeloHasConsumible::create([
    
                        'idModelo' => $request->modelo,
                        'idConsumible' => $consumible
    
                    ]);
    
                }
    
                $datos['exito'] = true;

            }else{

                foreach( $request->consumibles as $consumible ){

                    $modeloHasConsumible = ModeloHasConsumible::create([
    
                        'idModelo' => $request->modelo,
                        'idConsumible' => $consumible
    
                    ]);
    
                }
    
                $datos['exito'] = true;

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
    public function show(Read $request)
    {
        try {
            
            $consumibles = Consumible::select('consumibles.id', 'consumibles.nombre', 'consumibles.tipo', 'consumibles.precio')
                        ->join('modelo_has_consumibles', 'consumibles.id', '=', 'modelo_has_consumibles.idConsumible')
                        ->where('modelo_has_consumibles.idModelo', '=', $request->modelo)
                        ->get();

            if( count( $consumibles ) > 0 ){

                $datos['exito'] = true;
                $datos['consumibles'] = $consumibles;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ModeloHasConsumible $modeloHasConsumible)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeloHasConsumible $modeloHasConsumible)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloHasConsumible $modeloHasConsumible)
    {
        //
    }
}
