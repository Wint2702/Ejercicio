@extends('layouts.app')

@section('title','Evaluación de prospectos')

@section('js')
<script src="/js/jquery.dataTables.min.js"></script>
<script src="/js/jquery.filer.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dayjs@1.9.4/locale/es.js" crossorigin="anonymous"></script>
<script src="/js/jquery.form.js"></script>
<script src="/js/evaluar.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/css/jquery.dataTables.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/dataTables.bootstrap4.min.css"  crossorigin="anonymous">
    <link rel="stylesheet" href="/css/jquery.filer.css" crossorigin="anonymous">
@endsection

@section('content')
<div class="card shadow-sm mx-4" id="cardProspectos">		
    <div class="card-body" >
        <table class="table filTable table-sm table-striped table-bordered w-100" id='tablaProspectos'>
            <thead class="text-light bg-primary">
                <tr class="text-center">
                    <th style="width:5%;">#</th>
                    <th style="width:30%;">Nombre</th>
                    <th style="width:20%;">Primer apellido</th>
                    <th style="width:20%;">Segundo apellido</th>
                    <th style="width:10%;">Fecha registro</th>
                    <th style="width:15%;">Estatus</th>
                </tr>
            </thead>
            <tbody class="text-center font-weight-bold" id="tbodyProspectos">
                @foreach ($prospectos as $prospecto)
                    <tr>
                        <td>{{$prospecto->id}}</td>
                        <td><button class="btn btn-link evaluarProspecto" style="font-size: 1.2em" data-id="{{$prospecto->id}}">{{$prospecto->nombre}}</button></td>
                        <td>{{$prospecto->primer_apellido}}</td>
                        <td>{{$prospecto->segundo_apellido or "no completado"}}</td>
                        <td>{{$prospecto->created_at->formatLocalized('%d/%m/%Y')}}</td>
                        <td
                        @if ($prospecto->estatus == "Autorizado")
                            style="color:green;"
                        @elseif ($prospecto->estatus == "Rechazado")
                            style="color:red;"
                        @elseif ($prospecto->estatus == "Enviado")
                            style="color:blue;"
                        @endif

                        >{{$prospecto->estatus}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modals')
<div class="modal fade"  id="modalForms" tabindex="-1">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header alert-secondary pb-2">
                <h5 class="modal-title font-weight-bold" id="tituloModal"></h5>
                <button type="button" class="close  py-1" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4 id="nombre"></h4>
                        <ul class="list-unstyled">
                            <li><strong>Folio:</strong> <span class="text-danger" id="folio"></span></li>
                        </ul>
                        <hr>
                        <ul class="list-unstyled">
                            <li><strong>Teléfono:</strong> <span id="telefono"></span></li>
                            <li><strong>RFC:</strong> <span id="rfc"></span></li>
                            <li><strong>Calle:</strong> <span id="calle"></span></li>
                            <li><strong>Número:</strong> <span id="numero"></span></li>
                            <li><strong>Colonia:</strong> <span id="colonia"></span></li>
                            <li><strong>Código postal:</strong> <span id="codigo_postal"></span></li>
                            <li class="d-none"><strong>Dirección:</strong> <span id="direccionCliente"></span></li>
                        </ul>
                        <a href="#" id="descargaDocumentos" target="_blank" class="mt-2"  style="display: none"><i class="fas fa-download"></i> Descargar documentos prospecto</a>

                    </div>
                </div>
            </div>

            <div class="modal-footer d-block" id="modalNormal">
                <input type="button" data-dismiss="modal" class="btn btn-sm btn-link text-muted float-left" value="Cancelar" id='cancelModal'>
                <button type="button" class="btn btn-sm btn-danger float-right" id="btnRechazarProspecto"><i class="fas fa-ban"></i> rechazar prospecto</button>
                <button type="button" class="btn btn-sm btn-success float-right" id="btnAprobarProspecto"><i class="fas fa-check-circle"></i> aceptar prospecto</button>
            </div>
        </div>
    </div>
</div>
@endsection
