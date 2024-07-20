<?php

namespace App\Http\Controllers;

use App\Models\ModeloHasCosto;
use App\Models\Costo;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloHasCostos\Create;
use App\Http\Requests\ModeloHasCostos\Read;

class ModeloHasCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        try {
            
            if( auth()->user()->id ){

                $modelo = Modelo::find( $request->id );

                $costes = $modelo->costos;
                
                $costos = Costo::all();

                if( count( $costos ) > 0 ){

                    $datos['exito'] = true;
                    $datos['costos'] = $costos;
                    $datos['costes'] = $costes;

                }

            }else{

                return redirect('/');

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

            $costos = ModeloHasCosto::where('idModelo', '=', $request->modelo)->get();

            if( count( $costos ) > 0 ){

                foreach( $costos as $costo ){

                    $costo->delete();

                }

                foreach( $request->costos as $costo ){

                    $modeloHasCosto = ModeloHasCosto::create([
    
                        'idModelo' => $request->modelo,
                        'idCosto' => $costo
    
                    ]);
    
                }
    
                $datos['exito'] = true;

            }else{

                foreach( $request->costos as $costo ){

                    $modeloHasCosto = ModeloHasCosto::create([
    
                        'idModelo' => $request->modelo,
                        'idCosto' => $costo
    
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
            
            $costos = Costo::select('costos.id', 'costos.nombre', 'costos.total')
                    ->join('modelo_has_costos', 'costos.id', '=', 'modelo_has_costos.idCosto')
                    ->where('modelo_has_costos.idModelo', '=', $request->modelo)
                    ->get();

            if( count( $costos ) > 0 ){

                $datos['exito'] = true;
                $datos['costos'] = $costos;

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
    public function edit(ModeloHasCosto $modeloHasCosto)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeloHasCosto $modeloHasCosto)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloHasCosto $modeloHasCosto)
    {
        //
    }
}
