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

        $ventasEfectivoTransferencia = self::ventasEfectivoTransferencia($fecha1, $fecha2);
        $deuda = self::deuda($fecha1, $fecha2);

        $objeto = [
            "ventas" => $ventasEfectivoTransferencia,
            "deudores" => $deuda
        ];
        
        dd($objeto);

        return view(
            "contabilidad", 
            [
              'ventas_efectivo' => $ventas_efectivo
            ]
        );
    }

    public function ventasEfectivoTransferencia($fecha1, $fecha2){
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
                ->where("metodo_pago", "Efectivo")
                ->sum("total_pagar");

                $objeto = [
                    "tipo" => "Ventas en efectivo de ".$item->tipo_desc,
                    "total" => $ventasConTotales
                ];

                array_push($ventas_efectivo, $objeto);

                $ventasConTotales = DB::connection('mysql')->table('ventas')
                ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
                ->where("metodo_pago", "Transferencia")
                ->where("tipo_venta", $item->tipo)
                ->sum("total_pagar");

                $objeto = [
                    "tipo" => "Ventas en transferencia de ".$item->tipo_desc,
                    "total" => $ventasConTotales
                ];

                array_push($ventas_efectivo, $objeto);
            }
        }else{
            $ventasConTotales = DB::connection('mysql')->table('ventas')
            ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
            ->where("metodo_pago", "Efectivo")
            ->where("tipo_venta", $tipo_venta)
            ->sum("total_pagar");

            $objeto = [
                "tipo" => "Ventas en efectivo de ".session('tipo_usuario'),
                "total" => $ventasConTotales
            ];

            array_push($ventas_efectivo, $objeto);

            $ventasConTotales = DB::connection('mysql')->table('ventas')
            ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
            ->where("metodo_pago", "Transferencia")
            ->where("tipo_venta", $tipo_venta)
            ->sum("total_pagar");

            $objeto = [
                "tipo" => "Ventas en transferencia de ".session('tipo_usuario'),
                "total" => $ventasConTotales
            ];

            array_push($ventas_efectivo, $objeto);
        }  

        return $ventas_efectivo;
    }


    public function deuda($fecha1, $fecha2){
        $fiados = [];

        $tipos_vendedores = DB::connection('mysql')->table('tipo_usuario')
        ->where("tipo", "!=", 1)
        ->get();

        $tipo_venta = session('user_tipo');

        $deuda_total = 0;
        if($tipo_venta == 1){
            foreach ($tipos_vendedores as $item) {
                $ventasConTotales = DB::connection('mysql')->table('fiados')
                ->join("ventas", "ventas.id", "fiados.id_factura")
                ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
                ->where("ventas.tipo_venta", $item->tipo)
                ->where("ventas.metodo_pago", "Efectivo")
                ->sum("ventas.total_fiado");

                $objeto = [
                    "tipo" => "Total fiado en ".$item->tipo_desc,
                    "total" => $ventasConTotales
                ];
               
                $deuda_total += $ventasConTotales;
                array_push($fiados, $objeto);
            }
        }else{
            $ventasConTotales = DB::connection('mysql')->table('fiados')
            ->join("ventas", "ventas.id", "fiados.id_factura")
            ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
            ->where("ventas.tipo_venta", $tipo_venta)
            ->where("ventas.metodo_pago", "Efectivo")
            ->sum("ventas.total_fiado");

            $objeto = [
                "tipo" => "Total fiado en ".session('tipo_usuario'),
                "total" => $ventasConTotales
            ];
           
            $deuda_total += $ventasConTotales;
            array_push($fiados, $objeto);
        }


        $abonos = DB::connection('mysql')->table('abonos_fiados')
        ->whereBetween("abonos_fiados.fecha", [$fecha1, $fecha2])
        ->sum("abonos_fiados.valor_abonado");

        $objeto = [
            "tipo" => 'Abonos totales',
            "total" => $abonos
        ];
       
        array_push($fiados, $objeto);

        $objeto = [
            "tipo" => 'Deuda total',
            "total" => $deuda_total - $abonos
        ];
       
        array_push($fiados, $objeto);


        return $fiados;
    }

}
