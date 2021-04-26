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
    $("#rutProveedor").rut({
		minimumLength: 8,
		validateOn: "change",
	});
    get_proveedor();
});

/*Falta validar el rut*/
$("#rutProveedor").change(() =>{ 
	let rutProveedor = $("#rutProveedor").val();
	if(rutProveedor){
		$("#frm_rutProveedor > input").removeClass("is-invalid");
	}else{
		$("#frm_rutProveedor > input").addClass("is-invalid");
	}
});

$("#nomProveedor").change(() => { 
	let nomProveedor = $("#nomProveedor").val();
	if(nomProveedor){
		$("#frm_nomProveedor > input").removeClass("is-invalid");
	}else{
		$("#frm_nomProveedor > input").addClass("is-invalid");
	}
});

$("#telefono").change(() =>{ 
	let telefono = $("#telefono").val();
	if(telefono){
		$("#frm_telefono > input").removeClass("is-invalid");
	}else{
		$("#frm_telefono > input").addClass("is-invalid");
	}
});



$("#correoProveedor").change(() =>{ 
	let correoProveedor = $("#correoProveedor").val();
	if(correoProveedor){
		$("#frm_correoProveedor > input").removeClass("is-invalid");
	}else{
		$("#frm_correoProveedor > input").addClass("is-invalid");
	}
});

$("#codProducto").change(() => { 
	let codProducto = $("#codProducto").val();
	if(codProducto){
		$("#frm_codProducto > select").removeClass("is-invalid");
	}else{
		$("#frm_codProducto > select").addClass("is-invalid");
	}
});

let edit = false; /*Variable para determinar si se editara o creara*/
let rutProveedorEdit = ""; /*Variable que almacenara el id para editar*/
// let emailEdit = ""; /*Variable que almacenara el nombre para editar*/
// let roles = []; /*Variable que almacenara los roles*/



get_proveedor = () => {
    
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_proveedor`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
            let data = xhr.response.map((c) => {
				if (c.state == 1) {c.state = "Activo";
				} else {c.state = "Bloqueado";
				} if (c.codProducto ==1){c.codProducto="Huevos"; 
                }else {c.codProducto ="Cigarros";}
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
            
			tablaProveedor.clear();
			tablaProveedor.rows.add(data);
			tablaProveedor.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los proveedores",
			});
		}
	});
	xhr.send();
};


/*Constante para rellenar las filas de la tabla: lista de clientes*/
const tablaProveedor = $('#list_proveedor').DataTable({
	searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{data:"id"},
        { data: "nomProveedor" },
        { data: "rutProveedor" },
        { data: "telefono" },
        { data: "correoProveedor" },
        { data: "codProducto" },
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
    rutProveedorEdit = "";
    $("#btn_ok").text("Crear Proveedor");
    $("#titulo").text("Crear Proveedor");
    $("#modal_proveedor").modal("show");
    
});

/*Función para crear o editar usuario*/
$('#btn_ok').click(() => { 
    create_edit_proveedor();  
    
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$("#list_proveedor").on("click", "button", function () {
    let data = tablaProveedor.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_des_hab") {
        show_info_des_hab_proveedor(data);
    } else {
        show_info_update_proveedor(data);
    }
});







/*Funcion para crear y editar un usuario */

create_edit_proveedor = () =>{
    //Discriminar si se debe crear o editar
    let url = "";
    let data = "";
    let nomProveedor = $("#nomProveedor").val();
    let rutProveedor = $("#rutProveedor").val();
    let telefono = $("#telefono").val();
    let correoProveedor = $("#correoProveedor").val();
    let codProducto = ($("#codProducto").val()== "Huevo" ?1: 0);
    let state = ($("#state").val() == "Activo" ? 1 : 0);
    if(edit){
     url = "api/update_proveedor";
     data = {nomProveedor: nomProveedor, rutProveedor: rutProveedor, telefono:telefono, correoProveedor:correoProveedor,codProducto:codProducto, state: state, rutProveedor_old: rutProveedorEdit};
    }else{
     url = "api/create_proveedor";
     data = {nomProveedor: nomProveedor, rutProveedor: rutProveedor, telefono:telefono, correoProveedor:correoProveedor,codProducto:codProducto};
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
             rutProveedorEdit = "";
        
            
             close_modal_proveedor();
             tablaProveedor.rows().remove().draw();
             get_proveedor();
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
                if(msg.nomProveedor){$("#frm_nomProveedor > div").html(msg.nomProveedor); $("#frm_nomProveedor > input").addClass("is-invalid");}
                if(msg.rutProveedor){$("#frm_rutProveedor > div").html(msg.rutProveedor); $("#frm_rutProveedor > input").addClass("is-invalid");}
                if(msg.telefono){$("#frm_telefono > div").html(msg.telefono); $("#frm_telefono > input").addClass("is-invalid");}
                if(msg.correoProveedor){$("#frm_correoProveedor > div").html(msg.correoProveedor); $("#frm_correoProveedor > input").addClass("is-invalid");}
				if(msg.codProducto){$("#frm_codProducto > div").html(msg.codProducto); $("#frm_codProducto > input").addClass("is-invalid");}
                
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
des_hab_proveedor= (rutProveedor, state) => {
    let state_change = (state == 0 ? 1 : 0);
    let data = {
        rutProveedor: rutProveedor,
		state: state_change,
    };
    $.ajax({
        type: "POST",
        url: host_url + "api/des_hab_proveedor",
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
				tablaProveedor.rows().remove().draw();
				get_proveedor();
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
show_info_update_proveedor = (data) =>{
    edit = true;
    rutProveedorEdit = data.rutProveedor;
    
    $("#nomProveedor").val(data.nomProveedor);
    $("#rutProveedor").val(data.rutProveedor);
    $("#telefono").val(data.telefono);
    $("#correoProveedor").val(data.correoProveedor);
    $("#codProducto").val(data.codProducto);


    let a = $(`option[name ="${data.description}"]`).val();
    $("#range").val(a);
    $("#state").val(data.state);

    $("#frm_state").show();
   
    $("#titulo").text("Editar Proveedor");
    $("#btn_ok").text("Guardar Cambios");
    $("#modal_proveedor").modal("show");
}

/*Función para preparar la información a des/habilitar*/
show_info_des_hab_proveedor = (data) =>{
    let state = (data.state == "Activo" ? 1 : 0);
    let msg_text =""
    let title =""
    if(data.state == 'Activo') {state = 1; msg_text="¿Está seguro/a de deshabilitar al proveedor:"; title="Deshabilitar"}
    else {state = 0; msg_text="¿Está seguro/a de Habilitar al proveedor:"; title="Habilitar";};

    swal({
        title: `${title} proveedor`,
        icon: "warning",
        text: `${msg_text} ${data.nomProveedor}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "hab_des_proveedor",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "hab_des_proveedor") {
            des_hab_proveedor(data.rutProveedor, state);
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
close_modal_proveedor = () =>{
    $("#rutProveedor").val("");
    $("#nomProveedor").val("");
    $("#telefono").val("");
    $("#correoProveedor").val("");
    $("#codProducto").val("");
    
    $("#frm_state").hide();
    $("#frm_rutProveedor > input").removeClass("is-invalid");
    $("#frm_nomProveedor > input").removeClass("is-invalid");
    $("#frm_telefono > input").removeClass("is-invalid");
    $("#frm_correoProveedor > input").removeClass("is-invalid");
    $("#frm_codProducto> input").removeClass("is-invalid");
    $('#modal_proveedor').modal('hide');
}