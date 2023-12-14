document.addEventListener("DOMContentLoaded", function(){

});

function mifuncion(){

    //en este apartado obtenemos la fecha que viene desde el formulario de ka vista.php

    var fecha_inicio = document.querySelector('#fecha_inicio').value;
    var fecha_final = document.querySelector('#fecha_final').value;
    var seleccion = document.querySelector('#seleccion').value;
    
    

    console.log(fecha_inicio);
    console.log(fecha_final)
    var date = fecha_inicio;
    var date_final = fecha_final;

    
    var [year, month, day] = date.split('-');
    var [anio, mes, dia] = date_final.split('-');

    var result = [day, month, year].join('/');
    var result_final = [dia, mes, anio].join('/');

    console.log(result); 
    console.log(result_final);





    if(result != "" && result_final != "" && seleccion != ""){
        buscar_registros(result, result_final, seleccion);
    }else{
        total_registros();
    }
};


function buscar_registros(busqueda, busqueda_final, final_seleccion){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActivateXObject('Microsift.XMLHTTP');
    var ajaxUrl = './../php/buscar_rango.php';
    request.open('POST',ajaxUrl,true);
    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    request.send("consulta="+busqueda+"&consultados="+busqueda_final+"&seleccion="+final_seleccion);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#datos').innerHTML = request.responseText;
        }
    }
}
