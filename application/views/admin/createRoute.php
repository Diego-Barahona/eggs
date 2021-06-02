<div id="content-wrapper">
    <div class="container-fluid mb-5" id="adminColors">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Rutas</li>
            <li class="breadcrumb-item active">Crear Ruta</li>
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
                        En esta sección podra crear una nueva ruta, asociando todas las ventas del día.
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-header" id="infoGeneralTR">
                <h5 class="mb-0">
                <button class="btn btn-link" data-toggle="collapse" data-target="#infoGeneral" aria-expanded="false" aria-controls="infoGeneral">
                    <i class="fas fa-table"></i>
                    Información general
                </button>
                </h5>
            </div>
            <div id="infoGeneral" class="collapse show" aria-labelledby="infoGeneralTR">
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4 mb-3" id='frm_seller'>
                            <label>Vendedor</label>
                            <select class="form-select form-control" name="seller" id="seller">
                                <option value='0'></option>
                                <?php foreach($sellers as $item) { ?>
                                    <option value='<?= $item['id'] ?>' name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                                <?php } ?>  
                            </select>  
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="actividad">Fecha de ingreso</label>
                            <div class="input-group" id="frm_date">
                                <input type="text" class="form-control" name="date_admission" id="date_admission" placeholder="" aria-describedby="inputGroupPrepend3">
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
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
            <div id="routeEggs" class="collapse" aria-labelledby="eggsTR">
                <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="listRouteEggs" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Sector</th>
                                <th>Dirección</th>
                                <?php foreach($eggs as $item) { ?>
                                    <th><?= $item['name'] ?></th>
                                <?php } ?> 
                                <th>Precio Total</th>
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
                <button class="btn btn-link" data-toggle="collapse" data-target="#routeCigars" aria-expanded="false" aria-controls="routeCigars">
                    <i class="fas fa-table"></i>
                    Cigarros
                </button>
                </h5>
            </div>
            <div id="routeCigars" class="collapse" aria-labelledby="cigarsTR">
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
                                <th>Productos</th>
                            </tr>
                        </thead>
                    </table>
                    </div>
                </div>
            </div>
        </div>
        <div style="margin-right: 40px; margin-top: 20px; margin-bottom: 40px;">
            <button style="float: right" class="btn btn-success" type='button' id="createRoute"> Crear Ruta</button>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="modal_eggs" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Registrar precio a cliente</h5>
                <button type="button" class="close" onclick="close_modal_user('0')" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row mb-2">
                        <div class="col-md-4 mb-3" id='frm_seller'>
                            <label>Cliente</label>
                            <input type="text" class="form-control" id="client" name="client" placeholder="Ingrese nombre" readonly>
                        </div>
                        <div class="col-md-4 mb-3" id='frm_seller'>
                            <label>Tipo de huevo</label>
                            <input type="text" class="form-control" id="tipoHuevo" name="tipoHuevo" placeholder="Ingrese nombre" readonly>
                        </div>
                        <div class="col-md-4 mb-3" id='frm_price'>
                            <label>Precio</label>
                            <input type="number" class="form-control" id="price" min="1" pattern="^[0-9]+" name="price" placeholder="Ingrese precio venta">
                            <div class="invalid-feedback"></div>
                        </div>
                    </div>
                    <div class="form-group float-right">
                        <button onclick="close_modal_user('0')" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                        <button id="createEgg" type="button" class="btn btn-primary btn-success">Asignar</button>
                    </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bd-example-modal-lg" id="modal_cigars" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Agregar Cigarros</h5>
                <button type="button" class="close" onclick="close_modal_add_cigar()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="listCigars" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Cigarro</th>
                                <th>Precio</th>
                                <th>Stock</th>
                                <th>Cantidad</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                    </table>
                </div> 
                <div class="form-group float-right">
                    <button onclick="close_modal_add_cigar()" type="button" class="btn btn-secondary btn-danger">Cerrar</button>
                    <button id="btn_add_cigar" type="button" class="btn btn-primary btn-success">Guardar</button>
                </div>
            </div>
        </div>
    </div>

</div>

<script src="<?php echo base_url(); ?>assets/js_admin/createRoute.js"></script>
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


