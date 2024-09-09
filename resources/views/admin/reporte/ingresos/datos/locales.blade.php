<div class="card shadow  col-12">
    <div class="card-header">
        <x-cabecera>
            <x-slot name='title'>
                Comisiones por Local
                <div class="form-row col-12 border">
                    <div class="col"><h5>Fecha desde</h5></div>
                    <div class="col" id="fe_de_fil">{{date('Y-m-01')}}</div>
                    <div class="col"><h5>Fecha Hasta</h5></div>
                    <div class="col" id="fe_ha_fil">{{date('Y-m-d')}}</div>
                </div>
            </x-slot>
            <x-slot name='subtitle'>
            </x-slot>
        </x-cabecera>
    </div>
    <div class="card-body">
        <div class="form-row">  
            <div class="col-12">
                <table class="table-bordered table-striped" id="table_locales" style="width: 100%">
                    <thead>
                        <tr class="table-primary">
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
