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
                        <div class="col-md-4 mb-3">
                            <label for="actividad">Id</label>
                            <div class="input-group" id="frm_date">
                                <input type="text" class="form-control" name="id" value='<?= $id ?>' id="id" placeholder="" aria-describedby="inputGroupPrepend3" readonly>
                                <div class="invalid-feedback"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3" id='frm_seller'>
                            <label>Vendedor</label>
                             <select class="form-select form-control" name="seller" id="seller" readonly>
                                <?php foreach($sellers as $item) { 
                                if($vendedor == $item['id']){
                                ?>
                                    <option value='<?= $item['id'] ?>' selected="true" name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                                <?php }else{ ?>  
                                    <option value='<?= $item['id'] ?>' name='<?= $item['name'] ?>'><?= $item['name'] ?></option>
                                <?php }} ?>  
                            </select>    
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="actividad">Fecha de ingreso</label>
                            <div class="input-group" id="frm_date">
                                <input type="text" class="form-control" name="date_admission" value='<?= $fecha ?>' id="date_admission" placeholder="" aria-describedby="inputGroupPrepend3" readonly>
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


<script src="<?php echo base_url(); ?>assets/js_admin/detailsRoute.js"></script>