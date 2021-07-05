$(() => {
	get_data();
	mesActual();
	stockCigar();
	stockEggs();
});

let fecha = "";
let utilidades;
mesActual = ()=>{
	const fecha = new Date();
	const mesActual = fecha.getMonth() + 1;
	const yearActual = fecha.getFullYear(); 
    let mes = convertirMes(mesActual);
	
	text =" Cómputo general ( "+mes+"-"+ yearActual+" )";
	$("#title_counter").text(text);

}

convertirMes = (valor )=>{ 

    let mes ="";
     
    let meses = [{ mes:'Enero'},{ mes:'Febrero'},{ mes:'Marzo'},{ mes:'Abril'}
    ,{ mes:'Mayo'},{ mes:'Junio'},{ mes:'Julio'},{ mes:'Agosto'}
    ,{ mes:'Septiembre'},{ mes:'Octubre'},{ mes:'Noviembre'},{ mes:'Diciembre'}];

    meses.forEach((item,index)=>{
        if(index == ((parseInt(valor)-1))){ mes = item.mes ;}
    });

    return mes;
}

get_data= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/cards`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
            data = xhr.response;
            obj_vh =data[1];
            obj_vc =data[0];

         
		    $("#venta_h").html(obj_vh.length);
		    $("#venta_c").html(obj_vc.length);
			
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al cargar los datos.",
			});
		}
	});
	xhr.send();
};

loadDataModal = (title, data) => {
	$("#titlemodal").html(title);
	tabla.clear();
	tabla.rows.add(data);
	tabla.draw();
};

$("#btn_ventah").on("click", () => {
	
	let url = 'seller/saleEgss';
		window.location.assign(host_url+url);
});

$("#btn_ventac").on("click", () => {
    let url = 'seller/saleCigar';
    window.location.assign(host_url+url);
});



const tabla = $("#table-utilidades").DataTable({

	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "id" },
		{ data: "producto" },
        { data: "stock" },
       
        
		
	],
});



number_format = (total) => {
    const formatterPeso = new Intl.NumberFormat('es-CO', {
        style: 'currency',
        currency: 'COP',
        minimumFractionDigits: 0
      })
    return formatterPeso.format(total);
}
let stockCigars =[];
let stockHuevo =[];


stockEggs= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/seller/stockEggs`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
		   data = xhr.response;
           stockHuevo = data;
		   console.log(stockHuevo);
			
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al cargar los datos.",
			});
		}
	});
	xhr.send();
};



stockCigar= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/seller/stockCigar`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            
           data = xhr.response;
           stockCigars = data;
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al cargar los datos.",
			});
		}
	});
	xhr.send();
};


datatable = ( data )=>{ 
    tabla.clear();
	tabla.rows.add(data);
	tabla.draw();
}


$("#btn_stockh").on("click", ()=> {
	$("#modal_stock").modal("show");
	$("#titlemodal").text("Stock de huevos");
	datatable(stockHuevo);
		
});

$("#btn_stockc").on("click", ()=> {

	$("#modal_stock").modal("show");
	$("#titlemodal").text("Stock de cigarros");
	datatable(stockCigars);
		
});

