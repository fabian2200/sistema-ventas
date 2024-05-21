@extends("maestra")
@section("titulo", "Editar usuario")
@section("contenido")
    <div class="row" style="padding: 20px">
        <div class="col-12">
            <h1>Editar usuario</h1>
            <form method="POST" action="{{route("usuarios.update", [$usuario])}}">
                @method("PUT")
                @csrf
                <div class="form-group">
                    <label class="label">Nombre</label>
                    <input required value="{{$usuario->name}}" autocomplete="off" name="name" class="form-control"
                           type="text" placeholder="Nombre">
                </div>
                <div class="form-group">
                    <label class="label">Correo electrónico</label>
                    <input required value="{{$usuario->email}}" autocomplete="off" name="email" class="form-control"
                           type="text" placeholder="Correo electrónico">
                </div>
                <div class="form-group">
                    <label class="label">Contraseña</label>
                    <input required value="{{$usuario->password}}" autocomplete="off" name="password"
                           class="form-control"
                           type="password" placeholder="Contraseña">
                </div>
                <div class="form-group">
                    <label class="label">Tipo de vendedor</label>
                    <select class="form-control" name="tipo" id="tipo">
                        @foreach ($tipos as $item)
                            <option  @if($usuario->tipo == $item->tipo) selected @endif value="{{$item->tipo}}">{{$item->tipo_desc}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="label">Ip de la impresora</label>
                    <input required value="{{$usuario->ip_impresora}}" autocomplete="off" name="ip_impresora" class="form-control"
                           type="text" placeholder="Ej: 192.179.2.34">
                </div>
                @include("notificacion")
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="{{route("usuarios.index")}}">Volver</a>
            </form>
        </div>
    </div>
@endsection
