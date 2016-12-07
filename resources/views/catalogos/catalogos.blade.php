<!-- 
     * Nombre del archivo: catalogos.blade.php
     * Descripción: Pantalla para seleccionar catalogos
     * Fecha de creación: 4/12/2016
     * Creado por: Karla Barrera
-->
@extends('plantillas.plantilla_sin_columna')
@section('fecha_sistema')
<p ALIGN=left>Fecha:<?=date('d/m/Y g:ia');?></p>
@stop 
@section('usuario_sesion')
<p ALIGN=right>Usuario:{{ Auth::user()->nombre_usuario }}</p>
@stop 
@section('nombre_pantalla')
<h4 class="text-center"></h4>
@stop 
@section('contenido')
<div class="panel panel-default">
    <div class="panel-heading" align="center">MEN&Uacute; DE CAT&Aacute;LOGOS</div>
    <div class="panel-body">
        <!-- la tabla del menu-->
        <div class="container">
            <table class="table" align="center">
                <tr>
                    <th><a href=""> <center><img src="{{asset('images/smile.jpg')}}" alt="colores" class="img-responsive"/></center></a></th>
                    <th><a href="../../administracion/catalogos/ubicacion"><center><img src="{{asset('images/inventario.jpg')}}" alt="ubicacion_organizacional" class="img-responsive"/></center></a></th>
                    <th><a href=""><center><img src="{{asset('images/solicitudes.jpg')}}" alt="municipios" class="img-responsive"/></center></a></th>
                    <th><a href=""><center><img src="{{asset('images/procesos.jpg')}}" alt="departamentos" class="img-responsive"/></center></a></th>
                </tr>             
                <tr align="center">
                    <td>Colores</td>
                  <td>Ubicaci&oacute;n Organizacional</td>
                  <td>Municipios</td>
                  <td>Departamentos</td>
                </tr>
                <tr>
                    <th><a href=""><center><img src="{{asset('images/reportes.jpg')}}" alt="reportes" class="img-responsive"/></center></a></th>
                    <th><a href="../administracion/buscar_usuario"><center><img src="{{asset('images/admin.jpg')}}" alt="administracion" class="img-responsive"/></center></a></th>
                    <th> <a href="#ingreso" data-toggle="modal">
                         <center><img src="{{asset('images/ayuda.jpg')}}" alt="ayuda" class="img-responsive"/></center>
                        </a>
                    </th>
                    <th><a href="{{route('usuario_app/salir')}}"><center><img src="{{asset('images/salir.jpg')}}" alt="salir" class="img-thumbnail"/></center></a></th>
                </tr>  
                 <tr align="center">
                    <td>Reportes</td>
                  <td>Administracion</td>
                  <td>Ayuda</td>
                  <td>Salir</td>
                </tr>
            </table>
        </div>
        <!--fin tabla de menu-->
    </div>
</div>
@stop   