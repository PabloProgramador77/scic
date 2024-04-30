<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Cotizacion;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $notas = Nota::all();
            $cotizaciones = Cotizacion::where('estado', '=', 'Pendiente')->get();

            return view('notas.index', compact('notas', 'cotizaciones'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( $id )
    {
        try {
            
            $nota = Nota::create([

                'idCliente' => $id,
                'pares' => 0,
                'total' => 0,
                'estado' => 'Pendiente',

            ]);

            return redirect('/notas');

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( $idCliente )
    {
        try {
            
            $nota = Nota::create([

                'idCliente' => $idCliente,
                'pares' => 0,
                'total' => 0,
                'estado' => 'Pendiente',

            ]);

            return true;

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

            return false;

        }
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
