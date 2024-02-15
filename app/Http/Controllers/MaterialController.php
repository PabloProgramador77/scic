<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Requests\Material\Create;
use App\Http\Requests\Material\Read;
use App\Http\Requests\Material\Update;
use App\Http\Requests\Material\Delete;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $materiales = Material::all();

            return view('materiales.index', compact('materiales'));

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
            
            $material = Material::create([

                'nombre' => $request->nombre,
                'concepto' => $request->concepto,
                'precio' => $request->precio

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
            
            $material = Material::find( $request->id );

            if( $material->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $material->nombre;
                $datos['concepto'] = $material->concepto;
                $datos['precio'] = $material->precio;
                $datos['id'] = $material->id;

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
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $material = Material::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre,
                    'concepto' => $request->concepto,
                    'precio' => $request->precio

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
            
            $material = Material::find( $request->id );

            if( $material->id ){

                $material->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
