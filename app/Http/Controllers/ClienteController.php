<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Requests\Cliente\Create;
use App\Http\Controllers\NotaController;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        try {
            
            $cliente = Cliente::create([

                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'domicilio' => $request->domicilio,
                'email' => $request->email

            ]);

            $idCliente = $cliente->id;
            
            return $idCliente;

        } catch (\Throwable $th) {
            
            return 0;

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {
            
            $notaController = new NotaController();

            $cliente = Cliente::create([

                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'domicilio' => $request->domicilio,
                'email' => $request->email

            ]);

            $idCliente = $cliente->id;

            if( $notaController->store( $idCliente, $request ) ){

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
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
