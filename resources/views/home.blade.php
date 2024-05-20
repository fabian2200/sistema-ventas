@extends('maestra')
@section("titulo", "Inicio")
@section('contenido')
    @foreach([
    ["vender", "productos", "ventas", "clientes", "usuarios"],
    ] as $modulos)
        <div class="col-12 pb-2">
            <div class="row">
                @php
                    $colores = ['success', 'warning', 'primary', 'morado', 'gris'];
                @endphp
                <div class="col-md-1" style="margin-top: 20px">
                </div>
                @foreach($modulos as $index => $modulo)
                    <div class="col-md-2" style="margin-top: 20px">
                        <div class="card" style="align-items: center; border: none; margin: 20px;">
                            <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("$modulo.index")}}" class="btn btn-{{ $colores[$index % count($colores)] }}">
                                <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="{{url("/img/$modulo.png")}}">
                                <h5 style="font-weight: bolder;">{{$modulo === "acerca_de" ? "Acerca de" : ucwords($modulo)}}</h5>
                            </a>
                        </div>
                    </div>
                @endforeach
                <div class="col-md-1" style="margin-top: 20px">
                </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("$modulo.deudores")}}" class="btn btn-danger">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/prestamo.png">
                            <h5 style="font-weight: bolder;">Deudores</h5> 
                        </a>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("proveedores")}}" class="btn btn-morado">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/icon_proveedor.png">
                            <h5 style="font-weight: bolder;">Proveedores</h5> 
                        </a>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("categorias")}}" class="btn btn-warning">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/icon_categoria.png">
                            <h5 style="font-weight: bolder;">Categorias</h5> 
                        </a>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("compras.index")}}" class="btn btn-azul">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/compras.png">
                            <h5 style="font-weight: bolder;">Compras</h5> 
                        </a>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a type="button" data-toggle="modal" data-target="#exampleModal" style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" class="btn btn-rosado">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/recarga.png">
                            <h5 style="font-weight: bolder;">Retiros y Recargas</h5> 
                        </a>
                    </div>
                </div>
                <div class="col-md-2" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a href="{{route("codigos.index")}}" style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" class="btn btn-negro">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/codigo_barra.png">
                            <h5 style="font-weight: bolder;">código de Barra</h5> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Seleccione un tipo de mocimiento</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                
                <div class="row">
                    <div class="col-lg-6" style="margin-bottom: 20px; height: 90px;">
                        <a href="{{route("recarga.index", ['fecha1' => date('Y-m-').'01', 'fecha2' => date('Y-m-d') ])}}">
                            <label style="cursor: pointer; padding-top: 0px !important" class="lradio" for="control_09">
                                <img src="/img/recarga_cel.png" style="width: 65px"  alt=""> 
                                <h4 style="text-align: left">Recarga o Paquete</h4>
                             </label>
                        </a>
                    </div>
                    <div class="col-lg-6" style="margin-bottom: 20px; height: 90px;">
                        <a href="{{route("recarga.index2", ['fecha1' => date('Y-m-').'01', 'fecha2' => date('Y-m-d') ])}}">
                            <label style="cursor: pointer; padding-top: 0px !important" class="lradio" for="control_09">
                                <img src="/img/retiro_consignacion.png" style="width: 65px"  alt=""> 
                                <h4 style="text-align: left">Consignación o Retiro</h4>
                             </label>
                        </a>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
    </div>
@endsection
