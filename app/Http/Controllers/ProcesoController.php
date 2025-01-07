<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use Illuminate\Http\Request;
use App\Http\Requests\Procesos\Create;
use App\Http\Requests\Procesos\Update;
use App\Http\Requests\Procesos\Delete;

class ProcesoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if( auth()->check() ) {
            $procesos = Proceso::all();
            return view('procesos.index', compact('procesos'));
        } else {
            return redirect()->route('login');
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
            
            $proceso = Proceso::create([

                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'orden' => $request->orden,

            ]);

            if( $proceso->id ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Display the specified resource.
     */
    public function show(Proceso $proceso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Proceso $proceso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $proceso = Proceso::where('id', '=', $request->id)
                    ->update([
                        'nombre' => $request->nombre,
                        'descripcion' => $request->descripcion,
                        'orden' => $request->orden,
                    ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json($datos);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $proceso = Proceso::find($request->id);

            if( $proceso->delete() ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();  
        
        }

        return response()->json($datos);
    }
}
