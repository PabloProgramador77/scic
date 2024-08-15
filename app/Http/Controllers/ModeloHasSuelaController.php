<?php

namespace App\Http\Controllers;

use App\Models\ModeloHasSuela;
use App\Models\Suela;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Http\Requests\ModeloHasSuela\Create;
use App\Http\Requests\ModeloHasSuela\Read;

class ModeloHasSuelaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Request $request )
    {
        try {

            $modelo = Modelo::find( $request->id );
        
            $suelas = Suela::all();

            $configuradas = $modelo->suelas;

            if( count( $suelas ) > 0 ){

                $datos['exito'] = true;
                $datos['suelas'] = $suelas;
                $datos['configuradas'] = $configuradas;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Sin suelas registradas. Agregalas ahora';
                $datos['url'] = '/suelas';

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
    public function create( $request, $suelas )
    {
        try {
            
            if( count( $suelas ) > 0 ){

                foreach( $suelas as $suela ){

                    $modeloHasSuela = ModeloHasSuela::create([

                        'idModelo' => $request->id,
                        'idSuela' => $suela->id,

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

            $suelas = ModeloHasSuela::where('idModelo', '=', $request->modelo)->get();

            if( count( $suelas ) > 0 ){

                foreach( $suelas as $suela ){

                    $suela->delete();

                }

                foreach( $request->suelas as $suela ){

                    $modeloHasSuela = ModeloHasSuela::create([
    
                        'idModelo' => $request->modelo,
                        'idSuela' => $suela
    
                    ]);
    
                }
    
                $datos['exito'] = true;

            }else{

                foreach( $request->suelas as $suela ){

                    $modeloHasSuela = ModeloHasSuela::create([
    
                        'idModelo' => $request->modelo,
                        'idSuela' => $suela
    
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
            
            $suelas = Suela::select('suelas.id', 'suelas.nombre', 'suelas.precio', 'suelas.descripcion')
                    ->join('modelo_has_suelas', 'suelas.id', '=', 'modelo_has_suelas.idSuela')
                    ->where('modelo_has_suelas.idModelo', '=', $request->modelo)
                    ->get();

            if( count( $suelas ) > 0 ){

                $datos['exito'] = true;
                $datos['suelas'] = $suelas;

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
    public function edit(ModeloHasSuela $modeloHasSuela)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ModeloHasSuela $modeloHasSuela)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ModeloHasSuela $modeloHasSuela)
    {
        //
    }
}
