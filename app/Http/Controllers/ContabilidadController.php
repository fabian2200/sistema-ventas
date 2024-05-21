<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContabilidadController extends Controller
{
    public function index(Request $request)
    {
        $fecha1 = $request->input("fecha1");
        $fecha2 = $request->input("fecha2");

        $ventasEfectivo = self::ventasEfectivo($fecha1, $fecha2);

        dd($ventasEfectivo);
        return view(
            "contabilidad", 
            [
              'ventas_efectivo' => $ventas_efectivo
            ]
        );
    }

    public function ventasEfectivo($fecha1, $fecha2){
        $ventas_efectivo = [];

        $tipos_vendedores = DB::connection('mysql')->table('tipo_usuario')
        ->where("tipo", "!=", 1)
        ->get();

        $tipo_venta = session('user_tipo');

        if($tipo_venta == 1){
            foreach ($tipos_vendedores as $item) {
                $ventasConTotales = DB::connection('mysql')->table('ventas')
                ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
                ->where("tipo_venta", $item->tipo)
                ->sum("total_pagar");

                $objeto = [
                    "tipo" => $item->tipo_desc,
                    "total" => $ventasConTotales
                ];

                array_push($ventas_efectivo, $objeto);
            }
        }else{
            $ventasConTotales = DB::connection('mysql')->table('ventas')
            ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
            ->where("tipo_venta", $tipo_venta)
            ->sum("total_pagar");

            $objeto = [
                "tipo" => session('tipo_usuario'),
                "total" => $ventasConTotales
            ];

            array_push($ventas_efectivo, $objeto);
        }     
        
        return $ventas_efectivo;
    }
}
