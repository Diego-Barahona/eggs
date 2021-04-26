$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getDataForm(); /* Funcion para traer los datos necesarios para la insersion de productos*/
});

productos = []; //Variable para ir actualizando la tabla de productos
tipoProductoData  = [];
eggsData  = [];
eggsHeader = [];
eggsStock = [];
dataTable = [];
clients = [];
idEdit = '';
idEggEdit = '';
idClientEdit = '';
cantidadInput = '';


$("#price").change(() =>{ 
	let price = $("#price").val();
	if(price){
		$("#frm_price > input").removeClass("is-invalid");
	}else{
		$("#frm_price > input").addClass("is-invalid");
	}
});

$("#date_admission").change(() =>{ 
	let date= $("#date_admission").val();
	if(date){
		$("#frm_date > input").removeClass("is-invalid");
	}else{
		$("#frm_date > input").addClass("is-invalid");
	}
});

$("#seller").change(() => { 
	let seller = $("#seller").val();
	if(seller){
		$("#frm_seller > select").removeClass("is-invalid");
	}else{
		$("#frm_seller > select").addClass("is-invalid");
	}
});

/* Función que cargara en mis variables globales toda la información necesaria para trabajar */
/* Incluye la definición de la Datatable*/
getDataForm = () => {
    $.ajax({
        type: "GET",
        url: host_url + "api/routes/getDataForm",
        dataType: "json",
        success: (xhr) => {
            /*Almacenar la información de los huevos*/
            xhr[0].forEach((item)=>{
                eggsData.push(item);
            });
            /*Almacenar la información general de los clientes */
            clients = xhr[1];

            /*Almacenar todos los tipos de huevos existentes para llenar las cabeceras de la tabla de forma dinamica */
            eggsHeader = xhr[2];

            /*Almacenar los stock de los diferentes huevos*/
            xhr[2].forEach((item)=>{
                eggsStock.push(item.stock);
            });

            /*Almacenar la informacion de los clientes que iran en la Datatable*/
            clients.forEach((item)=>{
                row = 
                {
                    id: item.id,
                    nombre : item.nombre,
                    sector : item.sector,
                    direccion : item.calle + item.numero,
                    total : ''
                }
                dataTable.push(row);
            });

            /* Definicion de Datatable */
            let columns = [];
            columns.push({ data: "id" });
            columns.push({ data: "nombre" });
            columns.push({ data: "sector" });
            columns.push({ data: "direccion" });
            
            eggsHeader.forEach((item)=>{
                columns.push({ defaultContent: item.name, "render": function (data, type, row){
                    return `<input type="number" min="0" class="form-control" id="${row.id}_${item.id}" name="${item.id}" placeholder="Ingrese cantidad">`
               }});
            });

            columns.push({ defaultContent: "total", "render": function (data, type, row){
                    return `<input type="text" value="0" id="total_${row.id}" disabled class="form-control">`
            }});

            $('#listRouteEggs').DataTable({
                // searching: true,
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
                },
                data : dataTable,
                columns: columns,
                "paging": false,
                fixedHeader: true,
            });
            /* Fin Definicion de Datatable */

            /*  */
        }, 
        error: () => {
			swal({
				title: "Error",
				icon: "error",
				text: "No se pudo encontrar el recurso",
			}).then(() => {
				$("body").removeClass("loading");
			});
		},
    });  
}

/* Función de set para los input de la Datatable */
$("#listRouteEggs").on("change", "input", function () {
    let op = false;
    let precio = 0;
    eggsHeader.forEach((item)=>{
        if($(this)[0].name == item.id){
            let id = $(this)[0].id;
            let id_client = id.split("_", 1);
            id_client = id_client.join();
            let id_egg = $(this)[0].name;
            cantidadInput = $('#'+id).val();
            
            /* Revisar si hay suficiente stock para el huevo */
            let contStock = 0;
            clients.forEach((item)=>{
                if($('#'+item.id+'_'+id_egg).val()){
                    contStock = contStock + parseInt($('#'+item.id+'_'+id_egg).val());
                };
            });

            if(eggsStock[id_egg-1] < contStock){
                swal({
                    title: "Error",
                    icon: "error",
                    text: 'No queda suficiente Stock del producto.\n'+
                    'Cantidad disponible: '+eggsStock[id_egg-1]+'un.\n'+
                    'Cantidad definida en la ruta: '+contStock+'un.\n',
                }).then(() => {
                    $('#'+id).val('');
                    $("body").removeClass("loading");
                });
            }else{
                /* Revisar si tiene un precio asignado para ese huevo */
                eggsData.forEach((item)=>{
                    if(item.codProducto == id_egg && item.idCliente == id_client){
                        op = true;
                        precioInput = item.precio;
                        format= item.format;
                    } 
                });
                /* En caso de tener un precio se procede a calcular el total */
                if(op == true){
                    let total = 0;
                    /* Recorremos todas las cabeceras calculando el precio de los huevos */
                    eggsHeader.forEach((item)=>{
                        let id_mov = id_client+'_'+item.id;
                        /* En caso de encontrar la casilla donde hicimos el cambio calculamos el total */
                        if(id_mov == id)
                        {
                            total = total + parseInt( Math.ceil(parseFloat(cantidadInput * format)) * precioInput);
                        }else
                        /* En caso de ser otra casilla calculamos el valor del huevo solo si tiene una cantidad especificada */
                        {
                            cantidad = $('#'+id_mov).val();
                            if(cantidad){
                                precio = getPrice(id_client ,item.id);
                                format = getFormat(item.id);
                                total = total + parseInt( Math.ceil(parseFloat(cantidad * format))* precio);
                            }
                        }
                    });
                    $('#total_'+id_client).val(totalFormat(total));
                }else{
                /* En caso de no tener un precio se procede a consultar si se requiere establecer*/ 
                swal({
                    title: `Este cliente no tiene configurado un precio para este tipo de huevo`,
                    icon: "warning",
                    text: "¿Desea asignar precio?",
                    buttons: {
                        confirm: {
                            text: "Asignar",
                            value: "assign",
                        },
                        cancel: {
                            text: "Cancelar",
                            value: "cancelar",
                            visible: true,
                        },
                    },
                    }).then((action) => {
                        if (action == "assign") {
                            /* En caso de ser positiva la accion, se procede a setear el precio para el cliente*/ 
                            createPriceEgg(id_client, id_egg, id);
                        } else {
                            $('#'+id).val('');
                            swal.close();
                        }
                    });
                }
            }
        };
    });
});

/* Función para obtener el precio y el formato de la columa huevo que ha recibido un Input */
getPrice = (idClient, idEgg) => {
    let precio = 0;
    eggsData.forEach((item)=>{
        if(item.codProducto == idEgg && item.idCliente == idClient){
           precio = parseInt(item.precio);
        }
    });
    return precio;
}

/* Función para obtener el precio y el formato del huevo que se esta recorriendo */
getFormat = (idEgg) => {
    /* Devuelve el formato asignado para ese huevo */
    let format = 0;
    eggsHeader .forEach((item)=>{
        if(item.id == idEgg){
            format= item.format;
        } 
    });
    return format;
}

/* Función para abrir modal con la respectiva información para setear el formulario*/
createPriceEgg = (id_client, id_egg, id) => {
    eggsHeader.forEach((item)=>{
        if(item.id == id_egg)
        {
            $('#tipoHuevo').val(item.name);
        }
    });
    clients.forEach((item)=>{
        if(item.id == id_client)
        {
            $('#client').val(item.nombre);
        }
    });
    idEdit = id;
    idEggEdit = id_egg;
    idClientEdit = id_client;
    $("#modal_eggs").modal("show");
}

/* Función para cerrar modal seteando en null las variables dinamicas*/
close_modal_user = (op) =>{
    if(op == 0){
        $('#'+idEdit).val('');
    }
    idEdit = '';
    idEggEdit = '';
    idClientEdit = '';
    cantidadInput = '';
    $('#price').val('');
    $("#frm_price> input").removeClass("is-invalid");
    $('#modal_eggs').modal('hide');
}

setNewEgg = () =>{
    let total = 0;
    let price = 0;
    /* Recorremos todas las cabeceras calculando el precio de los huevos */
    eggsHeader.forEach((item)=>{
        let id_mov = idClientEdit+'_'+item.id;
        price = $('#price').val();
        format = getFormat(idEggEdit);
        console.log(format);
        /* En caso de encontrar la casilla donde hicimos el cambio calculamos el total */
        console.log('ID recorrido: '+id_mov+'  == '+'ID CLIENTE EDITAR: '+idClientEdit+'_'+idEggEdit);
        if(id_mov == idClientEdit+'_'+idEggEdit)
        {
            let egg = {
                id: "10",
                codProducto: idEggEdit,
                idCliente: idClientEdit,
                name: "",
                precio: price,
                format: format,
            } 
            eggsData.push(egg);
            precio = getPrice(idClientEdit , idEggEdit);
            format = getFormat(idEggEdit);
            total = total + parseInt( Math.ceil(parseFloat(cantidadInput * format))* precio);
        }else
        /* En caso de ser otra casilla calculamos el valor del huevo solo si tiene una cantidad especificada */
        {
            cantidad = $('#'+id_mov).val();
            if(cantidad){
                precio = getPrice(idClientEdit ,item.id);
                format = getFormat(item.id);
                total = total + parseInt( Math.ceil(parseFloat(cantidad * format))* precio);
            }
        }
    });
    $('#total_'+idClientEdit).val(totalFormat(total));
}

/* Función para crear una nueva asignación de precio a un cliente*/
createEgg = () => {
    let price = $('#price').val();
    if(!price){
        $("#frm_price > div").html('Debe ingresar un precio de venta'); $("#frm_price > input").addClass("is-invalid");
    }else{
        let data = {
            precio: price,
            client: idClientEdit,
            id: idEggEdit,
        };
    
        url = "api/createEggClient";
        $.ajax({
            data: { data },
            type: "POST",
            url: host_url + url,
            crossOrigin: false,
            dataType: "json",
            success: (result) => {
                swal({
                    title: "Éxito!",
                    icon: "success",
                    text: result.msg,
                    button: "OK",
                }).then(() => {
                    setNewEgg();
                    close_modal_user('1');
                });
            },
            error: () => {
                swal({
                    title: "Error",
                    icon: "error",
                    text: "No se pudo encontrar el recurso",
                }).then(() => {
                    $("body").removeClass("loading");
                });
            },
        });
    }
}

/* Función para crear una nueva ruta*/
createRoute = () => {
    let aux = 0;

    if(!$('#date_admission').val()){
        $("#frm_date > div").html('Debe ingresar una fecha de ruta'); $("#frm_date > input").addClass("is-invalid");
        aux++;
    }

    if($('#seller').val() == 0){
        $("#frm_seller > div").html('Debe seleccionar un vendedor para la ruta'); $("#frm_seller > select").addClass("is-invalid");
        aux++;
    }

    if(aux == 0){
        let route = [];
        let cont = 0;
        clients.forEach((item)=>{
            let eggs = [];
            eggsHeader.forEach((egg)=>{
                cantidad = $('#'+item.id+'_'+egg.id).val();
                let price =  getPrice(item.id, egg.id);
                let format =  getFormat(egg.id);
                eggData = {
                    id: egg.id,
                    name: egg.name,
                    cantidad: cantidad,
                    precioventa: price,
                    formato: format,
                    total: parseInt( Math.ceil(parseFloat(cantidad * format) * price)),
                };
                eggs.push(eggData);
            });
            total = $('#total_'+item.id).val();
            total = total.replace('$', '');
            total = parseInt(total.replace('.', ''));
            console.log(total);
            client = 
            {
                id: item.id,
                nombre : item.nombre,
                sector : item.sector,
                direccion : item.calle + item.numero,
                total : total,
                Huevos: eggs,
                state: 0,
            };
            route.push(client);
    
            if($('#total_'+item.id).val() != 0){cont++;}
            console.log(route);
        });
    
        if(cont != 0){
            let data = {
                fechaRuta: $('#date_admission').val(),
                codVendedor : $('#seller').val(),
                detalle: route,
            };

            $.ajax({
                data: { data },
                type: "POST",
                url: host_url + "api/routes/createRoute",
                crossOrigin: false,
                dataType: "json",
                success: (result) => {
                    swal({
                        title: "Éxito!",
                        icon: "success",
                        text: result.msg,
                        button: "OK",
                    }).then(() => {
                        window.location.assign(host_url+"adminRoutes");
                    });
                },
                error: () => {
                    swal({
                        title: "Error",
                        icon: "error",
                        text: "No se pudo encontrar el recurso",
                    }).then(() => {
                        $("body").removeClass("loading");
                    });
                },
            });
        }else{
            swal({
                title: "Error",
                icon: "error",
                text: 'Para guardar la ruta debe ingresar información para minimo un cliente ',
            }).then(() => {
                $("body").removeClass("loading");
            });
        }
    }else{
        swal({
            title: "Error",
            icon: "error",
            text: 'Ingrese todos los campos de la información general',
        }).then(() => {
            $("body").removeClass("loading");
        });
    }
}

/* Función que devuelve el total de la compra de un cliente en formato CLP*/
totalFormat = (total) => {
    const formatterPeso = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
      })
    return formatterPeso.format(total);
}


$("#createRoute").on("click", createRoute);
$("#createEgg").on("click", createEgg);