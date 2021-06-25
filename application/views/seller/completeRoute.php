<div id="content-wrapper">
    <div class="container-fluid mb-5" id="adminColors">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Rutas</li>
            <li class="breadcrumb-item active">Actualizar Ruta</li>
        </ol>
        <div class="accordion" id="accordionExample">
            <div class="card mb-3">
                <div class="card-header" id="headin">
                    <h2 class="mb-0">
                        <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collaps" aria-expanded="true" aria-controls="collaps">
                        INSTRUCCIONES
                        </button>
                    </h2>
                </div>
                <div id="collaps" class="collapse" aria-labelledby="heading" data-parent="#accordionExample">
                    <div class="card-body">
                        En esta sección podra actualizar la ruta seleccionada.
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="eggsTR">
                <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#routeEggs" aria-expanded="false" aria-controls="routeEggs">
                    <i class="fas fa-table"></i>
                    Huevos
                </button>
                </h5>
            </div>
            <div id="routeEggs" class="collapse show" aria-labelledby="eggsTR">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="listRouteEggs" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Sector</th>
                                <th>Dirección</th>
                                <th>Precio Total</th>
                                <th>Detalles</th>
                                <th>Venta</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="cigarsTR">
                <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#routeEggs" aria-expanded="false" aria-controls="routeCigars">
                    <i class="fas fa-table"></i>
                    Cigarros
                </button>
                </h5>
            </div>
            <div id="routeCigars" class="collapse show" aria-labelledby="cigarsTR">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="listRouteCigars" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Sector</th>
                                <th>Dirección</th>
                                <th>Precio Total</th>
                                <th>Detalles</th>
                                <th>Venta</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal_eggs" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="routeEggs" class="collapse show" aria-labelledby="eggsTR">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="listEggs" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Tipo de Huevo</th>
                                        <th>Cantidad</th>
                                        <th>Formato de venta</th>
                                        <th>Precio de Venta</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>                            
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal_cigars" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="collapse show">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="listCigar" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Cigarro</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>                            
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade bd-example-modal-lg" id="modal_venta_huevos" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Venta</h5>
                <button type="button" class="close" onclick="close_modal_eggs()" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6 mb-3">
                        <label for="actividad">Total</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="total_venta_egg" id="total_venta_egg" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="actividad">Código de venta</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="id_venta" id="id_venta">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6 mb-3">
                        <label>Deuda</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="deuda" id="deuda_egg" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Abono</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="abono" id="abono_egg">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-6 mb-3">
                        <label>Contado</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="contado" id="contado_egg" placeholder="" aria-describedby="inputGroupPrepend3">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3" id='frm_service'>
                        <label>Credito</label>
                        <div class="input-group">
                            <input type="number" class="form-control" name="credito" id="credito_egg" placeholder="" aria-describedby="inputGroupPrepend3">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de proxima visita</label>
                        <div class="input-group" id="frm_date">
                            <input type="text" class="form-control" name="date_admission" id="date_admission" placeholder="" aria-describedby="inputGroupPrepend3">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group float-right">
                      <button onclick="close_modal_eggs()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                      <button id="btn_ok" type="button" class="btn btn-primary btn-success">Registrar venta</button>
                  </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" id="modal_venta_cigarros" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Venta</h5>
                <button type="button" class="close" onclick="close_modal_cigars()" >
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="card-body">
                <div class="row mb-2">
                    <div class="col-md-6 mb-3">
                        <label for="actividad">Total</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="total_venta_cigar" id="total_venta_cigar" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="actividad">Código de venta</label>
                        <div class="input-group">
                            <input type="text" class="form-control" name="id_venta_cigar" id="id_venta_cigar">
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-md-4 mb-3">
                        <label for="actividad">Fecha de proxima visita</label>
                        <div class="input-group" id="frm_date">
                            <input type="text" class="form-control" name="date_admission_cigar" id="date_admission_cigar" placeholder="" aria-describedby="inputGroupPrepend3">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                </div>
                <div class="form-group float-right">
                      <button onclick="close_modal_cigars()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                      <button id="btn_ok" type="button" class="btn btn-primary btn-success">Registrar venta</button>
                  </div>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo base_url(); ?>assets/js_seller/completeRoute.js"></script>
<script>
  $( function() {
    $( "#date_admission").datepicker({
        showOn: "button",
        buttonText: "Calendario",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        buttonImage: host_url + 'assets/img/about/calendario2.png',
    });
  } );
</script>
<script>
  $( function() {
    $( "#date_admission_cigar").datepicker({
        showOn: "button",
        buttonText: "Calendario",
        changeMonth: true,
        changeYear: true,
        dateFormat: 'yy-mm-dd',
        buttonImage: host_url + 'assets/img/about/calendario2.png',
    });
  } );
</script>