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
    getCigars();
});

$("#name").change(() =>{ 
	let name = $("#name").val();
	if(name){
		$("#frmName > input").removeClass("is-invalid");
	}else{
		$("#frmName > input").addClass("is-invalid");
	}
});

$("#price").change(() =>{ 
	let price = $("#price").val();
	if(price){
		$("#frmPrice > input").removeClass("is-invalid");
	}else{
		$("#frmPrice > input").addClass("is-invalid");
	}
});

$("#stock").change(() =>{ 
	let stock = $("#stock").val();
	if(stock){
		$("#frmStock > input").removeClass("is-invalid");
	}else{
		$("#frmStock > input").addClass("is-invalid");
	}
});

let edit = false; /*Variable para determinar si se editara o creara*/
let nameEdit = ''; /*Variable que almacenara el nombre que se ditará*/
let idEdit = '';

/*Funcion para recuperar los cigarros*/
getCigars = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getCigars`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            console.log(xhr.response);
            let data = xhr.response.map((u) => {
				if (u.state == 1) {
					u.state = "Activo";
				} else {
					u.state = "Bloqueado";
				}
				return u;
            });
			tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener la lista de cigarros",
			});
		}
	});
	xhr.send();
};

/*Función para setear modal crear cigarro*/
$("#btn").click(() => { 
    edit = false;
    nameEdit = "";
    idEdit = "";
    $("#btnOk").text("Crear cigarro");
    $("#titulo").text("Crear cigarro");
    $("#modalCigar").modal("show");
});

/*Función para crear o editar cigarro*/
$('#btnOk').click(() => { 
    createEditCigar();  
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$("#listCigar").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btnDesHab") {
        showInfoDesHabCigar(data);
    } else if ($(this)[0].name == "btnUpdate") {
        showInfoUpdateCigar(data);
    }
});

/*Funcion para crear y editar un cigarro */
createEditCigar = () =>{
    //Discriminar si se debe crear o editar
    let url = "";
    let data = "";
    let name = $("#name").val();
    let price = $("#price").val();
    let stock = $("#stock").val();
    let state = ($("#state").val() == "Activo" ? 1 : 0);
    if(edit){
     url = "api/updateCigar";
     data = {id:idEdit, name: name, price: price, stock:stock, nameOld: nameEdit, state:state};
    }else{
     url = "api/createCigar";
     data = {name: name, price: price, stock:stock, state: 1};
    } 
    console.log(data);

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
             nameEdit = '';
             idEdit = '';
             closeModalCigar();
             tabla.rows().remove().draw();
             getCigars();
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
                if(msg.name){$("#frmName > div").html(msg.name); $("#frmName > input").addClass("is-invalid");}
                if(msg.price){$("#frmPrice > div").html(msg.price); $("#frmPrice > input").addClass("is-invalid");}
                if(msg.stock){$("#frmStock > div").html(msg.stock); $("#frmStock > input").addClass("is-invalid");}
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

  /*Función para des/habilitar un cigarro */
desHabCigar = (id, state) => {
    let state_change = (state == 0 ? 1 : 0);
    let data = {
        id: id,
		state: state_change,
    };
console.log(data);
    $.ajax({
        type: "POST",
        url: host_url + "api/desHabCigar",
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
				tabla.rows().remove().draw();
				getCigars();
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

/*Constante para rellenar las filas de la tabla: lista de cigarros*/
const tabla = $('#listCigar').DataTable({
	// searching: true,
    "columnDefs": [
        {
            className: "text-center", "targets": [2] ,
        },
        {
            className: "text-center", "targets": [3] ,
        },
        {
            className: "text-center", "targets": [4] ,
        },
        {
            className: "text-center", "targets": [5] ,
        },
        {
            className: "text-center", "targets": [6] ,
        },
        {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false,
        },
    ],
    language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "id" },
		{ data: "name" },
        { data: "price" },
        { data: "stock" },
        { data: "state" },
		{
            defaultContent: `<button type='button' name='btnUpdate' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
		{
			defaultContent: `<button type='button' name='btnDesHab' class='btn btn-danger'>
                                Bloquear/Desbloquear
                                <i class="fas fa-times"></i>
                            </button>`,                    
		},
	],
});

/*Función para preparar la información a editar*/
showInfoUpdateCigar = (data) =>{
    edit = true;
    nameEdit = data.name;
    idEdit = data.id;
    $("#name").val(data.name);
    $("#price").val(data.price);
    $("#stock").val(data.stock);
    $("#state").val(data.state);
    $("#titulo").text("Editar Cigarro");
    $("#btnOk").text("Guardar Cambios");
    $("#frmState").show();
    $("#modalCigar").modal("show");
}

/*Función para preparar la información a des/habilitar*/
showInfoDesHabCigar = (data) =>{
    let state = (data.state == "Activo" ? 1 : 0);
    let msg_text =""
    let title =""
    if(data.state == 'Activo') {state = 1; msg_text="¿Está seguro/a de deshabilitar al cigarro:"; title="Deshabilitar"}
    else {state = 0; msg_text="¿Está seguro/a de habilitar al cigarro:"; title="Habilitar";};

    swal({
        title: `${title} cigarro`,
        icon: "warning",
        text: `${msg_text} ${data.name}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "desHabCigar",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "desHabCigar") {
            desHabCigar(data.id, state);
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

/*Función para cerrar y limpiar el modal utilizado para crear y editar cigarro*/
closeModalCigar = () =>{
    $("#name").val("");
    $("#price").val("");
    $("#stock").val("");
    $("#frmState").hide();
    $("#frmName > input").removeClass("is-invalid");
    $("#frmPrice > input").removeClass("is-invalid");
    $("#frmStock > input").removeClass("is-invalid");
    $('#modalCigar').modal('hide');
}

