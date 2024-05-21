@extends('maestra')
@section("titulo", "Inicio")
@section('contenido')
<div class="container">
    <br>  
    <div class="card bg-light">
        <article class="card-body mx-auto" style="width: 800px;">
            <div class="row">
                <div style="padding: 20px;" class="col-5">
                    <h4 style="color: #045f01; font-weight: bold">Fecha de Inicio</h4>
                    <input style="font-size: 20px;" id="fecha1" type="date" class="form-control">
                </div>
                <div style="padding: 20px;" class="col-5">
                    <h4 style="color: #5f0101; font-weight: bold">Fecha Final</h4>
                    <input style="font-size: 20px;" id="fecha2" type="date" class="form-control">
                </div>
                <div  style="padding: 20px;" class="col-2">
                    <button onclick="buscarResultados()" class="btn btn-primary" style="font-size: 20px; margin-left: 0px; margin-top: 30px !important;"><i class="fas fa-search"></i></button>
                </div>
            </div>
        </article>
    </div>

    <script>
         $(document).ready(function() {
            var fechaActual = new Date();
            var primerDiaMes = new Date(fechaActual.getFullYear(), fechaActual.getMonth(), 1);
            var urlParams = new URLSearchParams(window.location.search);
            var fecha1Param = urlParams.get('fecha1');
            var fecha2Param = urlParams.get('fecha2');
            $('#fecha1').val(fecha1Param);
            $('#fecha2').val(fecha2Param);
            
        });

        function buscarResultados(){
            var fecha1 = document.getElementById("fecha1").value;
            var fecha2 = document.getElementById("fecha2").value;

            location.href ="venta-por-fecha?fecha1="+fecha1+"&fecha2="+fecha2;
        }
    </script>
</div> 
@endsection
