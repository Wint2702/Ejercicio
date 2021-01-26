@extends('layouts.app')

@section('title','Registro de prospectos')

@section('js')
<script src="js/jquery.dataTables.min.js"></script>
<script src="js/jquery.filer.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/dayjs@1.9.4/locale/es.js" crossorigin="anonymous"></script>
<script src="js/jquery.form.js"></script>
<script src="js/home.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="css/dataTables.bootstrap4.min.css"  crossorigin="anonymous">
    <link rel="stylesheet" href="css/jquery.filer.css" crossorigin="anonymous">
@endsection

@section('content')
<div class="card shadow-sm mx-4" id="cardProspectos">		
    <div class="card-header">
        <div class="btn-group mt-4">
            <button type="button" class="btn btn-sm btn-success" id='createProspecto'>
                <i class="fas fa-user-plus"></i> Nuevo prospecto
            </button>
        </div>
        <label for="filtroProspectos" class="ml-4 float-right">
            Filtrar por:
            <select name="filtroProspectos" id="filtroProspectos" class="form-control form-control-sm">
                <option value="">Todos los prospectos</option>
                <option value="Enviado">Enviados</option>
                <option value="Autorizado">Autorizados</option>
                <option value="Rechazado">Rechazados</option>
            </select>
        </label>
    </div>
    <div class="card-body ">
        <table class="table filTable table-sm table-striped table-bordered w-100" id='tablaProspectos' data-url='{{route('prospectos.listaCaptura')}}'>
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
            <tbody class="text-center">
                @foreach (App\Models\Prospecto::all() as $prospecto)
                    <tr>
                        <td><button class="btn btn-link editProspecto" data-id="{{$prospecto->id}}">{{$prospecto->id}}</button></td>
                        <td>{{$prospecto->nombre}}</td>
                        <td>{{$prospecto->primer_apellido}}</td>
                        <td>{{$prospecto->segundo_apellido or "no completado"}}</td>
                        <td>{{$prospecto->created_at->formatLocalized('%d/%m/%Y')}}</td>
                        <td>{{$prospecto->estatus}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modals')
<div class="modal fade"  id="modalForms" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert-secondary py-1 pb-2">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">x</span>
                </button>
            </div>
            <div class="modal-body d-none" id="storeProspecto">
                <form id="formProspecto" action="" method="POST">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="col-4 mb-2">
                            <label for="nombre">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control" maxlength="255" required>
                        </div>
                        <div class="col-4 mb-2">
                            <label for="primer_apellido">Primer apellido <span class="text-danger">*</span></label>
                            <input type="text" name="primer_apellido" id="primer_apellido" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-4 mb-2">
                            <label for="segunndo_apellido">Segundo apellido</label>
                            <input type="text" name="segunndo_apellido" id="segunndo_apellido" class="form-control" maxlength="100">
                        </div>
                        <div class="col-4 mb-2">
                            <label for="telefono">Teléfono <span class="text-danger">*</span></label>
                            <input type="text" name="telefono" id="telefono" class="form-control" maxlength="20" required>
                        </div>
                        <div class="col-4 mb-2">
                            <label for="rfc">RFC <span class="text-danger">*</span></label>
                            <input type="text" name="rfc" id="rfc" class="form-control" minlength="12" maxlength="13" required>
                        </div>
                        <hr class="col-10">
                        <div class="col-4 mb-2">
                            <label for="calle">Calle <span class="text-danger">*</span></label>
                            <input type="text" name="calle" id="calle" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-2 mb-2">
                            <label for="numero">Número <span class="text-danger">*</span></label>
                            <input type="text" name="numero" id="numero" class="form-control" maxlength="10" required>
                        </div>
                        <div class="col-4 mb-2">
                            <label for="colonia">Colonia <span class="text-danger">*</span></label>
                            <input type="text" name="colonia" id="colonia" class="form-control" maxlength="100" required>
                        </div>
                        <div class="col-2 mb-2">
                            <label for="codigo_postal">Código postal <span class="text-danger">*</span></label>
                            <input type="number" name="codigo_postal" id="codigo_postal" class="form-control"  minlength="5" maxlength="5" required>
                        </div>
                        <hr class="col-10">
                        <div class="col-12 mb-4">
                            <label for="documentos">Subir documentos de prospecto. <span class="text-danger">*</span></label> <br>
                            <small class="text-muted">Formatos admitidos: PDF, DOCX, DOC, ZIP, XLS y XLSX.</small>
                            <input type="file" id="documentos" name="documentos[]" multiple>
                            <a href="#" id="descargaDocumentos" target="_blank" class="mt-2"  style="display: none"><i class="fas fa-download"></i> Descargar documentos prospecto</a>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer d-block" id="modalNormal">
                <input type="button" data-dismiss="modal" class="btn btn-sm btn-link text-muted float-left" value="Cancelar" id='cancelModal'>
                <input class="btn btn-sm btn-success float-right d-none" type="submit" value="guardar" form='formProspecto' id='guardarProspecto'>
                {{-- <button class="btn btn-sm btn-success float-right d-none" type="submit" form='formProspecto' id='guardarProspecto'>Guardar</button> --}}
                <button type="button" class="btn btn-sm btn-danger float-right" style="display: none" id="btnRechazarProspecto"><i class="fas fa-ban"></i> rechazar prospecto</button>
                <button type="button" class="btn btn-sm btn-success float-right" style="display: none" id="btnAceptarProspecto"><i class="fas fa-check-circle"></i> aceptar prospecto</button>
                <button type="button" class="btn btn-sm btn-link text-danger float-left" id="btnBorrar" style="display: none"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection
