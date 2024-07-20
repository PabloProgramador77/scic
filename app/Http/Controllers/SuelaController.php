<?php

namespace App\Http\Controllers;

use App\Models\Suela;
use Illuminate\Http\Request;
use App\Http\Requests\Suela\Create;
use App\Http\Requests\Suela\Read;
use App\Http\Requests\Suela\Update;
use App\Http\Requests\Suela\Delete;

class SuelaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            if( auth()->user()->id ){

                $suelas = Suela::orderBy('nombre', 'asc')->get();

                return view('suelas.index', compact('suelas'));

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
            
            $suela = Suela::create([

                'nombre' => $request->nombre,
                'precio' => $request->precio,
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
            
            $suela = Suela::find( $request->id );

            if( $suela->id ){

                $datos['id'] = $suela->id;
                $datos['nombre'] = $suela->nombre;
                $datos['precio'] = $suela->precio;
                $datos['descripcion'] = $suela->descripcion;
                $datos['exito'] = true;

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
    public function edit(Suela $suela)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $suela = Suela::where('id', '=', $request->id)
                    ->update([

                        'nombre' => $request->nombre,
                        'precio' => $request->precio,
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
            
            $suela = Suela::find( $request->id );

            if( $suela->id ){

                $suela->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
