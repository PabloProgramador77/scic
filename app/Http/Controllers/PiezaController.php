<?php

namespace App\Http\Controllers;

use App\Models\Pieza;
use Illuminate\Http\Request;
use App\Http\Requests\Pieza\Create;
use App\Http\Requests\Pieza\Read;
use App\Http\Requests\Pieza\Update;
use App\Http\Requests\Pieza\Delete;

class PiezaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            if( auth()->user()->id ){

                $piezas = Pieza::orderBy('nombre', 'asc')->get();

                return view('piezas.index', compact('piezas'));

            }else{

                return redirect('/');

            }

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
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
            
            $pieza = Pieza::create([

                'nombre' => $request->nombre,
                'alto' => $request->alto,
                'largo' => $request->largo,
                'descripcion' => $request->descripcion,
                'idModelo' => $request->idModelo,
                'cantidad' => $request->cantidad,

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
            
            $pieza = Pieza::find( $request->id );

            if( $pieza->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $pieza->nombre;
                $datos['alto'] = $pieza->alto;
                $datos['largo'] = $pieza->largo;
                $datos['cantidad'] = $pieza->cantidad;
                $datos['descripcion'] = $pieza->descripcion;
                $datos['id'] = $pieza->id;

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
    public function edit(Pieza $pieza)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $pieza = Pieza::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre,
                    'alto' => $request->alto,
                    'largo' => $request->largo,
                    'cantidad' => $request->cantidad,
                    'descripcion' => $request->descripcion,
                    'idModelo' => $request->idModelo,

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
            
            $pieza = Pieza::find( $request->id );

            if( $pieza->id ){

                $pieza->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
