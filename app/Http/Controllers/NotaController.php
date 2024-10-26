<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Requests\Nota\Assign;
use App\Http\Requests\Nota\Delete;
use App\Http\Requests\Nota\Read;
use App\Http\Requests\Nota\Create;
use App\Http\Requests\Nota\Search;
use App\Http\Requests\Nota\Impuestos;
use App\Http\Controllers\NotaHasCotizacionController;
use App\Http\Controllers\CotizacionController;
use Illuminate\Support\Facades\DB;
use Mpdf\Mpdf;

class NotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $notas = Nota::orderBy('updated_at', 'desc')->get();
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
                'iva' => 'False',
                'envio' => 0,

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
                'iva' => 'False',
                'envio' => 0,

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
    public function edit( $id, $idCliente )
    {
        try {
            
            $nota = Nota::find( $id );
            $cliente = Cliente::find( $idCliente );

            if( $nota->id ){

                return view('notas.edicion', compact('nota', 'cliente'));

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( $pares, $total, $idNota, $dias )
    {
        try {

            $nota = Nota::find( $idNota );
            
            Nota::where('id', '=', $idNota)
                    ->update([

                        'pares' => $pares,
                        'total' => $total,
                        'fecha_entrega' => \Carbon\Carbon::parse( $nota->updated_at )->addDays( $dias ),

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
                    ->orderBy('notas.id', 'desc')
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
            $colspan = 0;
            $totalNota = 0;
            $html = '';

            if( $nota->id ){

                $totalNota = $nota->total;

                $pdf = new \Mpdf\Mpdf([

                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'orientation' => 'L',
                    'autoPageBreak' => false,

                ]);

                foreach( $nota->cotizaciones as $cotizacion ){

                    if( count( $cotizacion->numeraciones ) > $colspan ){

                        $colspan = count( $cotizacion->numeraciones );

                    }

                }

                $html .='
                    <html>
                    <head>
                        <style>
                        </style>
                    </head>
                    <body>
                        <div style="width: 100%; height: auto; padding: 5px; display: block; overflow: auto;">
                            <div style="width: 33%; height: auto; display: inline-block; float: left; overflow: auto;">
                                <img src="media/logo.jpg" width="700px" height="auto">
                            </div>
                            <div style="width: 66.5%; height: auto; display: inline-block; float: left; overflow: auto; margin-top: 50px;">
                                <table style="width: 100%; height: auto; overflow: auto;">
                                    <tbody>
                                        <tr>
                                            <td style="text-align: right; font-size: 12px;"><b>Fecha de Inicio:</b></td>
                                            <td style="text-align: center; font-size: 12px; background-color: lightgray;">'.$nota->updated_at.'</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; font-size: 12px;"><b>Fecha de Entrega Aprox:</b></td>
                                            <td style="text-align: center; font-size: 12px; background-color: lightgray;">'.$nota->fecha_entrega.'</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; font-size: 12px;"><b>Pedido:</b></td>
                                            <td style="text-align: center; font-size: 12px; background-color: lightgray;">'.$nota->id.'</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: right; font-size: 12px;"><b>Vendedor:</b></td>
                                            <td style="text-align: center; font-size: 12px; background-color: lightgray;">'.auth()->user()->name.'</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div style="width: 100%; height: auto; display: block; overflow: auto; border-bottom: 2px;">
                            <p style="font-size: 12px; text-align: center; display: block; padding: 5px; background-color: blue; color: white;"><b>DATOS DEL CLIENTE</b></p>
                            <table style="witdh: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="font-size: 12px;"><b>Nombre:</b></td>
                                    <td style="font-size: 12px; text-align: center;">'.$nota->cliente->nombre.'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px;"><b>Domicilio:</b></td>
                                    <td style="font-size: 12px; text-align: center;">'.$nota->cliente->domicilio.'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px;"><b>Telefono:</b></td>
                                    <td style="font-size: 12px; text-align: center;">'.$nota->cliente->telefono.'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px;"><b>Correo:</b></td>
                                    <td style="font-size: 12px; text-align: center;">'.$nota->cliente->email.'</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 100%; height: auto; overflow: auto; display: block;">
                            <table style="width: 100%; height: auto; overflow: auto;">
                                <tr style="background-color: blue; padding: 5px;">
                                    <td style="color: white; font-size: 12px; text-align: center;"><b>Nombre</b></td>
                                    <td style="color: white; font-size: 12px; text-align: center;"><b>Modelo</b></td>
                                    <td style="color: white; font-size: 12px; text-align: center;"><b>Descripción</b></td>
                                    <td style="color: white; font-size: 12px; text-align: center;" colspan="'.$colspan.'"><b>Numeraciones</b></td>
                                    <td style="color: white; font-size: 12px; text-align: center;"><b>Pares</b></td>
                                    <td style="color: white; font-size: 12px; text-align: center;"><b>Precio U.</b></td>
                                    <td style="color: white; font-size: 12px; text-align: center;"><b>Importe</b></td>
                                </tr>';

                                foreach( $nota->cotizaciones as $cotizacion ){

                                    $html .= '
                                    <tr style="padding: 5px;">
                                        <td style="border: 2px; font-size: 12px; border: 1px;">'.$cotizacion->modelo->nombre.'</td>
                                        <td style="border: 2px; font-size: 12px; border: 1px;">'.$cotizacion->modelo->numero.'</td>
                                        <td style="border: 2px; font-size: 12px; border: 1px;">'.$cotizacion->descripcion.'</td>';

                                        $ultimo = $cotizacion->numeraciones->last();

                                        foreach( $cotizacion->numeraciones as $numeracion ){

                                            if( $numeracion->is( $ultimo ) ){

                                                $html .= '
                                                <td style="border: 2px; font-size: 12px; border: 1px;" colspan="'.($colspan - count($cotizacion->numeraciones)+1).'"><b>#'.number_format($numeracion->numero, 1).'</b>/'.$numeracion->cantidad( $cotizacion->id, $numeracion->id ).'</td>
                                                ';

                                            }else{

                                                $html .= '
                                                <td style="border: 2px; font-size: 12px; border: 1px;"><b>#'.number_format($numeracion->numero, 1).'</b>/'.$numeracion->cantidad( $cotizacion->id, $numeracion->id ).'</td>
                                                ';

                                            }
                                            

                                        }

                                    $html .= '
                                        <td style="border: 2px; font-size: 12px; border: 1px; text-align: center;">'.$nota->pares( $nota->id, $cotizacion->id ).'</td>
                                        <td style="border: 2px; font-size: 12px; border: 1px; text-align: center;">$ '.number_format( ($cotizacion->precio - $nota->descuento( $nota->id, $cotizacion->id)), 2).'</td>
                                        <td style="border: 2px; font-size: 12px; border: 1px; text-align: center;">$ '.number_format( ($cotizacion->precio - $nota->descuento( $nota->id, $cotizacion->id)) * $nota->pares( $nota->id, $cotizacion->id ), 2).'</td>
                                    </tr>
                                    ';

                                }

                                $html.= '
                                <tr style="padding: 5px;">
                                    <td colspan="'.($colspan+3).'" style="font-size: 12px; text-align: right; border: 1px;"><b>Pares:</b></td>
                                    <td  style="font-size: 12px; border: 1px; text-align: center;">'.$nota->pares.'</td>
                                    <td  style="font-size: 12px; text-align: right; border: 1px;"><b>Subtotal:</b></td>
                                    <td  style="font-size: 12px; border: 1px; text-align: center;">$ '.number_format( $nota->total, 2).'</td>
                                </tr>';

                                if( $nota->iva == 'True' ){

                                    $html .='
                                    <tr style="background-color: lightgray; padding: 5px;">
                                        <td colspan="'.($colspan+5).'" style="font-size: 12px; text-align: right;"><b>I.V.A:</b></td>
                                        <td style="font-size: 12px; text-align: center;">$ '.number_format( ($nota->total*0.16), 2).'</td>
                                    </tr>
                                    ';

                                    $totalNota += ( $nota->total * 0.16 );

                                }

                                if( $nota->envio != 'Sin envio' ){

                                    if( $nota->envio == 'Por cobrar' ){

                                        $html .='
                                        <tr style="background-color: lightgray; padding: 5px;">
                                            <td colspan="'.($colspan+5).'" style="font-size: 12px; text-align: right;"><b>Envió:</b></td>
                                            <td style="font-size: 12px;">POR COBRAR</td>
                                        </tr>
                                        ';

                                    }else{

                                        $html .='
                                        <tr style="background-color: lightgray; padding: 5px;">
                                            <td colspan="'.($colspan+5).'" style="font-size: 12px; text-align: right;"><b>Envió:</b></td>
                                            <td style="font-size: 12px;">$ '.number_format( $nota->envio, 2).'</td>
                                        </tr>
                                        ';

                                        $totalNota += $nota->envio;

                                    }

                                }
                                
                                $html .='
                                <tr style="background-color: green; padding: 5px;">
                                    <td colspan="'.($colspan+5).'" style="font-size: 12px; text-align: right;"><b>Total:</b></td>
                                    <td style="font-size: 12px;">$ '.number_format( $totalNota, 2).'</td>
                                </tr>
                                <tr style="background-color: yellow; padding: 5px;">
                                    <td colspan="'.($colspan+5).'" style="font-size: 12px; text-align: right;"><b>Anticipo 50%:</b></td>
                                    <td style="font-size: 12px;">$ '.number_format($totalNota/2, 2).'</td>
                                </tr>
                            </table>
                            <div style="padding: 5px; margin: 5px; text-align: center;">
                                <p style="color: gray; font-size: 14px; text-align: center; font-weight: bold;">Este documento no es un comprobante fiscal.</p>
                                <p style="color: gray; font-size: 14px; text-align: center; font-weight: bold;">Esta nota tiene una validez de 30 días a partir de la fecha de inicio</p>
                            </div>
                        </div>
                    </body>
                    </html>
                ';

                $pdf->writeHTML( $html );

                unset( $html );

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
    public function nota( $id, $idCliente ){
        try {
            
            $nota = Nota::find( $id );
            $cliente = Cliente::find( $idCliente );

            if( $nota->id ){

                return view('notas.nota', compact('nota', 'cliente'));

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

    /**
     * Anticipo de nota
     * ! Recibe el ID de la nota
     * * Se cambia de Pendiente a Abierta
     */
    public function anticipar( Request $request ){
        try {
            
            $nota = Nota::where('id', '=', $request->nota)
                    ->update([

                        'estado' => 'Abierta',

            ]);

            if( $this->pdf( $request->nota ) && $this->pdfConsumo( $request->nota ) && $this->hojaViajera( $request->nota ) && $this->tablaConsumos( $request->nota ) ){

                $datos['exito'] = true;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Cálculo de Consumos Interrumpido';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Cerrando nota
     * ! Recibe el ID de la nota
     * * Se cambia de Abierta a Pagada
     */
    public function cerrar( Request $request ){
        try {
            
            $nota = Nota::where('id', '=', $request->nota )
                    ->update([

                        'estado' => 'Pagada',

            ]);

            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();


        }

        return response()->json( $datos );
    }

    /**
     * Creación de PDF de Consumos
     * ! Recibe el ID de la nota
     * * Apartir de esto consulta los datos restantes
     */
    public function pdfConsumo( $idNota ){
        try {

            $nota = Nota::find( $idNota );
            $html = '';

            if( $nota->id ){

                $pdf = new \Mpdf\Mpdf([

                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'orientation' => 'L',
                    'autoPageBreak' => true,

                ]);

                $html .= '
                    <html>
                        <body>
                            <h2 style="width: 100%; border-bottom: 2px;">Cálculo de Consumos</h2>
                            <p style="font-size: 12px; font-style: normal; background-color: lightgray; width: 100%;">'.$nota->updated_at.'</p>
                            ';

                            $pdf->writeHTML( $html );

                            foreach( $nota->cotizaciones as $cotizacion){

                                $html = '
                                <table>
                                    <tbody style="width: 100%;">
                                        <tr style="border: 2px; background-color: lightblue; padding: 5px;">
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Modelo</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Pieza</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Área x Pieza</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Alto</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Largo</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>N° Piezas</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>CM<sup>2</sup></b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>DCM</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Mts x Par</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>U. De Compra</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Precio de Material</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Costo</b></td>
                                            <td style="font-size: 12px; text-align: center; width: 7.6%;"><b>Mts Totales ('.$nota->pares( $idNota, $cotizacion->id).')</b></td>
                                        </tr>';

                                        $pdf->writeHTML( $html );

                                        foreach( $cotizacion->piezas as $pieza){

                                            $material = $pieza->materiales( $cotizacion->id )->first();

                                            $html = '
                                            <tr style="border-bottom: 2px; padding: 5px;">
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.$cotizacion->modelo->nombre.' '.$cotizacion->modelo->numero.'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.$pieza->nombre.'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.number_format( ($pieza->alto*$pieza->largo), 2 ).'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.$pieza->alto.'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.$pieza->largo.'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.$pieza->cantidad.'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.number_format(($pieza->largo*$pieza->alto)*$pieza->cantidad, 2).'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.number_format(((($pieza->largo*$pieza->alto)*$pieza->cantidad)/100), 2).'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.number_format( (($pieza->largo*$pieza->alto)*$pieza->cantidad)/($material->unidades*100), 2).'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.$material->unidades.'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">$ '.$material->precio.'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">$ '.number_format( (($pieza->largo*$pieza->alto)*$pieza->cantidad)/($material->unidades*100)*$material->precio, 2).'</td>
                                                <td style="font-size: 12px; text-align: center; width: 7.6%;">'.number_format( (($pieza->largo*$pieza->alto)*$pieza->cantidad)/($material->unidades*100)*$nota->pares( $idNota, $cotizacion->id), 2).'</td>
                                            </tr>';

                                            $pdf->writeHTML( $html );

                                        }

                                        
                                    $html = '
                                    </tbody>
                                </table>';

                                $pdf->writeHTML( $html );

                            }
                            
                        $html = '
                        </body>
                    </html>
                ';

                $pdf->writeHTML( $html );

                unset( $html );
                $pdf->Output( public_path('pdf/').'consumos'.$idNota.'.pdf', \Mpdf\Output\Destination::FILE );
                
                if( file_exists( public_path('pdf/').'consumos'.$idNota.'.pdf')){

                    return true;

                }else{

                    return false;

                }

            }
            
        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Notas de Cliente
     * ! Recibe el ID del cliente
     */
    public function cliente( $idCliente ){
        try {
            
            $notas = Nota::where('idCliente', '=', $idCliente)->get();
            $cliente = Cliente::find( $idCliente );

            return view('notas.index', compact('notas', 'cliente'));

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }
    
    /**
     * Crea el PDF de la tabla de consumos
     * ! Recibe el ID de la nota
     */
    public function tablaConsumos($idNota){
        try {
            $nota = Nota::find($idNota);
            $html = '';

            $pdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'autoPageBreak' => true,
            ]);

            $html .= '
                <html>
                <body>
                    <p style="font-size: 22px; font-weight: bold;">Tabla de Consumos: ' . $idNota . '</p>
                    <table style="width: 100%; height: auto;">
                        <thead style="width: 100%; height: auto;">
                            <tr style="border: 2px; background-color: lightblue; padding: 5px;">
                                <td style="font-size: 12px; text-align: center; width: 14.25%;"><b>Proveedor</b></td>
                                <td style="font-size: 12px; text-align: center; width: 14.25%;"><b>Tipo</b></td>
                                <td style="font-size: 12px; text-align: center; width: 14.25%;"><b>Material</b></td>
                                <td style="font-size: 12px; text-align: center; width: 14.25%;"><b>Color</b></td>
                                <td style="font-size: 12px; text-align: center; width: 14.25%;"><b>Precio</b></td>
                                <td style="font-size: 12px; text-align: center; width: 14.25%;"><b>Mts. Totales</b></td>
                                <td style="font-size: 12px; text-align: center; width: 14.25%;"><b>Monto Aprox.</b></td>
                            </tr>
                        </thead>
                        <tbody>';

            if( count($nota->cotizaciones) > 0 ){

                $totalesPorMaterial = [];

                foreach( $nota->cotizaciones as $cotizacion ){

                    foreach( $cotizacion->piezas as $pieza ){

                        $material = $pieza->materiales( $cotizacion->id )->first();
                        $mtsTotales = number_format( (($pieza->largo*$pieza->alto)*$pieza->cantidad)/($material->unidades*100)*$nota->pares( $idNota, $cotizacion->id), 2);

                        if( !isset( $totalesPorMaterial[ $material->id ] ) ){

                            $totalesPorMaterial[ $material->id] = [

                                'proveedor' => $material->proveedor()->nombre,
                                'concepto' => $material->concepto,
                                'material' => $material->nombre,
                                'color' => $material->colores()->first()->pivot->colorMaterial ?? '',
                                'precio' => $material->precio,
                                'metros' => 0,
                                'monto' => 0,

                            ];

                            $totalesPorMaterial[ $material->id ]['metros'] += $mtsTotales;
                            $totalesPorMaterial[ $material->id ]['monto'] += $mtsTotales * $material->precio;

                        }else{

                            $totalesPorMaterial[ $material->id ]['metros'] += $mtsTotales;
                            $totalesPorMaterial[ $material->id ]['monto'] += $mtsTotales * $material->precio;
                            
                        }

                    }

                }

                usort( $totalesPorMaterial, function( $a, $b ){

                    return strcmp( $a['proveedor'], $b['proveedor']);

                });

                foreach( $totalesPorMaterial as $total ){

                    $html .= '<tr>';
                    $html .= '<td style="font-size: 12px; text-align: center; width: 14.25%;">'.$total['proveedor'].'</td>';
                    $html .= '<td style="font-size: 12px; text-align: center; width: 14.25%;">'.$total['concepto'].'</td>';
                    $html .= '<td style="font-size: 12px; text-align: center; width: 14.25%;">'.$total['material'].'</td>';
                    $html .= '<td style="font-size: 12px; text-align: center; width: 14.25%;">'.$total['color'].'</td>';
                    $html .= '<td style="font-size: 12px; text-align: center; width: 14.25%;"> $'.$total['precio'].'</td>';
                    $html .= '<td style="font-size: 12px; text-align: center; width: 14.25%;">'.number_format( $total['metros'], 2).' Mts.</td>';
                    $html .= '<td style="font-size: 12px; text-align: center; width: 14.25%;">$'.number_format( $total['monto'], 2).'</td>';
                    $html .= '</tr>';

                }

            }
            
            $html .= '</tbody></table></body></html>';

            //echo $html;

            $pdf->writeHTML($html);

            unset( $html );

            $pdf->Output(public_path('pdf/') . 'tabla' . $idNota . '.pdf', \Mpdf\Output\Destination::FILE);

            return file_exists(public_path('pdf/') . 'tabla' . $idNota . '.pdf');

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
            return false;

        }
    }


    /**
     * Agregado de Impuestos
     * * Recibe el IVA y/o Envió
     */
    public function impuestos( Impuestos $request ){
        try {
            
            if( $request->envio == 'Envio cotizado' ){

                $nota = Nota::where('id', '=', $request->nota)
                    ->update([

                        'iva' => $request->iva,
                        'envio' => $request->monto,

                    ]);

            }else{

                $nota = Nota::where('id', '=', $request->nota)
                    ->update([

                        'iva' => $request->iva,
                        'envio' => $request->envio,

                    ]);

            }
            
            $datos['exito'] = true;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Comprobación de PDF de Consumos
     * ! Si existe lo descarga, sino lo crea y despues lo descarga
     */
    public function consumos( Request $request ){

        try {
            
            if( file_exists( public_path('pdf/').'consumos'.$request->id.'.pdf' ) ){

                $datos['exito'] = true;

            }else{

                if( $this->pdfConsumo( $request->id ) ){

                    $datos['exito'] = true;

                }else{

                    $datos['exito'] = false;
                    $datos['mensaje'] = 'Cálculo de Consumos Interrumpido.';

                }

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );

    }

    /**
     * Descarga de Consumos
     */
    public function consumo( $idNota ){
        try {

            if( file_exists( public_path('pdf/').'consumos'.$idNota.'.pdf' ) ){

                return response()->download( public_path('pdf/').'consumos'.$idNota.'.pdf' );

            }else{

                return false;

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }

    }

    /**
     * Busca y verifica el PDF de tabla
     */
    public function tablaConsumo( Request $request ){
        try {
            
            if( file_exists( public_path('pdf/').'tabla'.$request->id.'.pdf' ) ){

                $datos['exito'] = true;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Documento no existente';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Descarga de tabla de consumos
     * *Recibe el ID de la nota
     */
    public function tabla( $idNota ){
        try {
            
            if( file_exists( public_path('pdf/').'tabla'.$idNota.'.pdf' ) ){

                return response()->download( public_path('pdf/').'tabla'.$idNota.'.pdf' );

            }else{

                return false;

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();
            
        }
    }

    /**
     * Creación de hoja viajera
     */
    public function hojaViajera( $idNota ){
        try {
            
            $nota = Nota::find( $idNota );
            $html = '';

            $pdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'A4',
                'orientation' => 'P',
                'autoPageBreak' => true,
            ]);

            if( $nota->cotizaciones &&  !empty($nota->cotizaciones) && count( $nota->cotizaciones ) > 0 ){

                foreach( $nota->cotizaciones as $cotizacion ){

                    $numeraciones = $cotizacion->modelo->numeraciones;

                    if( $cotizacion->modelo && !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                        $ancho = (100/count( $numeraciones));
                        $colspan = count( $numeraciones )+1;

                    }else{

                        $ancho = 0;
                        $colspan = 1;

                    }
                    
                    $html .= '
                        <h4 style="text-align: center; font-size: 16px; display: block;">Formato de Seguimiento</h4>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">Folio</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->id.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Fecha de solicitud</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->created_at.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Fecha de Entrega</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$nota->fecha_entrega.'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">Descripción:</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">'.$cotizacion->descripcion.'</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">Realizo</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.auth()->user()->name.'</b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">Modelo</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->modelo->nombre.'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">N° de Modelo</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->modelo->numero.'</b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">Elemento</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;"><b>1 de '.count( $nota->cotizaciones ).'</b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;">Color</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567;"><b></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr style="border: 1px solid #626567;">
                                    <td style="width: 100%; height: auto; overflow: auto; border: 1px solid #626567;" colspan="'.$colspan.'"><b>Numeración</b></td>
                                </tr>
                                <tr style="background-color: #AED6F1">
                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">Total</td>';
                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0){

                                        foreach( $numeraciones as $numeracion ){

                                            $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$numeracion->numero.'</td>';

                                        }

                                    }else{

                                        $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td>';

                                    }
                                    
                                $html .='
                                </tr>
                                <tr style="border: 1px solid #626567;">
                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;"><b>'.$nota->pares( $nota->id, $cotizacion->id).'</b></td>';
                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                                        foreach( $numeraciones as $numeracion){

                                            $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;"><b>'.$numeracion->cantidad( $cotizacion->id, $numeracion->id ).'</b></td>';

                                        }

                                    }else{

                                        $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td>';
                                        
                                    }
                                    
                                $html .= '
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr style="border: 1px solid #626567;">
                                    <td style="width: 100%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center; font-size: 14px; font-weight: bold;" colspan="3"><b>Insumos & Consumibles</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; height: auto; overflow: auto; border: 1px solid #626567;">Horma</td>
                                    <td style="width: 70%; height: auto; overflow: auto; border: 1px solid #626567;">'.$cotizacion->modelo->horma.'</td>
                                </tr>';
                                if( !empty( $cotizacion->consumibles ) && count( $cotizacion->consumibles ) > 0 ){

                                    foreach( $cotizacion->consumibles as $consumible ){

                                        $html .= '<tr><td style="width: 30%; height: auto; overflow: auto; border: 1px solid #626567;">'.$consumible->tipo.'</td>';
                                        $html .= '<td style="width: 70%; height: auto; overflow: auto; border: 1px solid #626567;">'.$consumible->nombre.'</td></tr>';

                                    }

                                }else{

                                    $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin consumibles</td>';
                                    
                                }
                                
                            $html .='
                                <tr style="background-color: #F1C40F;">
                                    <td style="width: 20%; height: auto; overflow: auto; border: 1px solid #626567;">Observaciones</td>
                                    <td style="width: 80%; height: auto; overflow: auto; border: 1px solid #626567;">'.$cotizacion->observaciones.'</td>
                                </tr>
                            </tbody>
                        </table>
                        <h5 style="display: block; text-align: center;">Ficha de Preliminar de Pespunte</h5>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Folio</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->id.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Elemento</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>1 de'.( count( $nota->cotizaciones) ).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Modelo</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->modelo->nombre.' '.$cotizacion->modelo->numero.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Color</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr style="background-color: #AED6F1">';
                                    $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">Total</td>';
                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                                        foreach( $numeraciones as $numeracion ){

                                            $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$numeracion->numero.'</td>';

                                        }

                                    }else{

                                        $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td>';
                                        
                                    }
                                    
                                $html .='
                                </tr>';
                                if( !empty( $cotizacion->piezas ) && count( $cotizacion->piezas ) > 0 ){

                                    foreach( $cotizacion->piezas as $pieza ){

                                        $html .= '<tr>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$pieza->nombre.'</td>';

                                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                                                        foreach( $numeraciones as $numeracion ){

                                                            $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;"><b>'.($numeracion->cantidad( $cotizacion->id, $numeracion->id ) * $pieza->cantidad).'</b></td>';

                                                        }

                                                    }else{

                                                        $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td>';
                                                        
                                                    }

                                        $html .= '</tr>';

                                    }

                                }else{

                                    $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin piezas</td>';
                                    
                                }
                                
                            $html .= '
                            </tbody>
                        </table>
                        <h5 style="display: block; text-align: center;">Ficha de Corte</h5>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            
                            <tbody style="width: 100%; height: auto; overflow: hidden;">
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Folio</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->id.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Elemento</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>1 de '.( count( $nota->cotizaciones) ).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Modelo</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->modelo->nombre.' '.$cotizacion->modelo->numero.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Color</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b></b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr style="background-color: #AED6F1">';
                                    $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">Suaje</td>
                                            <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">Cantidad P/P</td>
                                            <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">Numeración</td>';
                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                                        foreach( $numeraciones as $numeracion ){

                                            $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$numeracion->numero.'</td>';

                                        }

                                    }else{

                                        $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td>';
                                        
                                    }
                                    
                                $html .='
                                </tr>';
                                if( !empty( $cotizacion->piezas ) && count( $cotizacion->piezas ) > 0 ){

                                    foreach( $cotizacion->piezas as $pieza ){

                                        $html .= '<tr>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$pieza->suaje.'</td>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$pieza->cantidad.'</td>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$pieza->nombre.'</td>';
                                                    
                                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                                                        foreach( $numeraciones as $numeracion ){

                                                            $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;"></td>';

                                                        }

                                                    }else{

                                                        $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td>';
                                                        
                                                    }

                                        $html .= '</tr>';

                                    }

                                }else{

                                    $html .= '<tr><td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin piezas</td></tr>';
                                    
                                }
                                
                            $html .= '
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: hidden;">
                                <tr>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567;"><b>Proveedor</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567;"><b>Tipo</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567;"><b>Material</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567;"><b>Color</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567;"><b>Piezas</b></td>
                                </tr>';
                                if( !empty( $cotizacion->materiales) && count( $cotizacion->materiales ) > 0){

                                    foreach( $cotizacion->materiales as $material ){

                                        $piezas = implode(',', $material->piezas()->pluck('nombre')->filter()->toArray());
                                        $piezas = array_unique( explode(',', $piezas));
                                        $piezas = implode(',', $piezas);

                                        $html .= '<tr>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$material->proveedor()->nombre.'</td>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$material->concepto.'</td>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$material->nombre.'</td>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$material->colores()->first()->pivot->colorMaterial.'</td>
                                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$piezas.'</td>
                                                </tr>';

                                    }

                                }else{

                                    $html .= '<tr><td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td></tr>';
                                    
                                }
                                
                            $html .= '
                            </tbody>
                        </table>';

                    //echo $html;

                    $pdf->writeHTML( $html );

                    $pdf->Output( public_path('pdf/hojasViajeras/').'hojaViajera'.$cotizacion->id.'.pdf', \Mpdf\Output\Destination::FILE );

                }

            }else{

                echo "Sin cotizaciones disponibles para crear el documento.";

            }

            return true;

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

            return false;

        }
    }

}
