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
    $("#rutCliente").rut({
		minimumLength: 8,
		validateOn: "change",
	});
    get_clientes();
});

/*Falta validar el rut*/
$("#rutCliente").change(() =>{ 
	let rutCliente = $("#rutCliente").val();
	if(rutCliente){
		$("#frm_rutCliente > input").removeClass("is-invalid");
	}else{
		$("#frm_rutCliente > input").addClass("is-invalid");
	}
});

$("#nomCliente").change(() => { 
	let nomCliente = $("#nomCliente").val();
	if(nomCliente){
		$("#frm_nomCliente > input").removeClass("is-invalid");
	}else{
		$("#frm_nomCliente > input").addClass("is-invalid");
	}
});

$("#sector").change(() =>{ 
	let sector = $("#sector").val();
	if(sector){
		$("#frm_sector > input").removeClass("is-invalid");
	}else{
		$("#frm_sector > input").addClass("is-invalid");
	}
});



$("#nombreCalle").change(() =>{ 
	let nombreCalle = $("#nombreCalle").val();
	if(nombreCalle){
		$("#frm_nombreCalle > input").removeClass("is-invalid");
	}else{
		$("#frm_nombreCalle > input").addClass("is-invalid");
	}
});

$("#numCalle").change(() => { 
	let numCalle = $("#numCalle").val();
	if(numCalle){
		$("#frm_numCalle > select").removeClass("is-invalid");
	}else{
		$("#frm_numCalle > select").addClass("is-invalid");
	}
});

let edit = false; /*Variable para determinar si se editara o creara*/
let rutClienteEdit = ""; /*Variable que almacenara el id para editar*/
// let emailEdit = ""; /*Variable que almacenara el nombre para editar*/
// let roles = []; /*Variable que almacenara los roles*/



get_clientes = () => {
    
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_clientes`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
            let data = xhr.response.map((c) => {
				if (c.state == 1) {
					c.state = "Activo";
				} else {
					c.state = "Bloqueado";
				}
				return c;
            });
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
			tablaCliente.clear();
			tablaCliente.rows.add(data);
			tablaCliente.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los clientes",
			});
		}
	});
	xhr.send();
};


/*Constante para rellenar las filas de la tabla: lista de clientes*/
const tablaCliente = $('#list_clientes').DataTable({
	searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "nomCliente" },
        { data: "rutCliente" },
        { data: "sector" },
        { data: "nombreCalle" },
        { data: "numCalle" },
		{ data: "state" },

		{
            defaultContent: `<button type='button' name='btn_update' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
		{
			defaultContent: `<button type='button' name='btn_des_hab' class='btn btn-danger'>
                                Bloquear/Desbloquear
                                <i class="fas fa-times"></i>
                            </button>`,                    
		},
	],
});

/*Función para setear modal crear usuario*/
$("#btn").click(() => { 
    edit = false;
    rutClienteEdit = "";
    $("#btn_ok").text("Crear Cliente");
    $("#titulo").text("Crear Cliente");
    $("#modal_cliente").modal("show");
    
});

/*Función para crear o editar usuario*/
$('#btn_ok').click(() => { 
    create_edit_clientes();  
    
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$("#list_clientes").on("click", "button", function () {
    let data = tablaCliente.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_des_hab") {
        show_info_des_hab_clientes(data);
    } else {
        show_info_update_clientes(data);
    }
});







/*Funcion para crear y editar un usuario */

create_edit_clientes = () =>{
    //Discriminar si se debe crear o editar
    let url = "";
    let data = "";
    let nomCliente = $("#nomCliente").val();
    let rutCliente = $("#rutCliente").val();
    let sector = $("#sector").val();
    let nombreCalle = $("#nombreCalle").val();
    let numCalle = $("#numCalle").val();
    let state = ($("#state").val() == "Activo" ? 1 : 0);
    if(edit){
     url = "api/update_clientes";
     data = {nomCliente: nomCliente, rutCliente: rutCliente, sector:sector, nombreCalle:nombreCalle,numCalle:numCalle, state: state, rut_old: rutClienteEdit};
    }else{
     url = "api/create_clientes";
     data = {nomCliente: nomCliente, rutCliente: rutCliente, sector:sector, nombreCalle:nombreCalle,numCalle:numCalle};
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
             rutClienteEdit = "";
        
            
             close_modal_cliente();
             tablaCliente.rows().remove().draw();
             get_clientes();
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
                if(msg.nomCliente){$("#frm_nomCliente > div").html(msg.nomCliente); $("#frm_nomCliente > input").addClass("is-invalid");}
                if(msg.rutCliente){$("#frm_rutCliente > div").html(msg.rutCliente); $("#frm_rutCliente > input").addClass("is-invalid");}
                if(msg.sector){$("#frm_sector > div").html(msg.sector); $("#frm_sector > input").addClass("is-invalid");}
                if(msg.nombreCalle){$("#frm_nombreCalle > div").html(msg.nombreCalle); $("#frm_nombreCalle > input").addClass("is-invalid");}
				if(msg.numCalle){$("#frm_numCalle > div").html(msg.numCalle); $("#frm_numCalle > input").addClass("is-invalid");}
                
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
des_hab_clientes= (rutCliente, state) => {
    let state_change = (state == 0 ? 1 : 0);
    let data = {
        rutCliente: rutCliente,
		state: state_change,
    };
    $.ajax({
        type: "POST",
        url: host_url + "api/des_hab_clientes",
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
				tablaCliente.rows().remove().draw();
				get_clientes();
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

/*Función para preparar la información a editar*/
show_info_update_clientes = (data) =>{
    edit = true;
    rutClienteEdit = data.rutCliente;
    
    $("#nomCliente").val(data.nomCliente);
    $("#rutCliente").val(data.rutCliente);
    $("#sector").val(data.sector);
    $("#nombreCalle").val(data.nombreCalle);
    $("#numCalle").val(data.numCalle);


    // let a = $(`option[name ="${data.description}"]`).val();
    // $("#range").val(a);
    $("#state").val(data.state);

    $("#frm_state").show();
   
    $("#titulo").text("Editar Cliente");
    $("#btn_ok").text("Guardar Cambios");
    $("#modal_cliente").modal("show");
}

/*Función para preparar la información a des/habilitar*/
show_info_des_hab_clientes = (data) =>{
    let state = (data.state == "Activo" ? 1 : 0);
    let msg_text =""
    let title =""
    if(data.state == 'Activo') {state = 1; msg_text="¿Está seguro/a de deshabilitar al cliente:"; title="Deshabilitar"}
    else {state = 0; msg_text="¿Está seguro/a de Habilitar al usuario:"; title="Habilitar";};

    swal({
        title: `${title} cliente`,
        icon: "warning",
        text: `${msg_text} ${data.nomCliente}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "hab_des_clientes",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "hab_des_clientes") {
            des_hab_clientes(data.rutCliente, state);
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
close_modal_cliente = () =>{
    $("#rutCliente").val("");
    $("#nomCliente").val("");
    $("#sector").val("");
    $("#nombreCalle").val("");
    $("#numCalle").val("");
    
    $("#frm_state").hide();
    $("#frm_rutCliente > input").removeClass("is-invalid");
    $("#frm_nomCliente > input").removeClass("is-invalid");
    $("#frm_sector > input").removeClass("is-invalid");
    $("#frm_nombreCalle > input").removeClass("is-invalid");
    $("#frm_numCalle> input").removeClass("is-invalid");
    $('#modal_cliente').modal('hide');
}