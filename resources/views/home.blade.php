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

                @foreach($modulos as $index => $modulo)
                    <div class="col-12 col-md-3" style="margin-top: 20px">
                        <div class="card" style="align-items: center; border: none; margin: 20px;">
                            <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("$modulo.index")}}" class="btn btn-{{ $colores[$index % count($colores)] }}">
                                <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="{{url("/img/$modulo.png")}}">
                                <h5 style="font-weight: bolder;">{{$modulo === "acerca_de" ? "Acerca de" : ucwords($modulo)}}</h5>
                            </a>
                        </div>
                    </div>
                @endforeach
                <div class="col-12 col-md-3" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("$modulo.deudores")}}" class="btn btn-danger">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/prestamo.png">
                            <h5 style="font-weight: bolder;">Deudores</h5> 
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-3" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("proveedores")}}" class="btn btn-morado">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/icon_proveedor.png">
                            <h5 style="font-weight: bolder;">Proveedores</h5> 
                        </a>
                    </div>
                </div>
                <div class="col-12 col-md-3" style="margin-top: 20px">
                    <div class="card" style="align-items: center; border: none; margin: 20px;">
                        <a style="width: 210px; display: flex; flex-direction: column; padding: 20px; align-items: center; justify-content: center; border-radius: 20px; border-width: 0 0px 10px 0px;" href="{{route("categorias")}}" class="btn btn-warning">
                            <img style="height: 120px; width: fit-content; padding: 15px" class="card-img-top" src="/img/icon_categoria.png">
                            <h5 style="font-weight: bolder;">Categorias</h5> 
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
