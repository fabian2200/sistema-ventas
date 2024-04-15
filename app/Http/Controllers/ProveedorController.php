<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores =  DB::connection('mysql')->table('proveedores')->orderBy("proveedores.nombre", "ASC")->get();
       
        return view('proveedores.proveedores_index', ["proveedores" => $proveedores]);
    }

    public function guardarProveedor(Request $request){
        $nombre = strtolower($request->input('nombre'));
        
        $existeCategoria = DB::connection('mysql')->table('proveedores')
        ->where('nombre', $nombre)
        ->exists();

        if (!$existeCategoria) {
            DB::connection('mysql')->table('proveedores')
            ->insert([
                'nombre' => $nombre,
            ]);
        }else{
            return redirect()->back()->withErrors(['mensaje' => 'fallo']);
        }

        return redirect()->route("proveedores");
    }

    public function editarProveedor(Request $request){
        $id = strtolower($request->input('id'));
        $nombre = strtolower($request->input('nombre'));
               
        DB::connection('mysql')->table('proveedores')
        ->where("id", $id)
        ->update([
            'nombre' => $nombre,
        ]);
        

        return redirect()->route("proveedores");
    }

    public function eliminarProveedor(Request $request){
        $id = $request->input('id');
               
        $deleted = DB::connection('mysql')->table('proveedores')
        ->where("id", $id)
        ->delete();
        

        if($deleted){
            $response = [
                'status' => 'success',
                'message' => 'El proveedor ha sido eliminado exitosamente.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No se pudo eliminar el proveedor.'
            ];
        }
    
        return response()->json($response);
    }
}
