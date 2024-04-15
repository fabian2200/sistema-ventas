@extends("maestra")
@section("titulo", "Editar usuario")
@section("contenido")
    <div class="row">
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
                        <option @if($usuario->tipo == 2) selected @endif value="2">Tienda</option>
                        <option @if($usuario->tipo == 3) selected @endif value="3">Miscelánea</option>
                    </select>
                </div>
                @include("notificacion")
                <button class="btn btn-success">Guardar</button>
                <a class="btn btn-primary" href="{{route("usuarios.index")}}">Volver</a>
            </form>
        </div>
    </div>
@endsection
