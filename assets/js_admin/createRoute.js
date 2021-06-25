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
idEditClientCigar = '';


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
            tabla.clear();
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
			tabla.rows.add(dataTable);
			tabla.draw();

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
    eggsHeader.forEach((item)=>{
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
            /* Cigars*/
            cigarsRoute = [];
            let op = 0;
            dataTable.forEach((client)=>{
                cigars.forEach((cigar)=>{
                    if(cigar.idClient == client.id){

                        row = {
                            idClient : cigar.idClient,
                            nombre : client.nombre,
                            sector : client.sector,
                            direccion : client.direccion,
                            total: $('#total_cigar_list_'+client.id).val(),
                            data : cigar.data
                        }
                        cigarsRoute.push(row);  
                        op = 1;
                    }
                });

                if(op == 0){
                    let data = [];
                    cigarsList.forEach((cigar)=>{
                        row = {
                            id: cigar.id,
                            nombre: cigar.nombre,
                            precio: cigar.precio,
                            stock: cigar.stock,
                            cantidad: "",
                            total: "",
                            cantidad_anterior: "",
                        }
                        data.push(row);
                    });

                    row = {
                        idClient : client.id,
                        nombre : client.nombre,
                        sector : client.sector,
                        direccion : client.direccion,
                        total: $('#total_cigar_list_'+client.id).val(),
                        data : data
                    }
                    cigarsRoute.push(row);   
                }
                op = 0;
            });

            console.log(cigarsRoute);

            let data = {
                fechaRuta: $('#date_admission').val(),
                codVendedor : $('#seller').val(),
                detalle: route,
                detalleCigars: cigarsRoute
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


/* Admin Cigars */

let stockCigarros = [];
let cigarsByUser = [];
let cigars = []; 
let aux = [];
let cigarsList = [];

/*Constante para rellenar las filas de la tabla: lista de rutas*/
const tabla = $('#listRouteCigars').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [4] ,
        },
        {
            className: "text-center", "targets": [5] ,
        }
    ],
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "sector" },
        { data: "direccion" },
        { defaultContent: "total", "render": 
            function (data, type, row){
                return `<input type="text" value="$ 0" id="total_cigar_list_${row.id}" disabled class="form-control">`
            }
        },
        {
            defaultContent: `<button type='button' name='btn_add_cigars' class='btn btn-info'>
                                  Agregar
                                  <i class="fas fa-plus"></i>
                              </button>`,
		},
	],
});

/*Constante para rellenar las filas de la tabla: lista de rutas*/
const tablaCigarros = $('#listCigars').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [2] ,
        },
        {
            className: "text-center", "targets": [3] ,
        }
    ],
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "precio" }, 
        { data: "stock" }, 
        { defaultContent: "cantidad", "render": 
            function (data, type, row){
                if(row.cantidad){
                    return `<input type="number" min="0" value='${row.cantidad}' class="form-control" id="cantidad_${row.id}" placeholder="Ingrese cantidad">`
                }else{
                    return `<input type="number" min="0" class="form-control" id="cantidad_${row.id}" placeholder="Ingrese cantidad">`
                }
            }
        },
        { defaultContent: "total", "render": 
            function (data, type, row){
                if(row.total){
                    return `<input type="text" value="${row.total}" id="total_cigar_${row.id}" disabled class="form-control">`
                }else{
                    return `<input type="text" value="$ 0" id="total_cigar_${row.id}" disabled class="form-control">`
                }
            }
        },
	],
});


$('#listRouteCigars').on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_add_cigars") {
        idEditClientCigar = data.id;
        getCigars();
        $("#modal_cigars").modal("show");
    }
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$('#listCigars').on("change", "input", function () { 
    let data = tablaCigarros.row($(this).parents("tr")).data();
    let cantidad = parseFloat($('#cantidad_'+data.id).val());
    let stock = parseFloat(data.stock);
    let total = cantidad *  parseFloat(data.precio);
    let cantidad_anterior = 0;
    let op = 0;
    let op1 = 0;
    console.log(cantidad);

    if(cantidad > stock){
        swal({
            title: "Error",
            icon: "error",
            text: 'No queda suficiente Stock del producto.\n'+
            'Cantidad disponible: '+cantidad+'un.\n'+
            'Cantidad definida en la ruta: '+stock+'un.\n',
        }).then(() => {
            $('#cantidad_'+data.id).val('');
            $('#total_cigar_'+data.id).val('$0');
            $("body").removeClass("loading");
        });
    }else{
        console.log(cigars);
        if(cigars.length > 0){
            cigars.forEach((cigar)=>{
                if(cigar.idClient ==  idEditClientCigar){
                    console.log('entro 1');
                    cigar.data.forEach((info)=>{
                        if(info.id == data.id){
                            info.cantidad_anterior = info.cantidad;
                            info.cantidad = cantidad;
                            info.total = cantidad *  parseFloat(data.precio);
                            op1 = 1;
                        }else op = 1;
                    });
                }else op = 1;
            });
            if(op == 1 && op1 == 0) setNewCigarList(total, data, cantidad, cantidad_anterior);
        }else setNewCigarList(total, data, cantidad, cantidad_anterior);
    }
    $('#total_cigar_'+data.id).val(totalFormat(total));
});

let cont = 0;
setNewCigarList = (total, data, cantidad, cantidad_anterior) => {
    console.log(cantidad_anterior);
    cigar = {
        id : data.id,
        nombre : data.nombre,
        precio: data.precio,
        stock: data.stock,
        cantidad: cantidad,
        total: total,
        cantidad_anterior: cantidad_anterior
    }
    aux.push(cigar);
}

/*funcion para traer la lista de los cigarros y cargarla en la tabla*/
getCigars = () => {
    console.log(idEditClientCigar);
    console.log(aux);
    $.ajax({
        type: "GET",
        url: "api/routes/getCigars",
        crossOrigin: false,
        dataType: "json",
        success: (result) => {
            cigarsList = result;
            tablaCigarros.clear();
            if(stockCigarros.length == 0){
                result.forEach((item)=>{
                    row = 
                    {
                        id: item.id,
                        stock : item.stock,
                    }
                    stockCigarros.push(row);
                });
                console.log(stockCigarros);
                tablaCigarros.rows.add(result);
                tablaCigarros.draw();
            }else{
                op = 0;
                data = [];
                cigars.forEach((item)=>{
                    if(idEditClientCigar == item.idClient){
                        op = 1;
                        data = item.data;
                    }
                });   
                console.log(data);
                console.log(op);
                if(op == 1){ /* Ya hay info para ese id de client */
                    /* Actualizar segun stock*/
                    let aux1 = [];
                    stockAcc = 0;
                    data.forEach((item)=>{
                        stockCigarros.forEach((stock)=>{
                            if(item.id == stock.id){
                                stockAcc = stock.stock;
                            }
                        }); 
                        row = 
                        {
                            id: item.id,
                            nombre : item.nombre,
                            precio: item.precio,
                            stock: stockAcc,
                            cantidad: item.cantidad,
                            total: item.total,
                        }
                        aux1.push(row);
                    });  
                    tablaCigarros.rows.add(aux1);
                    tablaCigarros.draw();
                }else{
                    let aux2 = [];
                    stockAcc = 0;
                    result.forEach((item)=>{
                        stockCigarros.forEach((stock)=>{
                            if(item.id == stock.id){
                                stockAcc = stock.stock;
                            }
                        }); 
                        row = 
                        {
                            id: item.id,
                            nombre : item.nombre,
                            precio: item.precio,
                            stock: stockAcc,
                            cantidad: item.cantidad,
                            total: item.total,
                        }
                        aux2.push(row);
                    });  
                    tablaCigarros.rows.add(aux2);
                    tablaCigarros.draw();
                }
                console.log(cigars);
                aux = [];
                console.log(aux);
            }
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

/* Función para cerrar modal seteando en null las variables dinamicas*/
close_modal_add_cigar = () =>{
    idEditClientCigar = '';
    tablaCigarros.clear();
    eggs = []; 
    $('#modal_cigars').modal('hide');
}

addCigar = () =>{
    console.log(aux);
    op = 0;
    if(aux.length > 0){
        row = {
            idClient: idEditClientCigar,
            data: aux
        }
        cigars.push(row);
    }

    /* Actualizar el stock */
    total = 0;
    cigars.forEach((cigar)=>{
        if(cigar.idClient ==  idEditClientCigar){
            stockCigarros.forEach((stockCigarros)=>{
                cigar.data.forEach((data)=>{
                    if(data.id == stockCigarros.id){
                        console.log('Cantidad: '+data.cantidad);
                        console.log('Cantidad anterior: '+data.cantidad_anterior);
                        if((data.cantidad_anterior  < data.cantidad)){

                            if(data.cantidad_anterior == 0){
                                stockCigarros.stock = parseInt(stockCigarros.stock) - parseInt(data.cantidad);
                                data.cantidad_anterior = data.cantidad;
                            }else{
                                cantidadAcc = parseInt(data.cantidad) - parseInt(data.cantidad_anterior);
                                console.log('Cantidad a restar: '+cantidadAcc);
                                stockCigarros.stock = parseInt(stockCigarros.stock) - parseInt(cantidadAcc);
                                console.log(stockCigarros.stock);
                            }
                        }else if(data.cantidad_anterior > data.cantidad){
                            cantidadAcc = parseInt(data.cantidad_anterior) - parseInt(data.cantidad);
                            console.log('Cantidad a sumar: '+cantidadAcc);
                            stockCigarros.stock = parseInt(stockCigarros.stock) + parseInt(cantidadAcc);
                        }
                    }
                });
            });
            console.log(stockCigarros);
            cigar.data.forEach((dataTotal)=>{
                total = total + dataTotal.total;
            });
        }
    });
    console.log(stockCigarros);
    console.log(total);
    $('#total_cigar_list_'+idEditClientCigar).val(totalFormat(total));
    $('#modal_cigars').modal('hide');
    console.log(cigars);
    console.log(aux);
}

$("#btn_add_cigar").on("click", addCigar);