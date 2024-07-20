<?php

namespace App\Http\Controllers;

use App\Models\Costo;
use Illuminate\Http\Request;
use App\Http\Requests\Costo\Create;
use App\Http\Requests\Costo\Read;
use App\Http\Requests\Costo\Update;
use App\Http\Requests\Costo\Delete;

class CostoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            if( auth()->user()->id ){

                $costos = Costo::orderBy('nombre', 'asc')->get();

                return view('costos.index', compact('costos'));

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
            
            $costo = Costo::create([

                'nombre' => $request->nombre,
                'total' => $request->total,
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
     * Display the specified resource.
     */
    public function show(Read $request)
    {
        try {
            
            $costo = Costo::find( $request->id );

            if( $costo->id ){

                $datos['exito'] = true;
                $datos['id'] = $costo->id;
                $datos['nombre'] = $costo->nombre;
                $datos['total'] = $costo->total;
                $datos['descripcion'] = $costo->descripcion;

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
    public function edit(Costo $costo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $costo = Costo::where('id', '=', $request->id)
                    ->update([

                        'nombre' => $request->nombre,
                        'total' => $request->total,
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

            $costo = Costo::find( $request->id );

            if( $costo->id ){

                $costo->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
