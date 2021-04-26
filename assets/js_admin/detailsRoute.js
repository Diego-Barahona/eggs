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
detalle = '';
totalShow = '';

/* Función que cargara en mis variables globales toda la información necesaria para trabajar */
/* Incluye la definición de la Datatable*/
getDataForm = () => {
    id = $('#id').val();
    $.ajax({
        type: "GET",
        url: host_url + 'api/routes/getDataFormUpdate'+'?id='+id,
        dataType: "json",
        success: (xhr) => {
            /*Almacenar la información general de los clientes */
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
            });

            tabla.clear();
			tabla.rows.add(clients);
			tabla.draw();
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
    ],
	columns: [
		{ data: "id" },
        { data: "nombre" },
        { data: "sector" },
        { data: "direccion" },
        { data: "total" },
        { defaultContent: `<button type='button' name='btn_details' class='btn btn-info'>
                        Detalles
                        <i class="fas fa-search"></i>
                    </button>`},
                    
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
