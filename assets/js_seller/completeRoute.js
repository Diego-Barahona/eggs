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
            detalle = JSON.parse(xhr[1]['detalle']);
            detalle.forEach((item)=>{
                if(item.total != 0){
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
                }
            });

            tabla.clear();
			tabla.rows.add(clients);
			tabla.draw();

            detalleCigars = JSON.parse(xhr[1]['detalle_cigarros']);      
            detalleCigars.forEach((item)=>{
                console.log(item.total);
                if(item.total != '$ 0'){
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
    ],
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "sector" },
        { data: "direccion" },
        { data: "total" },
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
    ],
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "sector" },
        { data: "direccion" },
        { data: "total" },
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
    }
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$('#listRouteCigars').on("click", "button", function () {
    let data = tablaClientCigar.row($(this).parents("tr")).data();
    let cigars = [];
    let row = {id : '', nombre: '', cantidad: '', precio : '',total : data.total};
    cigars.push(row);
    tablaCigars.rows.add(cigars);

    if ($(this)[0].name == "btn_details_cigar") {
        detalleCigars.forEach((client)=>{
            if(client.idClient == data.id){
                client['data'].forEach((cigar)=>{
                    console.log(cigar);
                    if(cigar.cantidad != '$ 0'){
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
        $("#total_venta_cigar").val(data.total);
        $("#modal_venta_cigarros").modal("show");
    }
});

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
    $("#date_admission_cigar").val('');
    $('#modal_venta_cigarros').modal('hide');
}