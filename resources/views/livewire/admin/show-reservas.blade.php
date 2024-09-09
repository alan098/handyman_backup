<div>

    <div class="card">
        <form action="">
            @csrf
            <h5 class="card-header">
                <a data-toggle="collapse" href="#collapse-example" aria-expanded="true" aria-controls="collapse-example"
                    id="heading-example" class="d-block">

                    <h4 class="text-muted">Calendario de Colaboradores
                        <span class="h6">
                            Elija uno de estos filtros para visualizar la informacion que desea
                        </span>

                        <i class="fa fa-chevron-down pull-right float-right"></i>
                    </h4>

                </a>
            </h5>
            <div id="collapse-example" class="collapse show" aria-labelledby="heading-example">
                <div class="card-body">

                    <div class="form-group row">
                        <label for="fecha" class="col-sm-2 col-form-label">Fecha</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">
                                      <i class="fas fa-calendar-alt"></i>
                                  </span>
                                </div>
                                <input type="text" class="form-control form-control-sm datepicker" id="fecha" name="fecha" value="{{ date('d/m/Y') }}">
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="sucursal" class="col-sm-2 col-form-label">Sucursal</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">
                                      <i class="fas fa-building"></i>
                                  </span>
                                </div>
                                <select name="sucursal" id="sucursal" class="form-control form-control-sm" style="width:90%">
                                    @foreach ($sucursales as $suc)
                                        <option value="{{ $suc->id }}"> {{ $suc->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="colaborador" class="col-sm-2 col-form-label">Colaboradores</label>
                        <div class="col-sm-10">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">
                                      <i class="fas fa-users"></i>
                                  </span>
                                </div>
                                <select name="colaborador" id="colaborador" class="form-control form-control-sm" style="width:90%">
                                    <option value="">Elija los Colaboradores que desee ver</option>
                                    @foreach ($colaboradores as $c)
                                        <option value="{{ $c->id }}"> {{ $c->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button class="btn btn-primary float-right" id="">
                    <i class="fas fa-filter"></i>Filtrar
                </button>
            </div>
        </form>
    </div>


</div>


