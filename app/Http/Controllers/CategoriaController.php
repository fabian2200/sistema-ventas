<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias =  DB::connection('mysql')->table('categorias')->orderBy("categorias.nombre", "ASC")->get();
       
        return view('categorias.categorias_index', ["categorias" => $categorias]);
    }

    public function guardarCategoria(Request $request){
        $nombre = strtolower($request->input('nombre'));
        
        $existeCategoria = DB::connection('mysql')->table('categorias')
        ->where('nombre', $nombre)
        ->exists();

        if (!$existeCategoria) {
            DB::connection('mysql')->table('categorias')
            ->insert([
                'nombre' => $nombre,
            ]);
        }else{
            return redirect()->back()->withErrors(['mensaje' => 'fallo']);
        }

        return redirect()->route("categorias");
    }

    public function editarCategoria(Request $request){
        $id = strtolower($request->input('id'));
        $nombre = strtolower($request->input('nombre'));
               
        DB::connection('mysql')->table('categorias')
        ->where("id", $id)
        ->update([
            'nombre' => $nombre,
        ]);
        

        return redirect()->route("categorias");
    }

    public function eliminarCategoria(Request $request){
        $id = $request->input('id');
               
        $deleted = DB::connection('mysql')->table('categorias')
        ->where("id", $id)
        ->delete();
        

        if($deleted){
            $response = [
                'status' => 'success',
                'message' => 'La categoría ha sido eliminada exitosamente.'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'No se pudo eliminar la categoría.'
            ];
        }
    
        return response()->json($response);
    }
}
