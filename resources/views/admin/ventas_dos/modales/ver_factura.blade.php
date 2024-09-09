<div class="form-group row" style="width:100%; padding-left: 10px;">
    <div class="table-responsive" style="width: 100%;">
        <table border='1' style="font-size: 10px; width:100%; height: 13.4cm">
            <tr>
                <td style="width: 58%; height: 2.2cm; text-align: center">
                    <span style="font-size: 20px;">BONICA</span>
                </td>
                <td style="width: 42%; height: 2.2cm; text-align: center">
                    <div style="font-size: 18px; align-content: center">Factura</div>
                    <div id="vigencia">
                       
                    </div>
                    <div id="datos">
                        Timbrado Nro. <span id="timbrado_table">

                    </span>
                    </div>	
                    <div style="height: 0.6cm;"></div>
                    
                    <h6>Nro.<span id="factura_table">
                        @if ($factura)
                            @if (isset($detalles_factura->numero_factura))
                                {{ str_pad($detalles_factura->numero_factura, 7, '0', STR_PAD_LEFT) }}
                            @endif
                        @endif
                    </span></h6>
                    
                </td>
            </tr>
            <tr>
                <td colspan="2"  style="height: 1.5cm;">
                    <table border="0"  style="width:100%">
                        <tr>
                            <td style="width:70%">
                                <span id="fecha">
                                    Fecha de Emision:
                                        {{date('Y-m-d')}}
                                </span>
                            </td>
                            <td colspan="2">
                                Condicion de Venta 
                                Contado <span id="contado" class="ml-2">
                                    @if($cerrada->condicion_id == 1)
                                    {{ 'X' }}
                                    @endif
                                </span>
                                Credito <span id="credito" class="ml-2 mr-2">
                                    @if($cerrada->condicion_id == 2)
                                        {{ 'X' }}
                                    @endif
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Usuario: <span id="cliente">  {{$cerrada->persona->name}} </span></td>
                            <td>Ruc <span id="ruc"> {{$cerrada->persona->ruc}} </span></td>
                        </tr>
                        <tr>
                            <td>Direccion <span id="direccion">{{$cerrada->persona->direccion}} </span></td>
                            <td>Telefono <span id="telefono">{{$cerrada->persona->Telefono}}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">	
                    <table style="width: 100%; text-align: center" border="1">
                        <tr>
                            <td style="width: 15%; height: 0.6cm;">Cantidad</td>
                            <td style="width: 40%">Descripcion</td>
                            <td style="width: 15%">Precio Unitario</td>
                            <td style="width: 40%">
                                <table style="width: 100%" border="1">
                                    <tr>
                                        <td colspan="3">IVA</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 33%">Exentas</td>
                                        <td style="width: 33%">5%</td>
                                        <td style="width: 33%">10%</td>
                                    <tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr>
                <td colspan="2" style="height: 4.4cm;">
                <div style="height: 100%; width: 100%; background-image: url('');
                background-attachment: fixed; background-repeat: no-repeat; 
                background-position: center;
                ">
                <table style="width: 100%; height: 100%;" border="1" id="table_fac_detalle">
                        <tr>
                            <td style="width: 12.5%; text-align: center; "><h6>1</h6></td>
                            <td style="width: 34%; "><h6>Servicios Profesionales / Productos</h6></td>
                            <td style="width: 12.5%; text-align: center;"><h6>{{$cerrada->total}}</h6></td>
                            <td style="width: 25%; text-align: center;">
                                <table style="width: 100%; height: 100%;" border="1">
                                    <tr>
                                        <td style="width: 33.3%; "><h6>0</h6></td>
                                        <td style="width: 33.3%; "><h6>0</h6></td>
                                        <td style="width: 33.3%; "><h6>{{$cerrada->total}}</h6></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                </table>
                
            </div>
                </td>
            </tr>
            
            <tr>
                <td colspan="2"  style="width: 100%; height: 0.5cm;">
                    <table style="width: 100%; height: 100%" border="1">
                            <tr>
                                    <td style="width: 70%">Sub Total</td>
                                    <td style="width: 10%; text-align: right;">
                                    </td>
                                    <td style="width: 10%; text-align: right;">
                                    </td>
                                    <td style="width: 10%; text-align: right;"  class="totalpagar"> 
                                        {{$cerrada->total}}
                                    </td>
                                </tr>
                        <tr>
                            <td style="width: 70%">Total Gs. <span id="letras" class="letras"> {{$total_parcial[0]->f_num_let}}  </span></td>
                            <td colspan="3" style="text-align: right;"  class="totalpagar">  </td>
                        </tr>
                        <tr>
                            <td colspan="4">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 25%">Liquidacion del IVA:</td>
                                        <td style="width: 25%">5%: <span id="iva5"> 0 </span></td>
                                        <td style="width: 25%">10%: <span id="iva10">  {{$cerrada->iva}} </span></td>
                                        <td style="width: 25%">Total IVA: <span id="ivaTotal">  {{$cerrada->iva}} </span></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>

                        <tr>
                            <td colspan="2"> <span id="deuda_anterior"> 
                            </span> </td>
                            <td>Total a pagar</td>
                            <td style="text-align: right;" class="totalpagar1">{{$cerrada->total}}</td>
                        </tr>
                        <td>
                                <td></td>
                                <td class="desSaldo" style="color: brown"></td>
                                <td class="desSaldoR" style="text-align: right; color: brown"></td>
                        </td>

                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%; height: 1cm;">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;">
                   
                </td>
            </tr>
        </table>
    </div>
</div>