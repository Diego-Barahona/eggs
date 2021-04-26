<div id="content-wrapper">
    <div class="container-fluid mb-5">

        <ol class="breadcrumb">
        <li class="breadcrumb-item active">Rutas </li>
        </ol>

        <div class="accordion" id="accordionExample">
        <div class="card mb-3">
            <div class="card-header" id="headingOne">
            <h2 class="mb-0">
                <button class="btn btn-info" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                INSTRUCCIONES
                </button>
            </h2>
            </div>

            <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
            En esta sección podrá administrar la planificación de las rutas diarias, y el control de ventas/clientes .
            </div>
            </div>
        </div>
        </div>

        <div class="card mb-3">
            <div class="card-header">
                <i class="fas fa-table"></i>
                Lista de rutas
                <button class="btn btn-success float-right" type='button' data-toggle="modal" id="btnCreateRoute" data-target="#modalRoute"><i class="fas fa-plus"></i> Registrar Nueva Ruta</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="listRoutes" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Fecha</th>
                                <th>Vendedor</th>
                                <th>Detalle</th>
                                <th>Editar</th>
                                <th>Eliminar</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url(); ?>assets/js_admin/adminRoute.js"></script>