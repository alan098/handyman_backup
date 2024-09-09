<div class="card shadow  col-12">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                <b>Ordenes de insumos</b>
            </x-slot>
            <x-slot name='subtitle'>
            </x-slot>
        </x-cabecera>
        <div class="col"><a href="{{route('admin.ordinsus.store')}}" class="btn btn-primary">Nueva Orden de insumos</a></div>
    </div>
    <div class="card-body">
        <div class="form-row">
            <div  id="responsive_table" class="col-12">
                <table class="table" id="tablaListado">
                </table>
            </div>
        </div>
    </div>
</div>