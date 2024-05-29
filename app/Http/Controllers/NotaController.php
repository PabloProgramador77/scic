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
use App\Http\Controllers\CotizacionController;
use Mpdf\Mpdf;

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

            if( $this->pdf( $idNota ) ){

                return true;

            }else{

                return false;

            }

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

                foreach( $nota->cotizaciones as $cotizacion ){

                    $cotizacionController = new CotizacionController();

                    if( $cotizacionController->resetEstado( $cotizacion->id ) == false ){

                        break;

                    }

                }

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

    /**
     * Creación de PDF de nota
     */
    public function pdf( $idNota ){
        try {
            
            $nota = Nota::find( $idNota );

            if( $nota->id ){

                $pdf = new \Mpdf\Mpdf([

                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'orientation' => 'P',
                    'autoPageBreak' => false,

                ]);

                $html ='
                    <html>
                    <head>
                        <style>
                            .contenedor{
                                width: 100%;
                                height: auto,
                                display: block;
                            }

                            .titulo{
                                font-size: 18px;
                                font-style: bold;
                            }

                            .info{
                                font-size: 14px;
                                font-style: normal;
                            }

                            .spacing{
                                padding: 7px;
                                marging: 7px;
                            }

                            .tituloNota{
                                font-size: 24px;
                                font-style: bold;
                                color: darkblue;
                                text-align: right;
                            }

                            .tituloTabla{
                                font-size: 16px;
                                font-style: bold;
                                text-align: center;
                            }
                        </style>
                    </head>
                    <body class="contenedor">
                        <table class="contenedor">
                            <tbody class="contenedor">
                                <tr class="contenedor">
                                    <td class="spacing">
                                        <img src="media/icons/calzado.png" width="125px" height="auto" class="spacing">
                                    </td>
                                    <td class="spacing" colspan="3">
                                        <h1 class="titulo">AYDEE FOOTWEAR</h1>
                                        <p class="info">Tel. 4761021041</p>
                                        <p class="info">Alv. Obregon 107 Col. Del Carme, Purisima del Rincón, Gto. México</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="spacing" colspan="3">
                                        <h2 class="tituloNota">NOTA DE VENTA</h2>
                                        <p class="info">Folio: #'.$idNota.'</p>
                                        <p class="info">'.$nota->cliente->nombre.'</p>
                                        <p class="info">'.$nota->created_at->format('Y-m-d').'</p>
                                    </td>
                                </tr>
                                <tr class="spacing" style="border-bottom: 4px; background-color: lightgray;">
                                    <td class="spacing tituloTabla">Modelo</td>
                                    <td class="spacing tituloTabla">Precio Unitario</td>
                                    <td class="spacing tituloTabla">Total de Pares</td>
                                    <td class="spacing tituloTabla">Monto</td>
                                </tr';
                        
                                $pdf->writeHTML( $html );
                                  
                                foreach( $nota->cotizaciones as $cotizacion ){

                                    $html ='<tr class="spacing">'.
                                    '<td class="info spacing" style="text-align: center;">'.$cotizacion->modelo->nombre.'</td>'.
                                    '<td class="info spacing" style="text-align: center;">$ '.number_format( $cotizacion->precio, 2).'</td>'.
                                    '<td class="info spacing" style="text-align: center;">'.$nota->pares( $nota->id, $cotizacion->id ).'</td>'.
                                    '<td class="info spacing" style="text-align: center;">$ '.number_format( $cotizacion->precio * $nota->pares( $nota->id, $cotizacion->id ), 2 ).'</td>'.
                                    '</tr>';

                                    $pdf->writeHTML( $html );

                                }
                                  
                                $html ='    
                                </tr>
                                <tr>
                                  <td colspan="3" class="spacing info" style="text-align: right;">Subtotal:</td>
                                  <td class="spacing info" style="text-align: center;">$ '.number_format( $nota->total, 2).'</td>
                                </tr>
                                <tr>
                                  <td colspan="3" class="spacing info" style="text-align: right;">IVA (16%):</td>
                                  <td class="spacing info" style="text-align: center;">$ '.number_format($nota->total * 0.16, 2).'</td>
                                </tr>
                                <tr style="background-color: orange;">
                                  <td colspan="3" class="spacing info" style="text-align: right;">Anticipo:</td>
                                  <td class="spacing info" style="text-align: center;">$ '.number_format(($nota->total * 1.16)/2, 2).'</td>
                                </tr>
                                <tr style="background-color: green;">
                                  <td colspan="3" class="spacing info" style="text-align: right;">TOTAL:</td>
                                  <td class="spacing info" style="text-align: center;">$ '.number_format($nota->total * 1.16, 2).'</td>
                                </tr>
                            </tbody>
                        </table>
                    </body>
                    </html>
                ';

                $pdf->writeHTML( $html );

                $pdf->Output( public_path('pdf/').'nota'.$idNota.'.pdf', \Mpdf\Output\Destination::FILE );

                if( file_exists( public_path('pdf/').'nota'.$idNota.'.pdf' ) ){

                    return true;

                }else{

                    return false;

                }

            }else{

                return false;

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            return false;

        }
    }

    /**
     * ! Consulta de nota
     * *Recibe el ID de la nota
     */
    public function nota( $id ){
        try {
            
            $nota = Nota::find( $id );

            if( $nota->id ){

                return view('notas.nota', compact('nota'));

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * ! Verificación de existencia de PDF
     * * Recibe el ID de la nota
     */
    public function descarga( Request $request ){
        try {
            
            $nota = Nota::find( $request->nota );

            if( $nota->id ){

                if( file_exists( public_path('pdf/').'nota'.$nota->id.'.pdf' ) ){

                    $datos['exito'] = true;

                }else{

                    $datos['mensaje'] = 'Archivo no encontrado.';
                    $datos['exito'] = false;

                }

            }else{

                $datos['mensaje'] = 'Nota no encontrada.';
                $datos['exito'] = false;

            }

        } catch (\Throwable $th) {
            
            $datos['mensaje'] = $th->getMessage();
            $datos['exito'] = false;

        }

        return response()->json( $datos );
    }

    /**
     * Descarga del archivo PDF
     * ! Recibe el ID de la nota
     */
    public function descargar( $id ){
        try {
            
            return response()->download( public_path('pdf/').'nota'.$id.'.pdf' );

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }
}
