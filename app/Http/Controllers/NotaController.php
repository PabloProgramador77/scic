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
            $items = count( $nota->cotizaciones );

            if( $nota->id ){

                $totalNota = $nota->total;

                $pdf = new \Mpdf\Mpdf([

                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'orientation' => 'L',
                    'autoPageBreak' => false,
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 10,
                    'margin_bottom' => 10,

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
                            <div style="width: 100%; height: auto; display: block; overflow: auto; margin: 0 auto; text-align: center;">
                                <img src="media/logo.jpg" width="200px" height="auto" style="display: inline-block; float: left;">
                                <h3 style="text-align: right; width: 100%; display: inline-block; margin-top: 0px; float: left;">NOTA DE VENTA</h3>
                            </div>
                        </div>
                        <div style="width: 33.3%; height: auto; display: inline-block; float: left; overflow: hidden;">
                            <p style="font-size: 12px; display: block;"><b>Datos de Nota</b></p>
                            <table style="witdh: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="font-size: 11px;"><b>N° de nota:</b></td>
                                    <td style="font-size: 11px;">'.($nota->numero ? $nota->numero : 'S/N').'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Fecha de emisión:</b></td>
                                    <td style="font-size: 11px;">'.$nota->updated_at.'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Fecha de entrega aprox:</b></td>
                                    <td style="font-size: 11px;">'.$nota->fecha_entrega.'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Vendedor:</b></td>
                                    <td style="font-size: 11px;">'.auth()->user()->name.'</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 33.3%; height: auto; display: inline-block; float: left; overflow: hidden;">
                            <p style="font-size: 12px; display: block;"><b>Datos de Cliente</b></p>
                            <table style="witdh: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="font-size: 11px;"><b>Nombre:</b></td>
                                    <td style="font-size: 11px;">'.$nota->cliente->nombre.'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Domicilio:</b></td>
                                    <td style="font-size: 11px;">'.($nota->cliente->domicilio ? $nota->cliente->domicilio : 'Sin domicilio registrado').'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Telefono:</b></td>
                                    <td style="font-size: 11px;">'.($nota->cliente->telefono ? $nota->cliente->telefono : 'Sin telefono registrado').'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Correo:</b></td>
                                    <td style="font-size: 11px;">'.($nota->cliente->email ? $nota->cliente->email : 'Sin email registrado').'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>RFC:</b></td>
                                    <td style="font-size: 11px;">'.($nota->cliente->rfc ? $nota->cliente->rfc : 'Sin RFC registrado').'</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 33.3%; height: auto; display: inline-block; float: left; overflow: hidden;">
                            <p style="font-size: 12px; display: block;"><b>Datos de Embarque</b></p>
                            <table style="witdh: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="font-size: 11px;"><b>Paquetería:</b></td>
                                    <td style="font-size: 11px;">Castores</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Entrega:</b></td>
                                    <td style="font-size: 11px;">'.$nota->cliente->estado.', '.$nota->cliente->ciudad.', '.$nota->cliente->colonia.', '.$nota->cliente->calle.' #'.$nota->cliente->exterior.', CP '.$nota->cliente->cp.'</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 11px;"><b>Cobrar:</b></td>
                                    <td style="font-size: 11px;">'.$nota->envio.'</td>
                                </tr>
                            </table>
                        </div>
                        <div style="width: 100%; height: auto; overflow: auto; display: block; margin-top: 40px;">
                            <table style="width: 100%; height: auto; overflow: auto; border-collapse: collapse;">
                                <tr style="background-color: #3498DB;">
                                    <td style="font-size: 12px; text-align: center; padding: 20px; width: 10%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;"><b>Nombre</b></td>
                                    <td style="font-size: 11px; text-align: center; padding: 20px; width: 8%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;"><b>Modelo</b></td>
                                    <td style="font-size: 11px; text-align: center; padding: 20px; width: 21%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;"><b>Descripción</b></td>
                                    <td style="font-size: 12px; text-align: center; padding: 20px; width: 8%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;"><b>Color</b></td>
                                    <td style="font-size: 12px; text-align: center; padding-top: 20px; width: 28%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;" colspan="'.$colspan.'"><b>Numeraciones</b>';

                                    $html .= '<table style="width: 100%; height: auto; overflow: auto; margin: 0 auto;"><tr style="width: 100%; height: auto; overflow:auto; margin: 0 auto;">';

                                    foreach( $cotizacion->numeraciones as $numeracion ){

                                        $html .= '
                                        <td style="width: '.number_format( 100 / count($cotizacion->numeraciones), 1 ).'%; height: auto; font-size: 10px; color: #FDFEFE; text-align: center; padding-top: 10px; margin: 0 auto;"><b>#'.(floor($numeracion->numero) == $numeracion->numero ? number_format( $numeracion->numero, 0 ) : number_format( $numeracion->numero, 1 ) ).'</b></td>
                                        ';
                                        
                                    }

                                    $html .= '</tr></table></td>';
                                    
                                    $html .= '
                                    <td style="font-size: 11px; text-align: center; padding: 20px; width: 7%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;"><b>Pares</b></td>
                                    <td style="font-size: 11px; text-align: center; padding: 20px; width: 8%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;"><b>Precio</b></td>
                                    <td style="font-size: 12px; text-align: center; padding: 20px; width: 10%; height: 40px; color: white; border-top: 2px solid #424949; border-bottom: 2px solid #424949; border-left: 1px solid #FDFEFE;"><b>Importe</b></td>
                                </tr>';

                                foreach( $nota->cotizaciones as $cotizacion ){

                                    $html .= '
                                    <tr style="padding: 5px;">
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">'.$cotizacion->modelo->nombre.'</td>
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">'.$cotizacion->modelo->numero.'</td>
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">'.$cotizacion->descripcion.'</td>
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">'.$cotizacion->color.'</td>';

                                        $ultimo = $cotizacion->numeraciones->last();

                                        foreach( $cotizacion->numeraciones as $numeracion ){

                                            if( $numeracion->is( $ultimo ) ){

                                                $html .= '
                                                        <td style="font-size: 12px; border: 1px solid #7B7D7D;;" colspan="'.($colspan - count($cotizacion->numeraciones)+1).'"><b>'.$numeracion->cantidad( $cotizacion->id, $numeracion->id ).'</b></td>
                                                        ';

                                            }else{

                                                $html .= '
                                                        <td style="font-size: 12px; border: 1px solid #7B7D7D;"><b>'.$numeracion->cantidad( $cotizacion->id, $numeracion->id ).'</b></td>
                                                        ';

                                            }
                                    
                                        }

                                    $html .= '
                                        <td style="border: 1px solid #7B7D7D; font-size: 12px; text-align: center;">'.$nota->pares( $nota->id, $cotizacion->id ).'</td>
                                        <td style="border: 1px solid #7B7D7D; font-size: 12px; text-align: center;">$ '.number_format( ($cotizacion->precio - $nota->descuento( $nota->id, $cotizacion->id)), 2).'</td>
                                        <td style="border: 1px solid #7B7D7D; font-size: 12px; text-align: center;">$ '.number_format( ($cotizacion->precio - $nota->descuento( $nota->id, $cotizacion->id)) * $nota->pares( $nota->id, $cotizacion->id ), 2).'</td>
                                    </tr>
                                    ';

                                }

                                for( $i = 0; $i < (10 - $items); $i++ ){

                                    $html .= '
                                    <tr style="padding: 5px;">
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">-</td>
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">-</td>
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">-</td>
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">-</td>
                                        <td style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;" colspan="'.$colspan.'">-</td>
                                        <td style="border: 1px solid #7B7D7D; font-size: 12px; text-align: center;">0</td>
                                        <td style="border: 1px solid #7B7D7D; font-size: 12px; text-align: center;">$ 0.00</td>
                                        <td style="border: 1px solid #7B7D7D; font-size: 12px; text-align: center;">$ 0.00</td>
                                    </tr>
                                    ';

                                }

                                $html.= '
                                <tr style="padding: 5px; border-bottom: 2px solid black;">
                                    <td colspan="'.($colspan+4).'" style="font-size: 12px; text-align: right; border: 1px solid #7B7D7D;"><b>Total de Pares:</b></td>
                                    <td  style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">'.$nota->pares.'</td>
                                    <td  style="font-size: 12px; text-align: right; border: 1px solid #7B7D7D;"><b>Subtotal:</b></td>
                                    <td  style="font-size: 12px; border: 1px solid #7B7D7D; text-align: center;">$ '.number_format( $nota->total, 2).'</td>
                                </tr>';

                                if( $nota->iva == 'True' ){

                                    $html .='
                                    <tr>
                                        <td colspan="'.($colspan+6).'" style="font-size: 12px; text-align: right; padding: 3px;"><b>I.V.A:</b></td>
                                        <td style="font-size: 12px; text-align: center; padding: 3px;">$ '.number_format( ($nota->total*0.16), 2).'</td>
                                    </tr>
                                    ';

                                    $totalNota += ( $nota->total * 0.16 );

                                }

                                if( $nota->envio != 'Sin envio' ){

                                    if( $nota->envio == 'Por cobrar' ){

                                        $html .='
                                        <tr>
                                            <td colspan="'.($colspan+6).'" style="font-size: 12px; text-align: right; padding: 3px;"><b>Envió:</b></td>
                                            <td style="font-size: 12px; padding: 3px;">POR COBRAR</td>
                                        </tr>
                                        ';

                                    }else{

                                        $html .='
                                        <tr>
                                            <td colspan="'.($colspan+6).'" style="font-size: 12px; text-align: right; padding: 3px;"><b>Envió:</b></td>
                                            <td style="font-size: 12px; padding: 3px;">$ '.number_format( $nota->envio, 2).'</td>
                                        </tr>
                                        ';

                                        $totalNota += $nota->envio;

                                    }

                                }
                                
                                $html .='
                                <tr>
                                    <td colspan="'.($colspan+6).'" style="font-size: 12px; text-align: right; color: #3894DB; padding: 3px;"><b>TOTAL:</b></td>
                                    <td style="font-size: 12px; border-bottom: 2px solid black; color: #3894DB; padding: 3px;"><b>$ '.number_format( $totalNota, 2).'</b></td>
                                </tr>
                                <tr>
                                    <td colspan="'.($colspan+6).'" style="font-size: 12px; text-align: right; padding: 3px;"><b>ANTICIPO:</b></td>
                                    <td style="font-size: 12px; border-bottom: 2px solid black; padding: 3px;">$ '.number_format(($totalNota/2), 2).'</td>
                                </tr>
                            </table>
                            <div style="border-left: 3px solid #3894DB; border-radius: 5px; float:left; overflow: hidden; width: 48.5%; display: inline-block;">
                                <p style="font-size: 12px; margin: 0; font-weight: bold;">DATOS FISCALES</p>
                                <p style="font-size: 11px; margin: 0;"><b>Nombre:</b> ANDREA DE GUADALUPE GUTIERREZ LOPEZ</p>
                                <p style="font-size: 11px; margin: 0;"><b>RFC:</b> GULA9303247N6</p>
                                <p style="font-size: 11px; margin: 0;"><b>Domicilio:</b> ALVARO OBREGON 110, EL CARMEN, PURISIMA DEL RINCON</p>
                                <p style="font-size: 11px; margin: 0;">PERSONA FISICA CON ACTIVIDAD EMPRESARIAL</p>
                            </div>
                            <div style="float:left; overflow: hidden; width: 48.5%; display: inline-block;">
                                <p style="font-size: 12px; font-weight: bold; color: #424949;">Este documento no es un comprobante fiscal ni sustituye una factura.
                                Conforme al artículo 170 de la Ley General de Títulos y Operaciones de Crédito, el suscriptor se obliga a pagar incondicionalmente la cantidad señalada en esta nota, 
                                misma que constituye un pagaré para efectos legales.</p>
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

                        'numero' => $request->numero,
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
                    'margin_left' => 10,
                    'margin_right' => 10,
                    'margin_top' => 10,
                    'margin_bottom' => 10,

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
            
            $notas = Nota::where('idCliente', '=', $idCliente)
                    ->where('estado', '!=', 'Pagada')
                    ->get();
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
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
            ]);

            $html .= '
                <html>
                <body>
                    <p style="font-size: 20px; font-weight: bold;">Solicitud de materiales: ' . $idNota . '</p>
                    <p style="font-size: 22px;"><b>N° de nota: '.$nota->numero.'</b></p>
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

                        if( $material && $material->id ){

                            $mtsTotales = number_format( (($pieza->largo*$pieza->alto)*$pieza->cantidad)/($material->unidades*100)*$nota->pares( $idNota, $cotizacion->id), 2);

                            if( !isset( $totalesPorMaterial[ $material->id ] ) ){

                                $totalesPorMaterial[ $material->id ] = [

                                    'proveedor' => $material->proveedor()->nombre,
                                    'concepto' => $material->concepto,
                                    'material' => $material->nombre,
                                    'color' => $material->colores()->first()->pivot->colorMaterial ?? '',
                                    'precio' => $material->precio,
                                    'metros' => 0,
                                    'monto' => 0,

                                ];

                            }

                            $totalesPorMaterial[ $material->id ]['metros'] += $mtsTotales;
                            $totalesPorMaterial[ $material->id ]['monto'] += ($mtsTotales * $material->precio);

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

            $pdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'format' => 'legal',
                'orientation' => 'P',
                'autoPageBreak' => true,
                'autoTopMargin' => 'stretch',
                'autoBottomMargin' => 'stretch',
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 10,
                'margin_bottom' => 10,
            ]);

            if( $nota->cotizaciones &&  !empty($nota->cotizaciones) && count( $nota->cotizaciones ) > 0 ){

                $elementos = 0;

                foreach( $nota->cotizaciones as $cotizacion ){

                    $elementos++;
                    $html = '';

                    if( $cotizacion->modelo->puntoMenor === 'Activado' ){

                        foreach( $cotizacion->modelo->numeraciones as $numeracion ){
                            
                            $numeracion->numero = floatval( $numeracion->numero - 1);

                        }

                        $numeraciones = $cotizacion->modelo->numeraciones;

                    }else{

                        $numeraciones = $cotizacion->modelo->numeraciones;

                    }                    

                    if( $cotizacion->modelo && !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                        $ancho = (100/count( $numeraciones));
                        $colspan = count( $numeraciones )+1;

                    }else{

                        $ancho = 0;
                        $colspan = 1;

                    }
                    
                    $html .= '
                        <div style="page-break-before: always;"></div>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">Cliente</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.$cotizacion->cliente->nombre.'</b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">Elemento</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.$elementos.' de '.count( $nota->cotizaciones ).'</b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">Modelo</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.$cotizacion->modelo->nombre.'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 3px solid #F1C40F; font-size: 16px;">N° de Nota:</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 3px solid #F1C40F; font-size: 16px;"><b>'.$nota->numero.'<b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">Folio</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.$cotizacion->id.'</b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">N° de Modelo</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.$cotizacion->modelo->numero.'</b></td>
                                    
                                </tr>
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">Fecha de solicitud</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.$cotizacion->created_at.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">Fecha de Entrega</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.\Carbon\Carbon::parse($nota->fecha_entrega)->format('d-m-Y').'</b></td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;">Color</td>
                                    <td style="width: 16.6%; height: auto; overflow: auto; border: 1px solid #626567; font-size: 16px;"><b>'.$cotizacion->color.'</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr style="background-color: #AED6F1">
                                    <td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;">Total</td>';
                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0){

                                        foreach( $numeraciones as $numeracion ){

                                            $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;">'.(floor($numeracion->numero) == $numeracion->numero ? number_format( $numeracion->numero, 0 ) : number_format( $numeracion->numero, 1 ) ).'</td>';

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
                                            if( $numeracion->cantidad( $cotizacion->id, $numeracion->id ) > 0 ){

                                                $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;"><b>'.$numeracion->cantidad( $cotizacion->id, $numeracion->id ).'</b></td>';

                                            }else{

                                                $html .= '<td style="width: '.$ancho.'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;"></td>';

                                            }

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
                                    <td style="width: 30%; height: auto; overflow: auto; border: 1px solid #626567;">Suela</td>
                                    <td style="width: 70%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->suelas->first()->nombre.'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 30%; height: auto; overflow: auto; border: 1px solid #626567;">Horma</td>
                                    <td style="width: 70%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->modelo->horma.'</b></td>
                                </tr>';
                                if( !empty( $cotizacion->consumibles ) && count( $cotizacion->consumibles ) > 0 ){

                                    foreach( $cotizacion->consumibles as $consumible ){

                                        $html .= '<tr><td style="width: 30%; height: auto; overflow: auto; border: 1px solid #626567;">'.$consumible->tipo.'</td>';
                                        $html .= '<td style="width: 70%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$consumible->nombre.'</b></td></tr>';

                                    }

                                }else{

                                    $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin consumibles</td>';
                                    
                                }
                                
                            $html .='
                                <tr style="background-color: #F1C40F;">
                                    <td style="width: 20%; height: auto; overflow: auto; border: 2px solid #626567;"><b>OBSERVACIONES</b></td>
                                    <td style="width: 80%; height: auto; overflow: auto; border: 2px solid #626567;"><b>'.strtoupper( $cotizacion->observaciones ).'</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <h5 style="display: block; text-align: center; border-bottom: 2px dotted black;">Ficha de Preliminar de Pespunte</h5>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Folio</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->id.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Elemento</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$elementos.' de '.( count( $nota->cotizaciones) ).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Modelo</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->modelo->nombre.' '.$cotizacion->modelo->numero.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Color</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->color.'</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: auto;">
                                <tr style="background-color: #AED6F1">';
                                    $html .= '<td style="width: '.($ancho*2).'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;">Pieza</td>';
                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                                        foreach( $numeraciones as $numeracion ){

                                            $html .= '<td style="width: '.((100 - ($ancho*2))/count($numeraciones)).'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;">'.(floor($numeracion->numero) == $numeracion->numero ? number_format( $numeracion->numero, 0 ) : number_format( $numeracion->numero, 1 ) ).'</td>';

                                        }

                                    }else{

                                        $html .= '<td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td>';
                                        
                                    }
                                    
                                $html .='
                                </tr>';
                                if( !empty( $cotizacion->piezas ) && count( $cotizacion->piezas ) > 0 ){

                                    foreach( $cotizacion->piezas as $pieza ){

                                        $html .= '<tr>
                                                    <td style="width: '.($ancho*2).'%; height: auto; overflow: auto; border: 1px solid #626567;">'.$pieza->nombre.'</td>';

                                                    if( !empty( $numeraciones ) && count( $numeraciones ) > 0 ){

                                                        foreach( $numeraciones as $numeracion ){

                                                            if( ($numeracion->cantidad( $cotizacion->id, $numeracion->id ) ) > 0 ){

                                                                $html .= '<td style="width: '.((100 - ($ancho*2))/count($numeraciones)).'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;"><b>'.($numeracion->cantidad( $cotizacion->id, $numeracion->id )*($pieza->cantidad/2)).'</b></td>';

                                                            }else{

                                                                $html .= '<td style="width: '.((100 - ($ancho*2))/count($numeraciones)).'%; height: auto; overflow: auto; border: 1px solid #626567; text-align: center;"></td>';

                                                            }

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
                        <div style="page-break-before: always;"></div>
                        <h5 style="display: block; text-align: center; border-bottom: 2px dotted black; margin-top: 20px;">Talones de Producción</h5>
                        <table style="width: 100%; height: auto; overflow: auto;">
                                <tbody style="width: 100%; height: auto; overflow: hidden;">
                                    <tr>
                                        <td colspan="3" style="border: 1px solid #626567; width: 16.6%; height: auto; border-right: 2px dotted black;"><b>Talon de Pespunte</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Fecha de entrega</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"></td>
                                        <td rowspan="5" style="border: 1px solid #626567; width: 16.6%; height: auto;"></td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Nota</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Folio</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto; border-right: 2px dotted black;">'.$cotizacion->id.'</td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Folio</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;">'.$cotizacion->id.'</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;">'.$nota->numero.'</td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Modelo</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto; border-right: 2px dotted black;">'.$cotizacion->modelo->nombre.'</td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Modelo</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;">'.$cotizacion->modelo->nombre.'</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Completo</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Pares</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto; border-right: 2px dotted black;">'.$nota->pares( $nota->id, $cotizacion->id).'</td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Numeracion</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;">-</td>
                                    </tr>
                                    <tr>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Maquila</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto; border-right: 2px dotted black;"></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;"><b>Pares</b></td>
                                        <td style="border: 1px solid #626567; width: 16.6%; height: auto;">'.$nota->pares( $nota->id, $cotizacion->id ).'</td>
                                    </tr>
                                </tbody>
                        </table>
                        <h5 style="display: block; text-align: center; border-bottom: 2px dotted black;">Ficha de Corte</h5>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            
                            <tbody style="width: 100%; height: auto; overflow: hidden;">
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Folio</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->id.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Elemento</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$elementos.' de '.( count( $nota->cotizaciones) ).'</b></td>
                                </tr>
                                <tr>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Modelo</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->modelo->nombre.' '.$cotizacion->modelo->numero.'</b></td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;">Color</td>
                                    <td style="width: 25%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$cotizacion->color.'</b></td>
                                </tr>
                            </tbody>
                        </table>
                        <table style="width: 100%; height: auto; overflow: auto;">
                            <tbody style="width: 100%; height: auto; overflow: hidden;">
                                <tr style="background-color: #AED6F1">
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567; text-align: center;"><b>Proveedor</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567; text-align: center;"><b>Tipo</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567; text-align: center;"><b>Material</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567; text-align: center;"><b>Color</b></td>
                                    <td style="width: 20%; height: auto; overflow: hidden; border: 1px solid #626567; text-align: center;"><b>Piezas y Suajes</b></td>
                                </tr>';
                                if( !empty( $cotizacion->materiales) && count( $cotizacion->materiales ) > 0){

                                    foreach( $cotizacion->materiales as $material ){

                                        // En tu archivo blade.php o controlador
                                        $piezas = $material->corte($cotizacion->id, $material->id)
                                                ->filter(function($pieza) {
                                                    // Filtramos solo piezas con nombre válido
                                                    return !empty($pieza->nombre);
                                                })
                                                ->map(function($pieza) {
                                                    // Obtenemos el suaje relacionado con manejo de nulos
                                                    $claveSuaje = $pieza->suaje ? $pieza->suaje : 'Sin suaje';
                                                    
                                                    // Combinamos nombre y suaje en un string único
                                                    return $pieza->nombre.":".$claveSuaje;
                                                })
                                                ->unique() // Elimina duplicados basado en el string completo
                                                ->implode('<br>'); // Convierte a string HTML


                                        $html .= '<tr>
                                                    <td style="width: 20%; height: auto; overflow: auto; border: 1px solid #626567;">'.$material->proveedor()->nombre.'</td>
                                                    <td style="width: 10%; height: auto; overflow: auto; border: 1px solid #626567;">'.$material->concepto.'</td>
                                                    <td style="width: 20%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$material->nombre.'</b></td>
                                                    <td style="width: 10%; height: auto; overflow: auto; border: 1px solid #626567;">'.$material->colores()->first()->pivot->colorMaterial.'</td>
                                                    <td style="width: 40%; height: auto; overflow: auto; border: 1px solid #626567;"><b>'.$piezas.'</b></td>
                                                </tr>';

                                    }

                                }else{

                                    $html .= '<tr><td style="border: 1px solid #626567;" colspan="'.$colspan.'">Sin numeraciones</td></tr>';
                                    
                                }
                                
                            $html .= '
                            </tbody>
                        </table>';

                    $pdf->SetDisplayMode('real', 'single');
                    $pdf->setHtmlFooter('Página {PAGENO}');
                    $pdf->writeHTML( $html, 2 );

                }

                $pdf->Output( public_path('pdf/hojasViajeras/').'hojasViajera'.$nota->id.'.pdf', \Mpdf\Output\Destination::FILE );

            }else{
                
                echo "Sin cotizaciones disponibles para crear el documento.";

            }

            return true;

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

            return false;

        }
    }

    /**
     * Búsqueda e identificación de hoja viajerra
     */
    public function viajeras( Request $request ){
        try {
            
            if( file_exists( public_path('pdf/hojasViajeras/').'hojasViajera'.$request->nota.'.pdf' ) ){

                $datos['exito'] = true;

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Documento no encontrado';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Descarga de Hoja Viajera
     */
    public function viajera( $id ){
        try {
            
            return response()->download( public_path('pdf/hojasViajeras/').'hojasViajera'.$id.'.pdf' );            

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

}
