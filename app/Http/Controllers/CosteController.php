<?php

namespace App\Http\Controllers;

use App\Models\Coste;
use Illuminate\Http\Request;
use App\Http\Requests\Coste\Create;
use App\Http\Requests\Coste\Read;
use App\Http\Requests\Coste\Update;
use App\Http\Requests\Coste\Delete;

class CosteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $costes = Coste::orderBy('nombre', 'asc')->get();

            return view('costes.index', compact('costes'));

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
            
            $coste = Coste::create([

                'nombre' => $request->nombre,
                'monto' => $request->monto,
                'descripcion' => $request->descripcion,

            ]);

            if( $coste->id ){

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
            
            $coste = Coste::find( $request->id );

            if( $coste->id ){

                $datos['exito'] = true;
                $datos['id'] = $coste->id;
                $datos['nombre'] = $coste->nombre;
                $datos['monto'] = $coste->monto;
                $datos['descripcion'] = $coste->descripcion;

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
    public function edit(Coste $coste)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $coste = Coste::where('id', '=', $request->id)
                        ->update([

                            'nombre' => $request->nombre,
                            'monto' => $request->monto,
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
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $coste = Coste::find( $request->id );

            if( $coste->id ){

                $coste->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
