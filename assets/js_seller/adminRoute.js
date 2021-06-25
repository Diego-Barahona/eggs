/*Proceso para cargar el loading cuando se ejecuta una función ajax*/
$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getRoutes();
});


/*Funcion para recuperar los rutas*/
getRoutes = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/routes/getRoutesBySeller`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            console.log(data);
			tabla.clear();
			tabla.rows.add(data);
			tabla.order( [ 1, 'desc' ] ).draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener la información de las rutas",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de rutas*/
const tabla = $('#listRoutes').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [

        {
            className: "text-center", "targets": [1] ,
        },
        {
            className: "text-center", "targets": [2] ,
        },
        {
            className: "text-center", "targets": [3] ,
        }
    ],
	columns: [
		{ data: "id" },
        { data: "fecha" },
        { data: "vendedor" },
        { defaultContent: "oc",
		   "render": function (data, type, row){

			let f = new Date();
			let mes = (f.getMonth()+1).toString();
			
			if(mes.length == 1) mes = '0'+mes;
			
			let fecha = f.getFullYear()+ "-"+ mes + "-"+ f.getDate();	

			if(fecha == row.fecha){
				return `<button type='button' name='btn_complete' class='btn btn-warning'>
				Completar
				<i class="fas fa-edit"></i>
				</button>`
			}else{
				return `<button type='button' name='btn_details' class='btn btn-info'>
				Detalles
				<i class="fas fa-search"></i>
				</button>`
			}
		   }
		},
	],
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$("#listRoutes").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_complete") {
		let url = 'adminCompleteRoute'+'?id='+data.id;
		window.location.assign(host_url+url);
    } else if ($(this)[0].name == "btn_details") {
		
    }
});


/*Función para preparar la información a des/habilitar*/
show_info_delete= (data) =>{
    swal({
        title: `Eliminar ruta`,
        icon: "warning",
        text: `Esta realmente segur@ de eliminar la ruta: ${data.id}"?`,
		dangerMode: true,
		buttons: true,
        buttons: {
            confirm: {
                text: "Eliminar",
                value: "delete",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "delete") {
            remove(data.id);
        } else {
            swal.close();
        }
    });
}

/*Función para des/habilitar una empresa */
remove = (id) => {
    $.ajax({
        type: "GET",
        url: host_url + "api/routes/deleteRoute"+"?id="+id,
        dataType: "json",
        success: (result) => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: result.msg,
				button: "OK",
			}).then(() => {
				tabla.rows().remove().draw();
				getRoutes();
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

$("#btnCreateRoute").click(() => { 
    window.location.assign(host_url+"adminCreateRoute");
});
