<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Models\Pieza;
use Illuminate\Http\Request;
use App\Http\Requests\Modelo\Create;
use App\Http\Requests\Modelo\Read;
use App\Http\Requests\Modelo\Update;
use App\Http\Requests\Modelo\Delete;
use App\Models\Suaje;
use Illuminate\Support\Facades\Hash;

class ModeloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $modelos = Modelo::orderBy('nombre', 'asc')->get();

            return view('modelos.index', compact('modelos'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        try {
            
            $modelo = Modelo::find( $id );
            $piezas = Pieza::where('idModelo', '=', $modelo->id)->get();
            $suajes = Suaje::orderBy('nombre', 'asc')->get();

            return view('modelos.piezas', compact('modelo', 'piezas', 'suajes'));

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
            
            $modelo = Modelo::create([

                'nombre' => $request->nombre,
                'numero' => $request->numero,
                'horma' => $request->horma,
                'descripcion' => $request->descripcion,

            ]);

            $datos['exito'] = true;

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
            
            $modelo = Modelo::find( $request->id );

            if( $modelo->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $modelo->nombre;
                $datos['numero'] = $modelo->numero;
                $datos['horma'] = $modelo->horma;
                $datos['descripcion'] = $modelo->descripcion;
                $datos['id'] = $modelo->id;

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
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $modelo = Modelo::where('id', '=', $request->id )
                    ->update([

                        'nombre' => $request->nombre,
                        'numero' => $request->numero,
                        'horma' => $request->horma,
                        'descripcion' => $request->descripcion

                    ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $modelo = Modelo::find( $request->id );

            if( $modelo->id ){

                $modelo->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Encriptación de Modelos
     */
    public function encriptacion( Request $request ){
        try {
            
            $modelo = Modelo::find( $request->modelo );

            if( $modelo->id ){

                $cadenaVariante = '|'.$modelo->nombre.'|'.$modelo->numero;

                foreach( $modelo->piezas as $pieza ){

                    $cadenaVariante .= '|'.$pieza->nombre;

                }

                foreach( $modelo->consumibles as $consumible ){

                    $cadenaVariante .= '|'.$consumible->nombre;

                }

                foreach( $modelo->suelas as $suela ){

                    $cadenaVariante .= '|'.$suela->nombre;

                }

                $modelo->variante = $cadenaVariante;
                $modelo->save();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
