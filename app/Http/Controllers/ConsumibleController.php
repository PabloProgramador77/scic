<?php

namespace App\Http\Controllers;

use App\Models\Consumible;
use Illuminate\Http\Request;
use App\Http\Requests\Consumible\Create;
use App\Http\Requests\Consumible\Read;
use App\Http\Requests\Consumible\Update;
use App\Http\Requests\Consumible\Delete;

class ConsumibleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->user()->id ){

            $consumibles = Consumible::orderBy('nombre', 'asc')->get();

            return view('consumibles.index', compact('consumibles'));

        }else{

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
            
            $consumible = Consumible::create([

                'nombre' => $request->nombre,
                'tipo' => $request->tipo,
                'precio' => $request->precio,
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
            
            $consumible = Consumible::find( $request->id );

            if( $consumible->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $consumible->nombre;
                $datos['tipo'] = $consumible->tipo;
                $datos['precio'] = $consumible->precio;
                $datos['descripcion'] =$consumible->descripcion;
                $datos['id'] = $consumible->id;

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
    public function edit(Consumible $consumible)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $consumible = Consumible::where('id', '=', $request->id)
                        ->update([

                            'nombre' => $request->nombre,
                            'tipo' => $request->tipo,
                            'precio' => $request->precio,
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
            
            $consumible = Consumible::find( $request->id );

            if( $consumible->id ){

                $consumible->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
