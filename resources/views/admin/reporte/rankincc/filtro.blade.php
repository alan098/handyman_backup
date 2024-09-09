<div class="card shadow mb-3 col-md-12 text-black bg-info">
    <div class="card-header">
        <h3>RANKING DE CLIENTES CITAS CANCELADAS</h3>
    </div>
    <div class="card-body">
            <div class="form-row mb-1">
                <div class="col-sm-1" style="display: none; float: right;" id="esperando">
                    <div class="loader"></div>
                </div>
            </div>
    </div>
    <div class="card-footer  bg-info">
        <style>
            .loader {
                border: 16px solid #f3f3f3;
                border-radius: 50%;
                border-top: 16px solid blue;
                border-right: 16px solid green;
                border-bottom: 16px solid red;
                border-left: 16px solid pink;
                width: 80px;
                height: 80px;
                -webkit-animation: spin 2s linear infinite;
                animation: spin 2s linear infinite;
                position: relative;

            }
            @-webkit-keyframes spin {
                0% {
                    -webkit-transform: rotate(0deg);
                }

                100% {
                    -webkit-transform: rotate(360deg);
                }
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }

                100% {
                    transform: rotate(360deg);
                }
            }
        </style>
        <div class="form-row mr-0 ml-0" style="padding: 0%">
            <div class="col-7">
            </div>
            <div class="col-1" float: right;" id="esperando">
                <div class="loader"></div>
            </div>
            {{-- <div class="col-2">
                <button class="btn btn-success text-dark" onclick="filtrar()" type="button"> Filtrar</button>
            </div> --}}
        </div>
        
    </div>
    </form>
</div>
