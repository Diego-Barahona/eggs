$(() => {

	get_data();
	

	
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
			
		} 
	});
	xhr.send();
};



