@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@stop
comunes
@section('content')
    <!-- Tabla -->
    <div>
        <div class="card">
            <div class="card-body">
                <table class="table table-striped" id="tablaCrud" style="width:100%">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Colaborador</th>
                            <th>Activo</th>
                            <th>Entidad</th>
                            <th>Sucursal</th>
                            <th width='120px'>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <!-- Tabla -->
    <!-- Modal -->
    <style>
        .Centerm {
            width: 75%;
            position: fixed;
            top: 15%;
            left: 20%;
            margin-top: -100px;
            margin-left: -100px;
        }
    </style>
    <div class="modal fade" id="formCrudModal" role="dialog" aria-labelledby="formCrudModalTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content Centerm">
                <form id="formCrud">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="formCrudModalTitle"> Hoja de Vida Complete los campos</h5>
                    </div>
                    <div class="modal-body" style="max-height: 90%; overflow-y: auto;">
                        <div class="form-row col-12">
                            <div class="col-6">
                                <input type="hidden" id="id" name="id">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Razón Social : <small>(<span class="text-danger">*para factura*</span>)</small></label>
                                                        {{-- persona --}} 
                                            <input type="text" class="form-control" id="name_persona" name="name_persona"  required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="email" class="col-form-label">Correo (<span
                                                    class="text-danger">*</span>):</label>
                                                     {{-- users --}} 
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="password" class="col-form-label">Clave de Acceso:</label>
                                             {{-- users --}} 
                                            <input type="password" class="form-control" id="password" name="password" >
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="entidad_id">Entidad</label>
                                              {{-- users --}} 
                                            <select name="entidad_id" id="entidad_id" class="select2" style="width: 100%">
                                                @foreach ($entidades as $ent)
                                                    <option value="{{ $ent->id }}"> {{ $ent->name }} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="sucursal_id">Sucursal</label>
                                            {{-- users --}} 
                                            <select name="sucursal_id" id="sucursal_id" class="select2"
                                                style="width: 100%"></select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="tipo">Tipo de Usuario</label>
                                        {{-- users --}} 
                                        <select name="tipo" id="tipo" class="form-control"
                                            onchange="ocultarPersona(this)">
                                            <option value="" selected disabled>Seleccione una opcion</option>
                                            <option value="colaborador">Colaborador</option>
                                            <option value="funcionario">Funcionario</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <label for="tipo">Sueldo</label>
                                         {{-- users --}} 
                                        <input type="number" class="form-control" id="salario" name="salario"
                                            value="0">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col">
                                        <div class="custom-control custom-checkbox mt-5 ml-3">
                                            <input type="checkbox" class="custom-control-input" id="es_colaborador" name="es_colaborador">
                                             {{-- users --}} 
                                            <label class="custom-control-label" for="es_colaborador">Mostrar como Colaborador</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-checkbox mt-5 ml-3">
                                            <input type="checkbox" class="custom-control-input" id="ips"  name="ips">
                                           {{-- users --}} 
                                            <label class="custom-control-label" for="ips">Tiene ips?</label>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="custom-control custom-checkbox mt-5 ml-5">
                                            <input type="checkbox" class="custom-control-input" id="es_activo"
                                                name="es_activo">
                                                 {{-- users --}} 
                                            <label class="custom-control-label" for="es_activo">Activo?</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Ruc: <small>(<span
                                                        class="text-danger">*</span>)</small></label>
                                                         {{-- persona --}} 
                                            <input type="text" class="form-control" id="ruc_persona" name="ruc_persona" required>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="name" class="col-form-label">Nombre Fantasia (<span
                                                    class="text-danger">*</span>): </label>
                                                     {{-- users --}} 
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Dirección:</label>
                                             {{-- persona --}} 
                                            <input type="text" class="form-control" id="direccion_persona"
                                                name="direccion_persona" autofocus>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Barrio:</label>
                                              {{-- users --}} 
                                              <input type="text" class="form-control" id="barrio" name="barrio">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Cumpleaños:</label>
                                             {{-- persona --}}
                                            <input type="date" class="form-control" id="cumple_persona"
                                                name="cumple_persona">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="edad" class="col-form-label">Edad:</label>
                                            {{-- calculo --}}
                                            <input type="text" class="form-control" id="edad" name="edad"
                                                readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="telefono" class="col-form-label">Teléfono:</label>
                                             {{-- persona --}} 
                                            <input type="text" class="form-control" id="telefono_persona"
                                                name="telefono_persona" autofocus>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="telefono" class="col-form-label">Teléfono Emergencia:</label>
                                             {{-- users --}} 

                                            <input type="text" class="form-control" id="telefono_emergencia"
                                                name="telefono_emergencia">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Sexo:</label>
                                           {{-- users --}} 
                                            <select  id="sexo"  name="sexo" class="form-control">
                                                <option value="F" selected>Femenino</option>
                                                <option value="M">Masculino</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Tipo Sangre:</label>
                                          {{-- users --}} 

                                            <select name="clasificacion_sangre" id="clasificacion_sangre" class="form-control">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="AB">AB</option>
                                                <option value="O">O</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Denominacion:</label>
                                             {{-- users --}} 

                                            <select name="tipo_sangre" id="tipo_sangre" class="form-control">
                                                <option value="positivo">Positivo</option>
                                                <option value="negativo">Negativo</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Fecha entrada a la empresa:</label>
                                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Color Favorito:</label>
                                            <input type="text" class="form-control" id="color_favorito"
                                                name="color_favorito">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Comida Favorita:</label>
                                            <input type="text" class="form-control" id="comida_favorita"
                                                name="comida_favorita">
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div class="form-group">
                                            <label for="direccion" class="col-form-label">Estacion Favorita:</label>
                                            <input type="text" class="form-control" id="estacion_favorita"
                                                name="estacion_favorita">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <input class="form-check-input" type="hidden" id="es_cliente_persona"
                                        name="es_cliente_persona" checked>
                                    <input class="form-check-input" type="hidden" id="es_proveedor_persona"
                                        name="es_proveedor_persona" checked>
                                </div>
                            </div>
                        </div>
                        <div class="form-row mt-2" id="data_persona" style="display: none">
                            <hr>
                            <div class="modal-header">
                                <h5 class="modal-title" id="formCrudModalTitle">Persona</h5>
                                <a class="btn btn-secondary ml-5" title="Buscar Datos" target="_blank"
                                    href="https://www.ruc.com.py/"><i class="fa fa-question-circle"
                                        aria-hidden="true"></i>
                                </a>
                                <p><label>Se crea una persona para poder asignar comisiones y salario</label></p>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="sumbitButton" class="btn btn-primary" type="submit">
                            <span id="submitSpinner" class="spinner-border-sm" role="status" aria-hidden="true"></span>
                            Guardar
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="dimisseModal()">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Modal -->
@stop
@section('js')

    <script src=" {{ asset('js/comunes.js') }} "></script>
    <script>
        $(document).ready(function() {

            @php
                echo ' var entidades = ' . json_encode($entidades) . '; ';
                echo ' var sucursales = ' . json_encode($sucursales) . '; ';
                echo ' var entidad_id = ' . auth()->user()->entidad_id . '; ';
                echo ' var sucursal_id = ' . auth()->user()->sucursal_id . '; ';
            @endphp

            var data = {
                table: "tablaCrud",
                ajax: "{{ route('admin.users.datatable') }}",
                topMsg: "",
                footerMsg: "Generado: {{ auth()->user()->name }} {{ date('d/m/Y H:i') }}",
                filename: "Listado de Usuarios",
                title: 'Listado de Usuarios',
                columns: [
                    {data: 'id',name: 'id'},
                    {data: 'name',name: 'name'},
                    {data: 'email',name: 'email'},
                    {data: 'es_colaborador',name: 'es_colaborador',
                        render: function(data, type, row) {
                            return (data) ? 'SI' : 'NO';
                        },
                        className: 'text-center'
                    },
                    {
                        data: 'es_activo',
                        name: 'es_activo',
                        render: function(data, type, row) {
                            return (data) ? 'SI' : 'NO';
                        },
                        className: 'text-center'},
                    {data: 'entidad_name',name: 'entidad_name'},
                    {data: 'sucursal_name',name: 'sucursal_name'},
                    {data: 'acciones',name: 'acciones',orderable: false,searchable: false,class: 'noexport'}
                ]
            };
            toDataTable(data);


            $(document).on('change', '#entidad_id', function() {
                var entidad = $(this).val();
                $('#sucursal_id option').remove().promise().done(function() {
                    $.each(sucursales, function(i, item) {
                        if (entidad == item.entidad_id) {
                            $("#sucursal_id").append("<option value=" + item.id + ">" + item.name + "</option>");
                        }
                    });
                });
            });

        });

        function dimisseModal() {
            $('#formCrudModal').modal('hide');
        }

        function editarListar(ruta) { //kaka
            $('#password').attr('placeholder', 'Solo ingrese si desea cambiar');
            $('#password').attr('required', false);
            getData(ruta).then(function(rta) {
                populateForm('formCrud', JSON.parse(rta));
                var algo = JSON.parse(rta)
                vaciar();
                if(algo['persona'] != null){
                    rellenar(algo['persona'])
                    CalcularEdad()
                }

                $('#formCrudModal').modal('show')

            }).catch(function(error) {
                console.log(error);
                Swal.fire('Ocurrio un Error', error.message, 'error');
            });
        }

        function rellenar(algo) {
            if (algo != 'null') {
                $('#ruc_persona').val(algo['ruc']);
                $('#name_persona').val(algo['name']);
                $('#nombre_fantasia_persona').val(algo['nombre_fantasia']);
                $('#direccion_persona').val(algo['direccion']);
                $('#telefono_persona').val(algo['telefono']);
                $('#cumple_persona').val(algo['cumple']);
                $('#email_persona').val(algo['email']);
                $('#es_cliente_persona').val(algo['es_cliente']);
                $('#es_proveedor_persona').val(algo['es_proveedor']);
            }

        }
        $('#cumple_persona').on('change', function(e) {
            CalcularEdad()
        })
        function CalcularEdad(){
            if($('#cumple_persona').val()){
               const aho_actual = "{{date('Y')}}";
               const  result = $('#cumple_persona').val().split('-');
                
               const edad= aho_actual -  result[0];
               $('#edad').val(edad)
            }
        }
        function vaciar() {
            $('#ruc_persona').val();
            $('#name_persona').val();
            $('#nombre_fantasia_persona').val();
            $('#direccion_persona').val();
            $('#telefono_persona').val();
            $('#cumple_persona').val();
            $('#email_persona').val();
            $('#es_cliente_persona').val();
            $('#es_proveedor_persona').val();
        }


        $('[data-toggle="tooltip"]').tooltip();

        $('#formCrud').on('submit', function(e) {
            e.preventDefault();

            if ($('#id').val()) {
                console.log('update');
                console.log($('#id').val());
                var ruta = "{{ route('admin.users.update') }}";
                var formData = new FormData($('#formCrud')[0]);
                update(formData, ruta);
            } else {
                console.log('store');
                var formData = new FormData($('#formCrud')[0]);
                var ruta = "{{ route('admin.users.store') }}";
                store(formData, ruta);
            }
        });
    </script>
@stop
