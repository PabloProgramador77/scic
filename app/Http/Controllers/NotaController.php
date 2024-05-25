<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Cotizacion;
use Illuminate\Http\Request;
use App\Http\Requests\Nota\Assign;
use App\Http\Requests\Nota\Delete;
use App\Http\Requests\Nota\Read;
use App\Http\Requests\Nota\Create;
use App\Http\Requests\Nota\Search;
use App\Http\Controllers\NotaHasCotizacionController;

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
    public function create( Assign $request )
    {
        try {
            
            $nota = Nota::create([

                'idCliente' => $request->cliente,
                'pares' => 0,
                'total' => 0,
                'estado' => 'Pendiente',

            ]);

            $idNota = $nota->id;

            $notaHasCotizacionController = new NotaHasCotizacionController;

            if( $notaHasCotizacionController->store( $idNota, $request ) ){

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store( Create $request )
    {
        try {
            
            $nota = Nota::create([

                'idCliente' => $request->cliente,
                'pares' => 0,
                'total' => 0,
                'estado' => 'Pendiente',

            ]);

            $idNota = $nota->id;

            $notaHasCotizacionController = new NotaHasCotizacionController();
            
            if( $notaHasCotizacionController->store( $idNota, $request ) ){

                $datos['exito'] = true;
                $datos['id'] = $idNota;

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
            
            $cotizaciones = Cotizacion::select('nota_has_cotizaciones.idCotizacion', 'cotizaciones.precio', 'modelos.nombre', 'nota_has_cotizaciones.id')
                            ->join('modelos', 'cotizaciones.idModelo', '=', 'modelos.id')
                            ->join('nota_has_cotizaciones', 'cotizaciones.id', '=', 'nota_has_cotizaciones.idCotizacion')
                            ->where('nota_has_cotizaciones.idNota', '=', $request->id)
                            ->get();

            if( count( $cotizaciones ) > 0 ){

                $datos['exito'] = true;
                $datos['cotizaciones'] = $cotizaciones;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] =$th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id )
    {
        try {
            
            $nota = Nota::find( $id );

            if( $nota->id ){

                return view('notas.edicion', compact('nota'));

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( $pares, $total, $idNota )
    {
        try {
            
            $nota = Nota::where('id', '=', $idNota)
                    ->update([

                        'pares' => $pares,
                        'total' => $total,

                    ]);

            return true;

        } catch (\Throwable $th) {
            
            return false;
            
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Delete $request)
    {
        try {
            
            $nota = Nota::find( $request->id );

            if( $nota->id ){

                $nota->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );

    }

    /**Búsqueda de notas de cliente */
    public function notas( Search $request ){
        try {
            
            $notas = Nota::select('notas.id', 'notas.total', 'notas.estado', 'clientes.nombre')
                    ->join('clientes', 'notas.idCliente', '=', 'clientes.id')
                    ->where('idCliente', '=', $request->cliente)
                    ->where('estado', '=', 'Pendiente')
                    ->get();

            if( count( $notas ) > 0 ){

                $datos['exito'] = true;
                $datos['notas'] = $notas;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Sin coincidencias.';
                
            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
