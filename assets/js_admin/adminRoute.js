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
	xhr.open("get", `${host_url}/api/routes/getRoutes`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            console.log(data);
			tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
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
            className: "text-center", "targets": [3] ,
        },
        {
            className: "text-center", "targets": [4] ,
        },
        {
            className: "text-center", "targets": [5] ,
        }
    ],
	columns: [
		{ data: "id" },
        { data: "fecha" },
        { data: "vendedor" },
        {
            defaultContent: `<button type='button' name='btn_details' class='btn btn-info'>
                                  Detalles
                                  <i class="fas fa-search"></i>
                              </button>`,
		},
		{
            defaultContent: `<button type='button' name='btn_update' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
        { defaultContent: "oc",
		   "render": function (data, type, row){
			if(row.estado == 0){
				return `<button type='button' name='btn_delete' class='btn btn-danger'>
                Eliminar
                <i class="fas fa-trash"></i>
                </button>`
			}else{
				return `<button type='button' name='' class='btn btn-warning'>
				En proceso
				<i class="fas fa-edit"></i>
				</button>`
			}
		   }
		},
	],
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$("#listRoutes").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_details") {
		let url = 'adminDetailsRoute'+'?id='+data.id;
		window.location.assign(host_url+url);
    } else if ($(this)[0].name == "btn_update") {
		let url = 'adminUpdateRoute'+'?id='+data.id;
		window.location.assign(host_url+url);
    }
    else if ($(this)[0].name == "btn_delete") {
		show_info_delete(data);
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
