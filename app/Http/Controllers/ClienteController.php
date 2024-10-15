<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use App\Http\Requests\Cliente\Create;
use App\Http\Requests\Cliente\Store;
use App\Http\Requests\Cliente\Read;
use App\Http\Requests\Cliente\Update;
use App\Http\Requests\Cliente\Delete;
use App\Http\Controllers\NotaController;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index( Store $request )
    {
        try {
            
            $cliente = Cliente::create([

                'numero' => $request->numero,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'estado' => $request->estado,
                'ciudad' => $request->ciudad,
                'email' => $request->email,
                'empresa' => $request->empresa,
                'razon' => $request->razon,
                'rfc' => $request->rfc,

            ]);

            if( $cliente && $cliente->id ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
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

                'numero' => $request->numero,
                'nombre' => $request->nombre,
                'telefono' => $request->telefono,
                'estado' => $request->estado,
                'ciudad' => $request->ciudad,
                'email' => $request->email,
                'empresa' => $request->empresa,
                'razon' => $request->razon,
                'rfc' => $request->rfc,

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
    public function show(Read $request)
    {
        try {
            
            $cliente = Cliente::find( $request->id );

            if( $cliente && $cliente->id ){

                $datos['exito'] = true;
                $datos['numero'] = $cliente->numero;
                $datos['nombre'] = $cliente->nombre;
                $datos['telefono'] = $cliente->telefono;
                $datos['email'] = $cliente->email;
                $datos['estado'] = $cliente->estado;
                $datos['ciudad'] = $cliente->ciudad;
                $datos['empresa'] = $cliente->empresa;
                $datos['razon'] = $cliente->razon;
                $datos['rfc'] = $cliente->rfc;
                $datos['id'] = $cliente->id;

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
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $cliente = Cliente::where('id', '=', $request->id)
                    ->update([

                        'numero' => $request->numero,
                        'nombre' => $request->nombre,
                        'telefono' => $request->telefono,
                        'email' => $request->email,
                        'estado' => $request->estado,
                        'ciudad' => $request->ciudad,
                        'empresa' => $request->empresa,
                        'razon' => $request->razon,
                        'rfc' => $request->rfc,

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
            
            $cliente = Cliente::find( $request->id );

            if( $cliente->id ){

                $cliente->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
