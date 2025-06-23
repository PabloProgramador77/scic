<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Modelo;
use App\Models\Pieza;
use App\Models\Material;
use App\Models\Costo;
use App\Models\Nota;
use App\Models\Cliente;
use App\Models\ModeloHasGanancia;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use App\Http\Requests\Cotizacion\Modelos;
use App\Http\Requests\Cotizacion\Create;
use App\Http\Requests\Cotizacion\Delete;
use App\Http\Controllers\CotizacionHasPiezasController;
use App\Http\Controllers\CotizacionHasCostosController;
use App\Http\Controllers\CotizacionHasCosteController;
use App\Http\Controllers\CotizacionHasConsumibleController;
use App\Http\Controllers\CotizacionHasSuelaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionHasNumeracionesController;
use App\Http\Controllers\ModeloHasConsumibleController;
use App\Http\Controllers\ModeloHasCosteController;
use App\Http\Controllers\ModeloHasCostoController;
use App\Http\Controllers\ModeloHasNumeracionesController;
use App\Http\Controllers\ModeloHasSuelaController;
use App\Http\Controllers\PiezaController;
use Illuminate\Support\Facades\Hash;

class CotizacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $clientes = Cliente::orderBy('nombre', 'asc')->get();
            
            return view('cotizacion.index', compact('clientes'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( $idCliente )
    {
        try {
            
            $modelos = Modelo::orderBy('numero', 'asc')->get();
            $cliente = Cliente::find( $idCliente );
            $modeloHasGanancia = ModeloHasGanancia::find( 1 );
            $proveedores = Proveedor::orderBy('nombre', 'asc')->get();

            return view('cotizacion.cotizador', compact('modelos', 'cliente', 'modeloHasGanancia', 'proveedores'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Create $request)
    {
        try {

            $cotizacion = Cotizacion::create([

                'descripcion' => $request->descripcion,
                'color' => $request->color,
                'precio' => $request->total,
                'estado' => 'Pendiente',
                'idModelo' => $request->modelo,
                'idCliente' => $request->cliente,
                'observaciones' => $request->observaciones,

            ]);

            $idCotizacion = $cotizacion->id;

            $cotizacionHasPiezaController = new CotizacionHasPiezasController();

            if( $cotizacionHasPiezaController->store( $request, $idCotizacion ) ){

                $cotizacionHasCostosController = new CotizacionHasCostosController();

                if( $cotizacionHasCostosController->store( $request, $idCotizacion ) ){

                    $cotizacionHasCostesController = new CotizacionHasCosteController();

                    if( $cotizacionHasCostesController->store( $request, $idCotizacion ) ){

                        $cotizacionHasConsumibleController = new CotizacionHasConsumibleController();

                        if( $cotizacionHasConsumibleController->store( $request, $idCotizacion ) ){

                            $cotizacionHasSuelaController = new CotizacionHasSuelaController();
    
                            if( $cotizacionHasSuelaController->store( $request, $idCotizacion ) ){

                                $datos['exito'] = true;
                                $datos['cotizacion'] = $cotizacion->id;

                            }else{
    
                                $datos['exito'] = false;
                                $datos['mensaje'] = 'Suelas no registradas';
    
                            }
    
                        }else{
    
                            $datos['exito'] = false;
                            $datos['mensaje'] = 'Consumibles no registrados';
    
                        }

                    }else{

                        $datos['exito'] = false;
                        $datos['mensaje'] = 'Costos neutros no registrados';

                    }

                }else{

                    $datos['exito'] = false;
                    $datos['mensaje'] = 'Costos base no registrados';

                }

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Piezas no registradas.';

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
    public function show(Modelos $request)
    {
        try {
            
            $piezas = Pieza::select('piezas.id', 'piezas.nombre', 'piezas.alto', 'piezas.largo', 'piezas.idModelo', 'piezas.cantidad')
                            ->where('piezas.idModelo', '=', $request->id)
                            ->orderBy('piezas.nombre', 'asc')
                            ->get();

            $materiales = Material::select('id', 'nombre', 'concepto', 'precio', 'unidades', 'color', 'hexColor')
                            ->whereIn('id', function($query) {
                                $query->select(\DB::raw('MIN(id)'))
                                      ->from('materiales')
                                      ->groupBy('nombre', 'concepto');
                            })
                            ->orderBy('concepto', 'asc')
                            ->get();

            $modelo = Modelo::find( $request->id );

            $datos['exito'] = true;
            $datos['piezas'] = $piezas;
            $datos['materiales'] = $materiales;
            $datos['modelo'] = $modelo;

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        try {
            
            foreach($request->cotizaciones as $cotizacion){

                $cotizacion = Cotizacion::where('id', '=', $cotizacion)
                            ->update([
                                
                                'estado' => 'Nota',

                ]);

            }

            return true;

        } catch (\Throwable $th) {

            return false;

        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        try {
            
            $cotizacion = Cotizacion::where('id', '=', $request->cotizacion)
                        ->update([

                            'estado' => 'Nota',

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
            
            $cotizacion = Cotizacion::find( $request->id );

            if( $cotizacion->id ){

                $cotizacion->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Rollback status
     */
    public function resetEstado( $idCotizacion ){

        try {
            
            $cotizacion = Cotizacion::where('id', '=', $idCotizacion )
                        ->update([

                            'estado' => 'Pendiente'

                        ]);

            $cotizacionHasNumeracionesController = new CotizacionHasNumeracionesController();

            if( $cotizacionHasNumeracionesController->destroy( $idCotizacion ) ){

                return true;

            }else{

                return false;

            }

        } catch (\Throwable $th) {
            
            return false;

        }

    }

    /**
     * Asignacion de cliente a cotizacion
     */
    public function assign( Request $request ){
        try {
    

            $cotizacion = Cotizacion::create([

                'precio' => $request->total,
                'estado' => 'Pendiente',
                'idModelo' => $request->modelo,
                'idCliente' => $request->cliente,

            ]);

            $idCotizacion = $cotizacion->id;

            $cotizacionHasPiezaController = new CotizacionHasPiezasController();

            if( $cotizacionHasPiezaController->store( $request, $idCotizacion ) ){

                $cotizacionHasCostosController = new CotizacionHasCostosController();

                if( $cotizacionHasCostosController->store( $request, $idCotizacion ) ){

                    $cotizacionHasConsumibleController = new CotizacionHasConsumibleController();

                    if( $cotizacionHasConsumibleController->store( $request, $idCotizacion ) ){

                        $cotizacionHasSuelaController = new CotizacionHasSuelaController();

                        if( $cotizacionHasSuelaController->store( $request, $idCotizacion ) ){

                            $datos['exito'] = true;

                        }else{

                            $datos['exito'] = false;
                            $datos['mensaje'] = 'Suelas no registradas';

                        }

                    }else{

                        $datos['exito'] = false;
                        $datos['mensaje'] = 'Consumibles no registrados';

                    }

                }else{

                    $datos['exito'] = false;
                    $datos['mensaje'] = 'Costos no registrados';

                }

            }else{

                $datos['exito'] = false;
                $datos['mensaje'] = 'Piezas no registradas.';

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Cotizaciones de Cliente
     * ! Recibe el ID del cliente
     */
    public function cliente( $idCliente ){
        try {
            
            $cotizaciones = Cotizacion::where('idCliente','=', $idCliente)->get();

            $cliente = Cliente::find( $idCliente );
            $notas = Nota::where('idCliente', '=', $idCliente)->get();
            $clientes = Cliente::orderBy('nombre', 'asc')->get();

            return view('cotizacion.cotizaciones', compact('cotizaciones', 'cliente', 'notas', 'clientes'));

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Comparación y Encriptación de Variantes
     */
    public function encriptacion( Request $request ){
        try {
            
            $modelo = Modelo::find( $request->modelo );
            $cotizacion = Cotizacion::find( $request->cotizacion );

            if( $modelo->id && $cotizacion->id ){

                $cadenaVariante = '|'.$cotizacion->modelo->nombre.'|'.$cotizacion->modelo->numero;

                foreach( $cotizacion->piezas as $pieza ){

                    $cadenaVariante .= '|'.$pieza->nombre;

                }

                foreach( $cotizacion->materiales as $material ){

                    $cadenaVariante .= '|'.$material->nombre;

                }

                foreach( $cotizacion->colores as $color ){

                    $cadenaVariante .= '|'.$color->pivot->colorMaterial;

                }

                foreach( $cotizacion->consumibles as $consumible ){

                    $cadenaVariante .= '|'.$consumible->nombre;

                }

                foreach( $cotizacion->suelas as $suela ){

                    $cadenaVariante .= '|'.$suela->nombre;

                }

                $varianteModelos = Modelo::where('variante', '=', $cadenaVariante)->get();

                if( count( $varianteModelos ) === 0 ){

                    $ultimoModelo = Modelo::where('nombre', '=', $modelo->nombre)
                                    ->orderBy('id', 'desc')
                                    ->first();

                    $cadenaVariante = str_replace( $cotizacion->modelo->numero, $ultimoModelo->numero + 1, $cadenaVariante);

                    $nuevoModelo = Modelo::create([
                            
                        'nombre' => $modelo->nombre,
                        'numero' => (string)( $ultimoModelo->numero + 1 ),
                        'descripcion' => 'Variante '.( $ultimoModelo->numero + 1 ).' de '.$modelo->nombre,
                        'variante' => $cadenaVariante,

                    ]);

                    /*$this->nuevoModelo( $nuevoModelo, $request->cotizacion );*/

                    $datos['exito'] = true;
                    $datos['variante'] = true;
                    $datos['cotizacion'] = $cotizacion->id;
                    $datos['modelo'] = $nuevoModelo;
                    $datos['modelos'] = Modelo::where('nombre', '=', $modelo->nombre)
                                                ->where('numero', 'NOT LIKE', '%00')
                                                ->orderBy('numero', 'asc')
                                                ->get();

                }else{

                    $datos['exito'] = true;
                    $datos['variante'] = false;

                }

            }else{

                $datos['exito'] = false;

            }

        } catch (\Throwable $th) {

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Guardado de la variante de modelo
     */
    public function nuevoModelo( Request $request ){
        try {
            
            $cotizacion = Cotizacion::find( $request->cotizacion );

            if( $cotizacion->id ){

                $PzsCtrl = new PiezaController();
                $PzsCtrl->create( $request, $cotizacion->piezas );

                $modHasConsCtlr = new ModeloHasConsumibleController();
                $modHasConsCtlr->create( $request, $cotizacion->consumibles );

                $modHasCosteCtrl = new ModeloHasCosteController();
                $modHasCosteCtrl->create( $request, $cotizacion->costes );

                $modHasCostoCtrl = new ModeloHasCostoController();
                $modHasCostoCtrl->create( $request, $cotizacion->costos );

                $modHasSuelaCtrl = new ModeloHasSuelaController();
                $modHasSuelaCtrl->create( $request, $cotizacion->suelas );

                $modHasNumCtrl = new ModeloHasNumeracionesController();
                $modHasNumCtrl->create( $request, $cotizacion->modelo->numeraciones );

                $cotizacion->idModelo = $request->id;
                $cotizacion->save();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Resumen de Cotización
     * * Recibe el ID 
     * ! Muestra todos los datos y relaciones
     */
    public function cotizacion( $idCotizacion ){
        try {
            
            $cotizacion = Cotizacion::find( $idCotizacion );

            if( $cotizacion && $cotizacion->id ){

                return view('cotizacion.resumen', compact('cotizacion'));

            }

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Sobreescritura de variante
     */
    public function sobreescribirModelo( Request $request ){
        try {
            
            $cotizacion = Cotizacion::find( $request->cotizacion );

            $modelo = Modelo::find( $request->idModelo );
            $modelo->delete();

            if( $cotizacion->id ){

                $modelo = Modelo::where('id', '=', $request->id )
                                ->update([

                                    'nombre' => $request->nombre,
                                    'numero' => $request->numero,
                                    'descripcion' => $request->descripcion,
                                    'variante' => $request->variante,

                                ]);

                $PzsCtrl = new PiezaController();
                $PzsCtrl->create( $request, $cotizacion->piezas );

                $modHasConsCtlr = new ModeloHasConsumibleController();
                $modHasConsCtlr->create( $request, $cotizacion->consumibles );

                $modHasCosteCtrl = new ModeloHasCosteController();
                $modHasCosteCtrl->create( $request, $cotizacion->costes );

                $modHasCostoCtrl = new ModeloHasCostoController();
                $modHasCostoCtrl->create( $request, $cotizacion->costos );

                $modHasSuelaCtrl = new ModeloHasSuelaController();
                $modHasSuelaCtrl->create( $request, $cotizacion->suelas );

                $modHasNumCtrl = new ModeloHasNumeracionesController();
                $modHasNumCtrl->create( $request, $cotizacion->modelo->numeraciones );

                $cotizacion->idModelo = $request->id;
                $cotizacion->save();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {
            
            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Edición de cotización
     */
    public function editar( $id ){
        try {
            
            $cotizacion = Cotizacion::find( $id );
            $modelos = Modelo::orderBy('nombre', 'asc')->get();
            $cliente = Cliente::find( $cotizacion->idCliente );
            $modeloHasGanancia = ModeloHasGanancia::find( 1 );
            $materiales = Material::orderBy('concepto', 'asc')->get();
            $costosModelo = $cotizacion->modelo->costos();
            $costesModelo = $cotizacion->modelo->costes();
            $consumiblesModelo = $cotizacion->modelo->consumibles();
            $suelasModelo = $cotizacion->modelo->suelas();
            $colorPiso = $cotizacion->suelas()->first()->pivot->colorPiso;
            $colorCuna = $cotizacion->suelas()->first()->pivot->colorCuna;

            return view('cotizacion.editar', compact('cotizacion', 'modelos', 'cliente', 'modeloHasGanancia', 'materiales', 'costosModelo', 'costesModelo', 'consumiblesModelo', 'suelasModelo', 'colorPiso', 'colorCuna'));

        } catch (\Throwable $th) {
            
            echo $th->getMessage();

        }
    }

    /**
     * Copia de cotización
     */
    public function copiar( Request $request ){
        try{

            foreach( $request->cotizaciones as $registro ){

                $cotizacion = Cotizacion::find( $registro );

                $nuevaCotizacion = $cotizacion->replicate();
                $nuevaCotizacion->idCliente = $request->customer;
                $nuevaCotizacion->save();

                $cotizacionHasConsumibleController = new CotizacionHasConsumibleController();
                $cotizacionHasConsumibleController->create( $cotizacion->id, $nuevaCotizacion->id );

                $cotizacionHasCosteController = new CotizacionHasCosteController();
                $cotizacionHasCosteController->create( $cotizacion->id, $nuevaCotizacion->id );

                $cotizacionHasCostosController = new CotizacionHasCostosController();
                $cotizacionHasCostosController->create( $cotizacion->id, $nuevaCotizacion->id );

                $cotizacionHasNumeracionesController = new CotizacionHasNumeracionesController();
                $cotizacionHasNumeracionesController->create( $cotizacion->id, $nuevaCotizacion->id );

                $cotizacionHasPiezasController = new CotizacionHasPiezasController();
                $cotizacionHasPiezasController->create( $cotizacion->id, $nuevaCotizacion->id );

                $cotizacionHasSuelasController = new CotizacionHasSuelaController();
                $cotizacionHasSuelasController->create( $cotizacion->id, $nuevaCotizacion->id );

            }

            $datos['exito'] = true;

        }catch(\Throwable $th){

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Actualización de cotización
     */
    public function actualizar( Request $request){
        try{

            Cotizacion::where('id', '=', $request->id)
                        ->update([

                            'descripcion' => $request->descripcion,
                            'color' => $request->color,
                            'precio' => $request->total,
                            'observaciones' => $request->observaciones,

                        ]);

            $cotizacionHasConsumibleCtrl = new CotizacionHasConsumibleController();
            $cotizacionHasConsumibleCtrl->update( $request );

            $cotizacionHasCosteCtrl = new CotizacionHasCosteController();
            $cotizacionHasCosteCtrl->update( $request );

            $cotizacionHasCostosCtrl = new CotizacionHasCostosController();
            $cotizacionHasCostosCtrl->update( $request );

            $cotizacionHasPiezasCtrl = new CotizacionHasPiezasController();
            $cotizacionHasPiezasCtrl->update( $request );

            $cotizacionHasSuelasCtrl = new CotizacionHasSuelaController();
            $cotizacionHasSuelasCtrl->update( $request );

            $datos['exito'] = true;

        }catch(\Throwable $th){

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }

    /**
     * Actualización de observaciones
     */
    public function observaciones(Request $request){
        try{

            Cotizacion::where('id', '=', $request->id)
                        ->update([

                            'observaciones' => $request->observaciones,

                        ]);

            $datos['exito'] = true;

        }catch(\Throwable $th){

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
        
    }
}
