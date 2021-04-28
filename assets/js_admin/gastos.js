$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
   
	
    get_gastos();
});


// $("#idGastoGeneral").change(() => { 
// 	let idGastoGeneral = $("#idGastoGeneral").val();
// 	if(idGastoGeneral){
// 		$("#frm_idGastoGeneral > input").removeClass("is-invalid");
// 	}else{
// 		$("#frm_idGastoGeneral > input").addClass("is-invalid");
// 	}
// });

$("#nomGastoGeneral").change(() => { 
	let nomGastoGeneral = $("#nomGastoGeneral").val();
	if(nomGastoGeneral){
		$("#frm_nomGastoGeneral > input").removeClass("is-invalid");
	}else{
		$("#frm_nomGastoGeneral > input").addClass("is-invalid");
	}
});

$("#costoMonetarioGeneral").change(() =>{ 
	let costoMonetarioGeneral = $("#costoMonetarioGeneral").val();
	if(costoMonetarioGeneral){
		$("#frm_costoMonetarioGeneral > input").removeClass("is-invalid");
	}else{
		$("#frm_costoMonetarioGeneral > input").addClass("is-invalid");
	}
});






let edit = false; /*Variable para determinar si se editara o creara*/
let nomGastoGeneralEdit ='';
let idGastoEdit = '' ; /*Variable que almacenara el id para editar*/



get_gastos = () => {
    
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_gastos`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
            let data = xhr.response;
			// 	if (g.state == 1) {
			// 		g.state = "Activo";
			// 	} else {
			// 		g.state = "Bloqueado";
			// 	}
			// 	return c;
            // });
            // if(roles.length == 0){
            //     let rol = xhr.response[1].map((u) => {
            //         let option = document.createElement("option"); 
            //         $(option).val(u.id); 
            //         $(option).attr('name', u.description);
            //         $(option).html(u.description); 
            //         $(option).appendTo("#range");
            //         roles.push(u.description);
            //     });
            // }
			tablaGastos.clear();
			tablaGastos.rows.add(data);
			tablaGastos.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los gastos",
			});
		}
	});
	xhr.send();
};


/*Constante para rellenar las filas de la tabla: lista de Gastos*/
const tablaGastos = $('#list_gastos').DataTable({
	searching: true,
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
    ],
	columns: [
		{ data: "idGastoGeneral" },
        { data: "nomGastoGeneral" },
        { "render": function (data, type, row){     
			return totalFormat(row.costoMonetarioGeneral)
	   	}},
		{
            defaultContent: `<button type='button' name='btn_update' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
        {
			defaultContent: `<button type='button' name='btn_des_hab' class='btn btn-danger'>
                                Eliminar
                                <i class="fas fa-times"></i>
                            </button>`,                    
		},
		
	],
});

/*Función para setear modal crear usuario*/
$("#btn").click(() => { 
    edit = false;
    idGastoEdit = "";
    nomGastoGeneralEdit="";

    $("#btn_ok").text("Crear Gasto");
    $("#titulo").text("Crear Gasto");
    $("#modal_gastos").modal("show");
    
});

/*Función para crear o editar usuario*/
$('#btn_ok').click(() => { 
    create_edit_gastos();  
    
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$("#list_gastos").on("click", "button", function () {
    let data = tablaGastos.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_des_hab") {
        show_info_des_hab_gastos(data.idGastoGeneral);
    } else {
        show_info_update_gastos(data);
    }
});







/*Funcion para crear y editar un usuario */

create_edit_gastos = () =>{
    //Discriminar si se debe crear o editar
   
    let url = "";
    let data = "";
	
    let nomGastoGeneral = $("#nomGastoGeneral").val();
    let costoMonetarioGeneral = $("#costoMonetarioGeneral").val();
    
    
    if(edit){
     url = "api/update_gastos";
     data = {idGastoGeneral:idGastoEdit,nomGastoGeneral: nomGastoGeneral, costoMonetarioGeneral: costoMonetarioGeneral,nomGastoGeneral_old:nomGastoGeneralEdit};
    }else{
     url = "api/create_gastos";
     data = { nomGastoGeneral: nomGastoGeneral, costoMonetarioGeneral: costoMonetarioGeneral};
    } 

    $.ajax({
        type: "POST",
        url: host_url + url,
        data: {data},
        dataType: "json",
        success: (result) => {
         swal({
             title: "Éxito!",
             icon: "success",
             text: result.msg,
             button: "OK",
         }).then(() => {
             edit = false;
             nomGastoGeneralEdit = "";
        
            
             close_modal_gastos();
             tablaGastos.rows().remove().draw();
             get_gastos();
         });
        }, 
        statusCode: {
         400: (xhr) => {
             let msg = xhr.responseJSON;
             swal({
                 title: "Error",
                 icon: "error",
                 text: addErrorStyle(msg),
             }).then(() => {
				// if(msg.idGastoGeneral){$("#frm_idGastoGeneral > div").html(msg.idGastoGeneral); $("#frm_idGastoGeneral > input").addClass("is-invalid");}
                if(msg.nomGastoGeneral){$("#frm_nomGastoGeneral > div").html(msg.nomGastoGeneral); $("#frm_nomGastoGeneral > input").addClass("is-invalid");}
                if(msg.costoMonetarioGeneral){$("#frm_costoMonetarioGeneral > div").html(msg.costoMonetarioGeneral); $("#frm_costoMonetarioGeneral > input").addClass("is-invalid");}
               
                
             });
         },
         405: (xhr) =>{
            let msg = xhr.responseJSON;
            swal({
                title: "Error",
                icon: "error",
                text: addErrorStyle(msg),
            });
        },
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
/*Función para des/habilitar una empresa */
des_hab_gastos= (idGastoGeneral) => {
    
    let data = {
        idGastoGeneral: idGastoGeneral,
		
    };
    $.ajax({
        type: "POST",
        url: host_url + "api/des_hab_gastos",
        data: {data},
        crossOrigin: false,
        dataType: "json",
        success: (result) => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: result.msg,
				button: "OK",
			}).then(() => {
				tablaGastos.rows().remove().draw();
				get_gastos();
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

// /*Función para preparar la información a editar*/
show_info_update_gastos = (data) =>{
    console.log(data);
    edit = true;
    nomGastoGeneralEdit = data.nomGastoGeneral;
    idGastoEdit = data.idGastoGeneral;
    $("#idGastoGeneral").val(data.idGastoGeneral);
    $("#nomGastoGeneral").val(data.nomGastoGeneral);
    $("#costoMonetarioGeneral").val(data.costoMonetarioGeneral);
    


    
   
    $("#titulo").text("Editar Gastos");
    $("#btn_ok").text("Guardar Cambios");
    $("#modal_gastos").modal("show");
}

show_info_des_hab_gastos = (data) =>{
   
    let msg_text =""
    let title =""
    if(data != null ) {msg_text="¿Está seguro/a de eliminar el gasto:"; title="Eliminar"}
   
    swal({
        title: `${title} gastos`,
        icon: "warning",
        text: `${msg_text} ${data}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "hab_des_gastos",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "hab_des_gastos") {
            des_hab_gastos(data);
        } else {
            swal.close();
        }
    });
}

/*Función para manejo de errores*/
addErrorStyle = errores => {
	let arrayErrores = Object.keys(errores);
	let cadena_error = "";
	let size = arrayErrores.length;
	let cont = 1;
	arrayErrores.map(err => {
		if(size!= cont){
			cadena_error += errores[`${err}`] +'\n'+'\n';
		}else{
			cadena_error += errores[`${err}`];
		}
		cont++;
	});
	return cadena_error;
};



/*Función para cerrar y limpiar el modal utilizado para crear y editar usuario*/
close_modal_gastos = () =>{
    $("#nomGastoGeneral").val("");
    $("#costoMonetarioGeneral").val("");
    
    
    $("#frm_nomGastoGeneral > input").removeClass("is-invalid");
    $("#frm_costoMonetarioGeneral > input").removeClass("is-invalid");
   
    $('#modal_gastos').modal('hide');
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
