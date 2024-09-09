{/* <script>
  
    $( document ).ready(function() {
    //datatable resumen
    var data = {
                table: "tablaCrudResumen",
                ajax: {
                url: "{{ route('admin.cuenta.cliente.cuentasResumen') }}",
                    data : function(d){
                        d.cliente= $('#cliente_id').val();
                        d.desde= $('#fecha_desde').val();
                        d.hasta= $('#fecha_hasta').val();
                        d.estado= $('#estados').val();
                        d.sucursal= $('#sucursales').val();
                    },
                },
                topMsg: "",
                footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
                filename: "Listado de cuentas totales",
                title: 'Listado',
                columns: [
                    {data: 'cobrado', name: 'cobrado'},
                    {data: 'descuentos', name: 'descuentos', 'defaultContent': ''},
                    {data: 'facturados', name: 'facturados', 'defaultContent': ''},
                    {data: 'cerrados', name: 'cerrados', 'defaultContent': ''},
                    {data: 'pendientes', name: 'pendientes', 'defaultContent': ''},
                    {data: 'cuentas', name: 'cuentas', className : "text-right", 'defaultContent': ''},
                ]
            };
            toDataTableSimple(data);

        //datatable data
        var dataDos = {
                table: "tablaCrud",
                ajax : {
                    url: "{{ route('admin.cuenta.cliente.cuentasDatatable') }}",
                    data : function(d){
                        d.cliente= $('#cliente_id').val();
                        d.desde= $('#fecha_desde').val();
                        d.hasta= $('#fecha_hasta').val();
                        d.estado= $('#estados').val();
                        d.sucursal= $('#sucursales').val();
                    },
                },
                topMsg: "",
                footerMsg: "Generado: {{ auth()->user()->name }} {{ date("d/m/Y H:i") }}",
                filename: "Listado de Cuentas",
                title: 'Listado de Cuentas',
                columns: [
                    {data: 'fecha', name: 'fecha'},
                    {data: 'start', name: 'start', 'defaultContent': ''},
                    {data: 'end', name: 'end', 'defaultContent': ''},
                    {data: 'cliente', name: 'cliente', 'defaultContent': ''},
                    {data: 'numero_factura', name: 'numero_factura', 'defaultContent': ''},
                    {data: 'estado', name: 'estado', title: 'Estado', className : "text-right", 'defaultContent': ''},
                    {data: 'total', name: 'total', title:'total', className : "text-right", 'defaultContent': ''},
                    {data: 'total', name: 'total', title:'total', className : "text-right", 'defaultContent': ''},
                    {data: 'total', name: 'total', title:'total', className : "text-right", 'defaultContent': ''},
                    {data: 'descuento', name: 'descuento', title:'total', className : "text-right", 'defaultContent': ''},
                    {data: 'iva', name: 'iva', title:'Iva', className : "text-right", 'defaultContent': ''},
                    {data: 'acciones', name: 'acciones', orderable: false, searchable: false, class: 'noexport'}
                ]
            };
        toDataTable(dataDos);

        $("#cliente_id").change(function(){
            console.log($('#cliente_id').val())
            console.log($('#fecha_desde').val())
            console.log($('#fecha_hasta').val())
            console.log($('#estados').val())
            console.log($('#sucursales').val())
            $('#tablaCrud').DataTable().ajax.reload();
            $('#tablaCrudResumen').DataTable().ajax.reload();
        })
        
    })//ready

</script> */}