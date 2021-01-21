@extends('layouts.app')

@section('js')
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>
<script src="https://unpkg.com/dayjs@1.8.21/dayjs.min.js"></script>
<script src="https://unpkg.com/dayjs@1.9.4/locale/es.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.filer@1.3.0/js/jquery.filer.min.js" integrity="sha256-TFa1VJG6Q3vcWkJc2X8WRekAve7r8iw0EeymrjveyIA=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bs-custom-file-input/1.3.4/bs-custom-file-input.min.js" integrity="sha512-91BoXI7UENvgjyH31ug0ga7o1Ov41tOzbMM3+RPqFVohn1UbVcjL/f5sl6YSOFfaJp+rF+/IEbOOEwtBONMz+w==" crossorigin="anonymous"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src="/js/home/home.js"></script>
@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery.filer@1.3.0/css/jquery.filer.css" integrity="sha256-oadZPpy77zsuXe5kQtdf2P5z52iiJykWgkaxzovUIEo=" crossorigin="anonymous">
@endsection

@section('content')
<div class="card shadow-sm mx-4" id="cardContactos">		
    <div class="card-header">
        <div class="btn-group mt-4">
            <button type="button" class="btn btn-sm btn-success" id='createContacto'>
                <i class="fas fa-user-plus"></i> nuevo prospecto
            </button>
        </div>
        <label for="filtroContactos" class="ml-4 float-right">
            Filtrar por:
            <select name="filtroContactos" id="filtroContactos" class="form-control form-control-sm">
                <option value="">Todos los prospectos</option>
                <option>Por evalular</option>
                <option>Cliente</option>
                <option>Rechazado</option>
            </select>
        </label>
    </div>
    <div class="card-body ">
        <table class="table filTable table-sm table-striped table-bordered w-100" id='tablaContactos' data-url=''>
            <thead class="text-light bg-primary">
                <tr class="text-center">
                    <th style="width:5%;">#</th>
                    <th style="width:30%;">Nombre</th>
                    <th style="width:20%;">Apellido paterno</th>
                    <th style="width:20%;">apellido materno</th>
                    <th style="width:20%;">Estatus</th>
                </tr>
            </thead>
            <tbody class="text-center">
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('modals')
<div class="modal fade"  id="modalForms" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert-secondary">
                <h5 class="modal-title" id="tituloModal"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-none" id="storeContacto">
                <form id="formContacto">
                    <div class="form-row">
                        <div class="col-12 mb-2">
                            <label for="nombre">Nombre <span class="text-danger">*</span></label>
                            <input type="text" name="nombre" id="nombre" class="form-control" maxlength="255" required>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="empresa">Empresa</label>
                            <input type="text" name="empresa" id="empresa" class="form-control" maxlength="255">
                        </div>
                        <div class="col-6 mb-2">
                            <label for="puesto">Puesto</label>
                            <input type="text" name="puesto" id="puesto" class="form-control" maxlength="50">
                        </div>
                        <div class="col-6 mb-2">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" id="email" class="form-control" maxlength="255" required>
                        </div>
                        <div class="col-12 mb-2">
                            <label for="direccion">Dirección</label>
                            <textarea class="form-control" name="direccion" id="direccion"></textarea>
                        </div>
                        <div class="col-12 mb-2">
                            <label>Teléfonos</label>
                            <button type="button" class="btn btn-sm text-success btn-link" id='addPhone'>
                                <i class="fas fa-plus-circle"></i> agregar
                            </button>
                            <button type="button" class="btn btn-sm btn-link text-muted" id="cancelAddPhone" style="display:none;">cancelar</button>
                        </div>
                    </div>
                </form>
                <form class="form-group" id="formAgregarTelefono" style="display: none">
                    <div class="form-row">
                        <div class="col-4 mb-2">
                            {{-- <label for="idTelefono">Identificador</label> --}}
                            <input type="text" name="identificador" id="identificador" class="form-control" maxlength="100" placeholder="identificador" required>
                        </div>
                        <div class="col-4 mb-2">
                            {{-- <label for="idTelefono">Teléfono</label> --}}
                            <input type="text" name="telefono" id="telefono" class="form-control" maxlength="50" placeholder="teléfono" required>
                        </div>
                        <div class="input-group-append mb-2">
                            <input class="btn btn-sm btn-success" type="submit" value="agregar" id="submitTelefono">
                        </div>
                    </div>
                </form>
                <div class="table-responsive">
                    <table class="table table-sm table-hover table-bordered mb-0" id="tablaTelefonos" style="display: none">
                        <thead class="table-info">
                            <tr class="text-center">
                                <th style="width:45%">Identificador</th>
                                <th style="width:45%">Teléfono</th>
                                <th style="width:10%">Borrar</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-body d-none" id='storePropuesta'>
                <form id='formPropuesta' data-url="" data-mode="">
                    <fieldset id="fieldsetFormPropuesta">
                        <div class="form-row">
                            <div class="col-6 mb-2">
                                <label>Cliente <span class="text-danger">*</span></label>
                                <select name="cliente" id="cliente" class="form-control" style="width: 100%" required>
                                    <option selected disabled>Seleccionar cliente...</option>
                                    {{-- @foreach (App\Models\ClienteNew::all()->sortBy("nombre") as $cliente) --}}
                                    {{-- <option value="{{$cliente->id}}">{{$cliente->nombre}}</option> --}}
                                    {{-- @endforeach --}}
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label for="servicio">Tipo de servicio  <span class="text-danger">*</span></label>
                                <select name="servicio" id="servicio" class="form-control" required>
                                    <option selected disabled>Seleccionar tipo de servicio...</option>
                                    {{-- @foreach (App\Models\ServicioProspectacion::all() as $servicio) --}}
                                    {{-- <option value="{{$servicio->id}}">{{$servicio->nombre}}</option> --}}
                                    {{-- @endforeach --}}
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label for="costo">Costo propuesto</label>
                                <input type="text" class="form-control moneyInput" id="costo" name="costo">
                            </div>
                            <div class="col-6 mb-2">
                                <label for="anticipo">Cantidad anticipo</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                            <input type="checkbox" checked id="anticipoRequerido">
                                        </div>
                                    </div>
                                    <input type="text" class="form-control moneyInput" id="anticipo" name="anticipo">
                                </div>
                            </div>
                            <div class="col mb-2">
                                <label for="alcance">Alcance del servicio</label>
                                <textarea name="alcance" id="alcance" class="form-control"></textarea>
                            </div>
                            <div class="col mb-2" id="inputNoAnticipo" style="display: none">
                                <label for="noAnticipo">Justificacion de no anticipo</label>
                                <textarea name="noAnticipo" id="noAnticipo" class="form-control"></textarea>
                            </div>
                            <div class="col-12">

                            </div>
                            <div class="col-12 mb-2">
                                <a href="#" id="verContrato" target="_blank"  style="display: none"><i class="fas fa-download mb-3 mt-3"></i> Descargar contrato</a> <br>
                                <label for="contrato">Subir contrato firmado  </label> <br>
                                <input type="file" name="contrato" id="contrato" class="form-control-file">

                            </div>
                            <div class="col-12 mb-2">
                                <a href="#" id="verCartaPoder" target="_blank"  style="display: none"><i class="fas fa-download mb-3 mt-3"></i> Descargar carta poder</a> <br>
                                <label for="cartaPoder">Subir carta poder</label>
                                <input type="file" name="cartaPoder" id="cartaPoder" class="form-control-file">
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer d-block" id="modalNormal">
                <input type="button" data-dismiss="modal" class="btn btn-sm btn-link text-muted float-left" value="Cancelar" id='cancelModal'>
                <input class="btn btn-sm btn-success float-right" type="button" value="Crear propuesta" form='formContacto' id='createPropuesta' style="display: none">
                <input class="btn btn-sm btn-info float-right d-none" type="submit" value="guardar" form='formContacto' id='saveContacto'>
                <input class="btn btn-sm btn-info float-right d-none" type="submit" value="guardar" form='formPropuesta' id="guardarPropuesta" disabled>
                <button type="button" class="btn btn-sm btn-danger float-right" style="display: none" id="btnRechazarPropuesta"><i class="fas fa-ban"></i> rechazar propuesta</button>
                <button type="button" class="btn btn-sm btn-success float-right" style="display: none" id="btnAceptarPropuesta"><i class="fas fa-check-circle"></i> aceptar propuesta</button>
                {{-- <button type="button" class="btn btn-sm btn-warning float-right"   id="btnGenerarPropuesta"><i class="fas fa-file-upload"></i> generar propuesta</button> --}}
                {{-- <button type="button" class="btn btn-sm btn-primary float-right"  id="btnEnviarPropuesta"><i class="fas fa-paper-plane"></i> enviar propuesta</button> --}}
                <button type="button" class="btn btn-sm btn-link text-danger float-left" id="btnBorrar" style="display: none"><i class="fas fa-trash-alt"></i></button>
            </div>
        </div>
    </div>
</div>
@endsection
