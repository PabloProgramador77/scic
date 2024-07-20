<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Requests\Proveedor\Create;
use App\Http\Requests\Proveedor\Read;
use App\Http\Requests\Proveedor\Update;
use App\Http\Requests\Proveedor\Delete;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $proveedores = Proveedor::orderBy('nombre', 'asc')->get();

            return view('materiales.proveedores.index', compact('proveedores'));

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
            
            $proveedor = Proveedor::create([

                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'direccion' => $request->direccion

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
            
            $proveedor = Proveedor::find( $request->id );

            if( $proveedor->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $proveedor->nombre;
                $datos['telefono'] = $proveedor->telefono;
                $datos['direccion'] = $proveedor->direccion;
                $datos['id'] = $proveedor->id;

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
    public function edit(Proveedor $proveedor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $proveedor = Proveedor::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre,
                    'telefono' => $request->telefono,
                    'direccion' => $request->direccion

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
            
            $proveedor = Proveedor::find( $request->id );

            if( $proveedor->id ){

                $proveedor->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
