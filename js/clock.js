$(document).ready(Clock);
function Clock(){
    var ahora = new Date();
    var hora = ahora.getHours();
    var minuto = ahora.getMinutes();
    var segundo = ahora.getSeconds();

	h = new String(hora);
	m = new String(minuto);
	s = new String(segundo);
	
	if(h.length ==1){
		hora= "0" + hora;
		}
	if(m.length ==1){
		minuto= "0" + minuto;
		}
	if(s.length ==1){
		segundo= "0" + segundo;
		}
		
	var meses = new Array ("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Set","Oct","Nov","Dic");
	var dias = new Array("Dom","Lun","Mar","Mie","Jue","Vie","Sab");


    Reloj = hora + " : " + minuto + " : " + segundo;
	Hoy = dias[ahora.getDay()] + ", " + ahora.getDate() + " de " + meses[ahora.getMonth()] + " de " + ahora.getFullYear();

	$("input#hora").val(Reloj);
	$("input#fecha").val(Hoy);

    setTimeout("Clock()", 1000);
} 
