<?php

namespace App\Http\Controllers;

use App\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Cliente;

class VentasController extends Controller
{

    public function ticket($idVenta, $imprimir_factura){
        $venta = Venta::findOrFail($idVenta);

        $negocio = DB::connection('mysql')->table('negocio')->first();
        $usuario = DB::connection('mysql')->table('users')->where('id', session('user_id'))->first();
        $ipImpresora = $usuario->ip_impresora;
        $puertoImpresora = env("PUERTO_IMPRESORA");

        if($imprimir_factura == "si"){
            $connector = new NetworkPrintConnector($ipImpresora, $puerto);
            $impresora = new Printer($connector);
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->setEmphasis(true);
            $impresora->text("Ticket de venta: #".$idVenta."\n");
            $impresora->text($venta->created_at . "\n");
            $impresora->text($negocio->nombre."\n");
            $impresora->text("NIT ".$negocio->nit."\n");
            $impresora->text($negocio->direccion."\n");
            $impresora->text("Barrio ".$negocio->barrio."\n");
            $impresora->text("Cel: ".$negocio->telefono."\n");
            $impresora->text("Resolución \n");
            $impresora->text($negocio->resolucion."\n");
            $impresora->setEmphasis(false);
            $impresora->text("Cliente: ");
            $impresora->text($venta->cliente->nombre . "\n");
            $impresora->text("\nDetalle de la compra\n");
            $impresora->text("\n===============================\n");
            $total = 0;
            foreach ($venta->productos as $producto) {
                $subtotal = $producto->cantidad * $producto->precio;
                $total = $total + self::redondearAl100($subtotal);
                $impresora->setJustification(Printer::JUSTIFY_LEFT);
                $impresora->text(sprintf("%.2f %s x %s\n", $producto->cantidad, $producto->unidad,  $producto->descripcion));
                $impresora->setJustification(Printer::JUSTIFY_RIGHT);
                $impresora->text('$' . self::redondearAl100($subtotal) . "\n");
            }
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->text("\n===============================\n");
            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
            $impresora->setEmphasis(true);
            $impresora->setTextSize(2, 2); 
            $impresora->text("Subtotal: $" . self::redondearAl100($total) . "\n");
            $impresora->text("Domicilio: $" . self::redondearAl100($venta->valor_domicilio) . "\n");
            $impresora->text("Total: $" . self::redondearAl100($venta->total_con_domi) . "\n");
            $impresora->setJustification(Printer::JUSTIFY_CENTER);
            $impresora->setTextSize(1, 1);
            $impresora->text("Gracias por su compra\n");
            $impresora->feed(10);
            
            $impresora->pulse();
            $impresora->close();
        }

        return true;
    }

    public function ImprimirTicket(Request $request){

        $idVenta = $request->input("id_venta");
        $venta = Venta::findOrFail($idVenta);

        $negocio = DB::connection('mysql')->table('negocio')->first();
        $usuario = DB::connection('mysql')->table('users')->where('id', session('user_id'))->first();
        $ipImpresora = $usuario->ip_impresora;
        $puertoImpresora = env("PUERTO_IMPRESORA");

        $connector = new NetworkPrintConnector($ipImpresora, $puerto);
        $impresora = new Printer($connector);
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setEmphasis(true);
        $impresora->text("Ticket de venta: #".$idVenta."\n");
        $impresora->text($venta->created_at . "\n");
        $impresora->text($negocio->nombre."\n");
        $impresora->text("NIT ".$negocio->nit."\n");
        $impresora->text($negocio->direccion."\n");
        $impresora->text("Barrio ".$negocio->barrio."\n");
        $impresora->text("Cel: ".$negocio->telefono."\n");
        $impresora->text("Resolución \n");
        $impresora->text($negocio->resolucion."\n");
        $impresora->setEmphasis(false);
        $impresora->text("Cliente: ");
        $impresora->text($venta->cliente->nombre . "\n");
        $impresora->text("\nDetalle de la compra\n");
        $impresora->text("\n===============================\n");
        $total = 0;
        foreach ($venta->productos as $producto) {
            $subtotal = $producto->cantidad * $producto->precio;
            $total = $total + self::redondearAl100($subtotal);
            $impresora->setJustification(Printer::JUSTIFY_LEFT);
            $impresora->text(sprintf("%.2f %s x %s\n", $producto->cantidad, $producto->unidad,  $producto->descripcion));
            $impresora->setJustification(Printer::JUSTIFY_RIGHT);
            $impresora->text('$' . self::redondearAl100($subtotal) . "\n");
        }
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->text("\n===============================\n");
        $impresora->setJustification(Printer::JUSTIFY_RIGHT);
        $impresora->setEmphasis(true);
        $impresora->setTextSize(2, 2);
        $impresora->text("Subtotal: $" . self::redondearAl100($total) . "\n");
        $impresora->text("Domicilio: $" . self::redondearAl100($venta->valor_domicilio) . "\n");
        $impresora->text("Total: $" . self::redondearAl100($venta->total_con_domi) . "\n");
        $impresora->setJustification(Printer::JUSTIFY_CENTER);
        $impresora->setTextSize(1, 1);
        $impresora->text("Gracias por su compra\n");
        $impresora->feed(10);
        $impresora->close();
        return response()->json(["mensaje" => "Ticket de venta impreso correctamente!"]);
    }

    function redondearAl100($numero) {
        return round($numero / 100) * 100;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $totalVendido = 0;
        $totalVendidoTotal = 0;
        $hoy = date("Y-m-d");
        $mes_actual = date('m');
        $anio_actual = date('Y');

        $tipo_venta = session('user_tipo');

        if($tipo_venta == 1){
            $ventasConTotales = Venta::join("clientes", "clientes.id", "ventas.id_cliente")
            ->select("ventas.*", "clientes.nombre as cliente")
            ->orderBy("ventas.created_at", "DESC")
            ->get();
    
            $totalVendidoHoy = Venta::join("clientes", "clientes.id", "ventas.id_cliente")
            ->where("ventas.fecha_venta", $hoy)
            ->sum("ventas.total_pagar");
    
            $primeros100 = Venta::join("clientes", "clientes.id", "ventas.id_cliente")
                ->select("ventas.*", "clientes.nombre as cliente")
                ->orderBy("ventas.created_at", "DESC")
                ->limit(1000)
                ->get();
        }else{
            $ventasConTotales = Venta::join("clientes", "clientes.id", "ventas.id_cliente")
            ->select("ventas.*", "clientes.nombre as cliente")
            ->where("ventas.tipo_venta", $tipo_venta)
            ->orderBy("ventas.created_at", "DESC")
            ->get();
    
            $totalVendidoHoy = Venta::join("clientes", "clientes.id", "ventas.id_cliente")
            ->where("ventas.fecha_venta", $hoy)
            ->where("ventas.tipo_venta", $tipo_venta)
            ->sum("ventas.total_pagar");
    
            $primeros100 = Venta::join("clientes", "clientes.id", "ventas.id_cliente")
                ->select("ventas.*", "clientes.nombre as cliente")
                ->where("ventas.tipo_venta", $tipo_venta)
                ->orderBy("ventas.created_at", "DESC")
                ->limit(1000)
                ->get();
        }
       

        foreach ($ventasConTotales as $item) {
            $mes_factura = explode("-", $item->fecha_venta)[1];
            $anio_factura = explode("-", $item->fecha_venta)[0];

            $totalVendidoTotal += $item->total_pagar;

            if($mes_actual == $mes_factura && $anio_actual == $anio_factura){
                $totalVendido += $item->total_pagar;
            }
        }
                    
        return view("ventas.ventas_index", [
            "ventas" => $primeros100, 
            "totalVendido" => $totalVendido,
            "totalVendidoHoy" => $totalVendidoHoy,
            "totalVendidoTotal" => $totalVendidoTotal
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function show(Venta $venta)
    {
        $total = 0;
        foreach ($venta->productos as $producto) {
            $total += $producto->cantidad * $producto->precio;
        }
        return view("ventas.ventas_show", [
            "venta" => $venta,
            "total" => $total,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Venta $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Venta $venta)
    {
        $venta->delete();
        return redirect()->route("ventas.index")
            ->with("mensaje", "Venta eliminada");
    }

    public function ventasPorFecha(Request $request)
    {

        $fecha1 = $request->input("fecha1");
        $fecha2 = $request->input("fecha2");


        $ventasConTotales = Venta::join("clientes", "clientes.id", "ventas.id_cliente")
        ->select("ventas.*", "clientes.nombre as cliente")
        ->whereBetween("ventas.fecha_venta", [$fecha1, $fecha2])
        ->orderBy("ventas.fecha_venta", "ASC")
        ->get();

    
        $totalVendido = 0;
    
       
        
        foreach ($ventasConTotales as $item) {
            $mes_factura = explode("-", $item->fecha_venta)[1];
            $anio_factura = explode("-", $item->fecha_venta)[0];
            $totalVendido += $item->total_pagar;
        }
            
        return view("ventas.ventas_mes", [
            "ventas" => $ventasConTotales, 
            "totalVendido" => $totalVendido,
        ]);
    }
}
