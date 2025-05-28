<?php

namespace App\Http\Controllers;

use App\Models\ModeloHasCoste;
use App\Models\Coste;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloHasCostes\Create;
use App\Http\Requests\ModeloHasCostes\Read;

class ModeloHasCosteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        try{

            if( auth()->user()->id ){

                $modelo = Modelo::find( $request->id );

                $costes = $modelo->costes;
                
                $costos = Coste::all();

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
    public function create( $request, $costes )
    {
        try {
            
            if( count( $costes ) > 0 ){

                foreach( $costes as $coste ){

                    $modeloHasCoste = ModeloHasCoste::create([

                        'idModelo' => $request->id,
                        'idCoste' => $coste->id,

                    ]);

                }

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {

            $costes = ModeloHasCoste::where('idModelo', '=', $request->modelo)->get();

            if( count( $costes ) > 0 ){

                foreach( $costes as $coste ){

                    $coste->delete();

                }

                foreach( $request->costes as $coste ){

                    $modeloHasCoste = ModeloHasCoste::create([
    
                        'idModelo' => $request->modelo,
                        'idCoste' => $coste
    
                    ]);
    
                }
    
                $datos['exito'] = true;

            }else{

                foreach( $request->costes as $coste ){

                    $modeloHasCoste = ModeloHasCoste::create([
    
                        'idModelo' => $request->modelo,
                        'idCoste' => $coste
    
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
            
            $costos = Coste::select('costes.id', 'costes.nombre', 'costes.monto')
                    ->join('modelo_has_costes', 'costes.id', '=', 'modelo_has_costes.idCoste')
                    ->where('modelo_has_costes.idModelo', '=', $request->modelo)
                    ->orderBy('costes.nombre', 'asc')
                    ->get();

            if( count( $costos ) > 0 ){

                $datos['exito'] = true;
                $datos['costos'] = $costos;

            }else{

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
    public function edit(ModeloHasCoste $modeloHasCoste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeloHasCoste $modeloHasCoste)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloHasCoste $modeloHasCoste)
    {
        //
    }
}
