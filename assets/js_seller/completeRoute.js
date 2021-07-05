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

clients = [];
clientCigars = [];
detalle = '';
detalleCigars = '';
totalShow = '';
debts = [];
idEditClientCigar = '';
idEditClientEgg = '';

let stockCigarros = [];
let stockCigarrosReserva = [];

let stockEggs = [];
let stockEggsReserva = [];


let cigarsByUser = [];


let cigars = []; 
let eggs = []; 

let aux = [];
let auxEggs = [];

let cigarsList = [];
let eggsList = [];
/* Función que cargara en mis variables globales toda la información necesaria para trabajar */
/* Incluye la definición de la Datatable*/
getDataForm = () => {
    let actual = window.location+'';
    let split = actual.split("/");
    let id = split[split.length-1];
    let das = id.split("?");
    let d = das[1].split("=");
    let idRoute = d[1];
    id = idRoute;
    $.ajax({
        type: "GET",
        url: host_url + 'api/routes/getDataFormUpdate'+'?id='+id,
        dataType: "json",
        success: (xhr) => {
            debts = xhr[4];
            /*Almacenar la información general de los clientes */
            xhr[3].forEach((eggs)=>{
                let row = 
                {
                    id : eggs.id,
                    stock: 0,
                };
                stockEggsReserva.push(row);
            });
            console.log(stockEggsReserva);

            detalle = JSON.parse(xhr[1]['detalle']);
            detalle.forEach((item)=>{
                let row = 
                {
                    id : item.id,
                    nombre : item.nombre,
                    sector : item.sector,
                    direccion : item.direccion,
                    total : totalFormat(item.total),
                    huevos: item.Huevos,
                };
                clients.push(row);
                    (item.Huevos).forEach((egg)=>{      
                        stockEggsReserva.forEach((reserva)=>{
                            if(egg.id == reserva.id){
                                if(egg.cantidad){
                                    suma = parseInt(reserva.stock)+parseInt(egg.cantidad);
                                    reserva.stock = suma;
                                }
                            }
                        });
                    });
                    console.log(stockEggsReserva);

                    if(item.total != '0'){

                        init = {
                            idClient: item.id,
                            data: item.Huevos,
                        }
                        eggs.push(init);
                    }
            });
            console.log(eggs);
            tabla.clear();
			tabla.rows.add(clients);
			tabla.draw();

            xhr[5].forEach((cigars)=>{
                let row = 
                {
                    id : cigars.id,
                    stock: 0,
                };
                stockCigarrosReserva.push(row);
            });

            detalleCigars = JSON.parse(xhr[1]['detalle_cigarros']);  
            detalleCigars.forEach((item)=>{
                /* if(item.total != '$ 0'){ */
                    let row = 
                    {
                        id : item.idClient,
                        nombre : item.nombre,
                        sector : item.sector,
                        direccion : item.direccion,
                        total : item.total,
                        cigars: item.data
                    };
                    clientCigars.push(row); 

                    (item.data).forEach((cigar)=>{      
                        stockCigarrosReserva.forEach((reserva)=>{
                            if(cigar.id == reserva.id){
                                if(cigar.cantidad){
                                    suma = parseInt(reserva.stock)+parseInt(cigar.cantidad);
                                    reserva.stock = suma;
                                }
                            }
                        });
                    });
                    console.log(stockCigarrosReserva);

                    if(item.total != '$ 0'){

                        init = {
                            idClient: item.idClient,
                            data: item.data,
                        }
                        cigars.push(init);
                    }
            });

            tablaClientCigar.clear();
			tablaClientCigar.rows.add(clientCigars);
			tablaClientCigar.draw();

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


/*Constante para rellenar las filas de la tabla: lista de usuarios*/
const tabla = $('#listRouteEggs').DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "paging": false,
    fixedHeader: true,
    "columnDefs": [
        {
            className: "text-center", "targets": [5] ,
        },
        {
            className: "text-center", "targets": [6] ,
        },
        {
            className: "text-center", "targets": [7] ,
        },
    ],
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "sector" },
        { data: "direccion" },
        { data: "total" },
        { defaultContent:   `<button type='button' name='btn_add_egg' class='btn btn-info'>
                                Agregar
                              <i class="fas fa-plus"></i>
                            </button>`
        },
        { defaultContent:   `<button type='button' name='btn_details' class='btn btn-info'>
                                Detalles
                                <i class="fas fa-search"></i>
                            </button>`
        },
        { defaultContent:   `<button type='button' name='btn_sale' class='btn btn-info'>
                                Venta
                                <i class="fas fa-cash-register"></i>
                            </button>`
        },            
	],
});

/*Constante para rellenar las filas de la tabla: lista de usuarios*/
const tablaClientCigar = $('#listRouteCigars').DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "paging": false,
    fixedHeader: true,
    "columnDefs": [
        {
            className: "text-center", "targets": [5] ,
        },
        {
            className: "text-center", "targets": [6] ,
        },
          {
            className: "text-center", "targets": [7] ,
        },
    ],
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "sector" },
        { data: "direccion" },
        { defaultContent: "total", "render": function (data, type, row){
                return `<span id="total_cigar_list_${row.id}">${row.total}</span>`
            }
        },
        { defaultContent:   `<button type='button' name='btn_add_cigar' class='btn btn-info'>
                                Agregar
                               <i class="fas fa-plus"></i>
                            </button>`
        },
        { defaultContent: `<button type='button' name='btn_details_cigar' class='btn btn-info'>
                        Detalles
                        <i class="fas fa-search"></i>
                    </button>`
        },
        { defaultContent:   `<button type='button' name='btn_sale_cigar' class='btn btn-info'>
                Venta
                <i class="fas fa-cash-register"></i>
            </button>`
        },              
	],
});

/*Constante para rellenar las filas de la tabla: lista de usuarios*/
const tablaEggs = $('#listEggs').DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [0] ,
        },
        {
            className: "text-center", "targets": [1] ,
        },
        {
            className: "text-center", "targets": [2] ,
        },
        {
            className: "text-center", "targets": [3] ,
        },
        {
            className: "text-center", "targets": [4] ,
        },
    ],
	columns: [
		{ data: "tipo" },
        { data: "cantidad" },
        { data: "formato" },
        { data: "precio" },
       
        { defaultContent: "total", "render": function (data, type, row){
                if(row.total == totalShow && (row.tipo == '')){
                    return `<span style="background-color:#FFFF00; color: black;">${row.total}</span>`
                }else{
                    return `<span>${row.total}</span>`
                }
            }
        }
    ]          
});

/*Constante para rellenar las filas de la tabla: lista de usuarios*/
const tablaCigars = $('#listCigar').DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
   /*  "columnDefs": [
        {
            className: "text-center", "targets": [0] ,
        },
        {
            className: "text-center", "targets": [1] ,
        },
        {
            className: "text-center", "targets": [2] ,
        },
        {
            className: "text-center", "targets": [3] ,
        },
        {
            className: "text-center", "targets": [4] ,
        },
    ], */
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "cantidad" },
        { data: "precio" },
        { defaultContent: "total", "render": function (data, type, row){
                if(row.cantidad == ""){
                    return `<span style="background-color:#FFFF00; color: black;">${row.total}</span>`
                }else{
                    return `<span>${row.total}</span>`
                }
            }
        }
    ]          
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

const tablaAddEggs = $('#listAddEggs').DataTable({
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
         { data: "Formato" }, 
        { data: "stock" }, 
        { defaultContent: "cantidad", "render": 
            function (data, type, row){
                if(row.cantidad){
                    return `<input type="number" min="0" value='${row.cantidad}' class="form-control" id="cantidad_egg__${row.id}" placeholder="Ingrese cantidad">`
                }else{
                    return `<input type="number" min="0" class="form-control" id="cantidad_egg_${row.id}" placeholder="Ingrese cantidad">`
                }
            }
        },
        { defaultContent: "total", "render": 
            function (data, type, row){
                if(row.total){
                    return `<input type="text" value="${row.total}" id="total_egg_${row.id}" disabled class="form-control">`
                }else{
                    return `<input type="text" value="$ 0" id="total_egg_${row.id}" disabled class="form-control">`
                }
            }
        },
	],
});


/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$('#listRouteEggs').on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    totalShow = data.total;
    let eggs = [];
    let row = {tipo : '', cantidad : '',formato : '',precio : '',total : data.total};
    eggs.push(row);
    tablaEggs.rows.add(eggs);
    if ($(this)[0].name == "btn_details") {
        detalle.forEach((client)=>{
            if(client.id == data.id){
                client['Huevos'].forEach((egg)=>{
                    if(egg.cantidad != 0){
                        row = 
                        {
                            tipo : egg.name,
                            cantidad : egg.cantidad,
                            formato : egg.formato,
                            precio : egg.precioventa,
                            total : totalFormat(egg.total),
                        };
                        eggs.push(row);
                    }
                });
                tablaEggs.clear();
                tablaEggs.rows.add(eggs);
                tablaEggs.order( [ 1, 'desc' ] ).draw();
                $("#title").text("Detalle de venta cliente: "+data.nombre);
                $("#modal_eggs").modal("show");
            }
        });
    }else if ($(this)[0].name == "btn_sale") {
        $("#total_venta_egg").val(data.total);
        debts.forEach((client)=>{
            if(client.idClient == data.id){
                $("#deuda_egg").val(totalFormat(client.deuda));
            }
        });
        $("#modal_venta_huevos").modal("show");
    }else if ($(this)[0].name == "btn_add_egg") {
        idEditClientEgg = data.id;
        getEggs(idEditClientEgg);
        $("#modal_add_eggs").modal("show");
    }
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$('#listRouteCigars').on("click", "button", function () {
    let data = tablaClientCigar.row($(this).parents("tr")).data();
    console.log(data);
    let cigars = [];
    let a = $("#total_cigar_list_"+data.id).text();
    let row = {id : '', nombre: '', cantidad: '', precio : '',total : a};
    cigars.push(row);
    tablaCigars.rows.add(cigars);

    if ($(this)[0].name == "btn_details_cigar") {
        console.log(detalleCigars);
        detalleCigars.forEach((client)=>{
            if(client.idClient == data.id){
                client['data'].forEach((cigar)=>{
                    console.log(cigar);
                    if(cigar.cantidad != ''){
                        row = 
                        {
                            id : cigar.id,
                            nombre : cigar.nombre,
                            cantidad : cigar.cantidad,
                            precio : cigar.precio,
                            total : cigar.total,
                        };
                        cigars.push(row);
                    }
                });
                tablaCigars.clear();
                tablaCigars.rows.add(cigars);
                tablaCigars.order( [ 1, 'desc' ] ).draw();
                $("#title").text("Detalle de venta cliente: "+data.nombre);
                $("#modal_cigars").modal("show");
            }
        });
    }else if ($(this)[0].name == "btn_sale_cigar") {
        $("#total_venta_cigar").val(a);
        $("#modal_venta_cigarros").modal("show");
    }else if ($(this)[0].name == "btn_add_cigar") {
        idEditClientCigar = data.id;
        getCigars();
        $("#modal_add_cigars").modal("show");
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

    detalleCigars.forEach((details)=>{
        if(details.idClient == idEditClientCigar){
            details.data = aux;
        };
    });
    console.log(detalleCigars);
}


/*funcion para traer la lista de los cigarros y cargarla en la tabla*/
getCigars = () => {
    $.ajax({
        type: "GET",
        url: "api/routes/getCigars",
        crossOrigin: false,
        dataType: "json",
        success: (result) => {
            cigarsList = result;
            tablaCigarros.clear();
            if(stockCigarros.length == 0){
                let resultAux = [];
                console.log(result);
                result.forEach((item)=>{
                    let stockAux = 0;
                    stockCigarrosReserva.forEach((reserve)=>{
                        if(reserve.id == item.id){
                            stockAux = reserve.stock;
                        }
                    });

                    row = 
                    {
                        id: item.id,
                        stock : item.stock - stockAux,
                    }
                    stockCigarros.push(row);
                    if(cigars.length > 0){
                        op = 0;
                        data = [];
                       
                        cigars.forEach((res)=>{
                            if(res.idClient == idEditClientCigar){
                                op = 1;
                                data = res.data;   
                            }
                        });

                        console.log(data);       
                        if(op == 1){
                            data.forEach((data)=>{

                                if(data.id == item.id){
                                    row = 
                                    {
                                        id: data.id,
                                        nombre : data.nombre,
                                        precio: data.precio,
                                        stock: data.stock - stockAux,
                                        cantidad: data.cantidad,
                                        total: data.total,
                                    }
                                    resultAux.push(row);
                                }
                            });  
                        }else{
                            cigar =
                            {
                                id: item.id,
                                nombre: item.nombre,
                                precio: item.precio,
                                stock: item.stock - stockAux,
                            }
                            resultAux.push(cigar);
                        }
                        
                    }else{
                        cigar =
                            {
                                id: item.id,
                                nombre: item.nombre,
                                precio: item.precio,
                                stock: item.stock - stockAux,
                            }
                        resultAux.push(cigar);
                    }
                });
                console.log(stockCigarros);
                tablaCigarros.rows.add(resultAux);
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

/*funcion para traer la lista de los cigarros y cargarla en la tabla*/
getEggs = (idEditClientEgg) => {
    let data = {
        id: idEditClientEgg,
    };
    $.ajax({
        type: "POST",
        url: "api/routes/getEggs",
        crossOrigin: false,
        dataType: "json",
        data: { data },
        success: (result) => {
            console.log(result);
            eggsList = result;
            tablaAddEggs.clear();
            if(stockEggs.length == 0){
                let resultAux = [];
                console.log(result);
                result.forEach((item)=>{
                    let stockAux = 0;
                    stockEggsReserva.forEach((reserve)=>{
                        if(reserve.id == item.id){
                            stockAux = reserve.stock;
                        }
                    });

                    row = 
                    {
                        id: item.id,
                        stock : item.stock - stockAux,
                    }
                    stockEggs.push(row);
                    if(cigars.length > 0){
                        op = 0;
                        data = [];
                       
                        eggs.forEach((res)=>{
                            if(res.idClient == idEditClientEgg){
                                op = 1;
                                data = res.data;   
                            }
                        });

                        console.log(data);       
                        if(op == 1){
                            data.forEach((data)=>{

                                if(data.id == item.id){
                                    row = 
                                    {
                                        id: data.id,
                                        nombre : data.nombre,
                                        precio: data.precio,
                                        formato: data.formato,
                                        stock: data.stock - stockAux,
                                        cantidad: data.cantidad,
                                        total: data.total,
                                    }
                                    resultAux.push(row);
                                }
                            });  
                        }else{
                            egg =
                            {
                                id: item.id,
                                nombre: item.nombre,
                                precio: item.precio,
                                stock: item.stock - stockAux,
                            }
                            resultAux.push(egg);
                        }
                        
                    }else{
                        egg =
                            {
                                id: item.id,
                                nombre: item.nombre,
                                precio: item.precio,
                                stock: item.stock - stockAux,
                            }
                        resultAux.push(egg);
                    }
                });
                console.log(stockEggs);
                tablaAddEggs.rows.add(resultAux);
                tablaAddEggs.draw();
            }else{
                op = 0;
                data = [];
                eggs.forEach((item)=>{
                    if(idEditClientEgg== item.idClient){
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
                        stockEggs.forEach((stock)=>{
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
                    tablaAddEggs.rows.add(aux1);
                    tablaAddEggs.draw();
                }else{
                    let aux2 = [];
                    stockAcc = 0;
                    result.forEach((item)=>{
                        stockEggs.forEach((stock)=>{
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
                    tablaAddEggs.rows.add(aux2);
                    tablaAddEggs.draw();
                }
                console.log(eggs);
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
                total = parseInt(total) + parseInt(dataTotal.total);
            });
        }
    });
    console.log(stockCigarros);
    console.log(total);
    console.log(idEditClientCigar);
    $('#total_cigar_list_'+idEditClientCigar).text(totalFormat(total));
    $('#modal_add_cigars').modal('hide');
    console.log(cigars);
    console.log(aux);
}

$("#btn_add_cigar").on("click", addCigar);

/* Función que devuelve el total de la compra de un cliente en formato CLP*/
totalFormat = (total) => {
    const formatterPeso = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
      })
    return formatterPeso.format(total);
}

/* Función para cerrar modal seteando en null las variables dinamicas*/
close_modal_eggs = () =>{
    $("#total_venta_egg").val();
    $("#id_venta").val('');
    $("#deuda_egg").val('');
    $("#abono_egg").val('');
    $("#contado_egg").val('');
    $("#credito_egg").val('');
    $("#date_admission").val('');
    $('#modal_venta_huevos').modal('hide');
}

/* Función para cerrar modal seteando en null las variables dinamicas*/
close_modal_cigars = () =>{
    $("#id_venta_cigar").val('');
    $("#deuda_cigar").val('');
    $("#abono_cigar").val('');
    $("#contado_cigar").val('');
    $("#credito_cigar").val('');
    $("#date_admission_cigar").val('');
    $('#modal_venta_cigarros').modal('hide');
}

/* Función para cerrar modal seteando en null las variables dinamicas*/
close_modal_add_cigar = () =>{
    idEditClientCigar = '';
    tablaCigarros.clear();
    eggs = []; 
    $('#modal_add_cigars').modal('hide');
}

/* Función para cerrar modal seteando en null las variables dinamicas*/
close_modal_add_eggs = () =>{
    idEditClientEgg = '';
    tablaAddEggs.clear();
    eggs = []; 
    $('#modal_add_eggs').modal('hide');
}