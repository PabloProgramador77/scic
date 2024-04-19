<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Modelo;
use App\Models\Pieza;
use App\Models\Material;
use App\Models\Costo;
use Illuminate\Http\Request;
use App\Http\Requests\Cotizacion\Modelos;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $modelos = Modelo::all();

            return view('cotizacion.cotizador', compact('modelos'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Modelos $request)
    {
        try {
            
            $piezas = Pieza::select('piezas.id', 'piezas.nombre', 'piezas.alto', 'piezas.largo', 'piezas.idModelo', 'piezas.cantidad')
                            ->where('piezas.idModelo', '=', $request->id)
                            ->get();

            $materiales = Material::all();

            $datos['exito'] = true;
            $datos['piezas'] = $piezas;
            $datos['materiales'] = $materiales;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Nota $nota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Nota $nota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Nota $nota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Nota $nota)
    {
        //
    }
}
