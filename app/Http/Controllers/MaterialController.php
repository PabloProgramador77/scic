<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Proveedor;
use App\Models\ProveedorHasMateriales;
use Illuminate\Http\Request;
use App\Http\Requests\Material\Create;
use App\Http\Requests\Material\Read;
use App\Http\Requests\Material\Update;
use App\Http\Requests\Material\Delete;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            
            $materiales = Material::orderBy('nombre', 'asc')->get();
            $proveedores = Proveedor::orderBy('nombre', 'asc')->get();

            return view('materiales.index', compact('materiales', 'proveedores'));

        } catch (\Throwable $th) {
            
            return redirect('/');

        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( Request $request) 
    {
        try {
            
            $colores = Material::select('materiales.color', 'materiales.hexColor')
                        ->where('nombre', '=', $request->material)->get();

            if( count( $colores ) > 0 ){

                $datos['exito'] = true;
                $datos['colores'] = $colores;

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
    public function store(Create $request)
    {
        try {
            
            $material = new Material;
            $material->nombre = $request->nombre;
            $material->concepto = $request->concepto;
            $material->precio = $request->precio;
            $material->unidades = $request->unidades;
            $material->hexColor = $request->hex;
            $material->color = $request->color;
            $material->save();

            if( $material->id ){

                $provHasMat = ProveedorHasMateriales::create([

                    'idProveedor' => $request->proveedor,
                    'idMaterial' => $material->id 
    
                ]);

                $datos['exito'] = true;
                $datos['id'] = $material->id;

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
            
            $material = Material::find( $request->id );

            if( $material->id ){

                $datos['exito'] = true;
                $datos['nombre'] = $material->nombre;
                $datos['concepto'] = $material->concepto;
                $datos['precio'] = $material->precio;
                $datos['unidades'] = $material->unidades;
                $datos['color'] = $material->color;
                $datos['hex'] = $material->hexColor;
                $datos['id'] = $material->id;
                
                foreach($material->proveedores as $proveedor){

                    $datos['proveedor'] = $proveedor->nombre;
                    $datos['idProveedor'] = $proveedor->id;

                }

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
    public function edit(Material $material)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Update $request)
    {
        try {
            
            $material = Material::where('id', '=', $request->id)
                ->update([

                    'nombre' => $request->nombre,
                    'concepto' => $request->concepto,
                    'precio' => $request->precio,
                    'unidades' => $request->unidades,
                    'color' => $request->color,
                    'hexColor' => $request->hex,

                ]);

            $provHasMat = ProveedorHasMateriales::where('idMaterial', '=', $request->id)
                ->update([

                    'idProveedor' => $request->proveedor

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
            
            $material = Material::find( $request->id );

            if( $material->id ){

                $material->delete();

                $datos['exito'] = true;

            }

        } catch (\Throwable $th) {

            $datos['exito'] = false;
            $datos['mensaje'] = $th->getMessage();

        }

        return response()->json( $datos );
    }
}
