document.addEventListener("DOMContentLoaded", function() {
    // total_registros();
});

function mifunciond() {

    //en este apartado obtenemos la fecha que viene desde el formulario de ka vista.php

    var fecha_inicio = document.querySelector('#fecha_inicio').value;
    var seleccion = document.querySelector('#seleccion').value;

    console.log(fecha_inicio);

    //le damos a la variable "fecha_inicio un nuevo nombre como date"

    var date = fecha_inicio;

    //declararmos una variable la cual sera un arreglo de nombres "year, month, day, con la funcion split"
    //El método split() divide un objeto de tipo String en un array (vector) 
    //de cadenas mediante la separación de la cadena en subcadenas.

    var [year, month, day] = date.split('-');

    //El método join() une todos los elementos de una matriz (o un objeto similar a una matriz) 
    //en una cadena y devuelve esta cadena.

    var result = [day, month, year].join('/');

    console.log(result);

    //si la variable result es diferente de null se ejecutara la función "buscar_registros".
    if (result != "" && seleccion != "") {
        buscar_registros(result, seleccion);
    } else {
        total_registros();
    }

    funcion_total_asistencia();
}


function buscar_registros(busqueda, seleccion_final) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActivateXObject('Microsift.XMLHTTP');
    var ajaxUrl = './../php/ptm.php';
    request.open('POST', ajaxUrl, true);
    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    request.send("consulta=" + busqueda + "&seleccion=" + seleccion_final);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#datos').innerHTML = request.responseText;
        }
    }
}

function mifunciondR() {

    

    //en este apartado obtenemos la fecha que viene desde el formulario de ka vista.php

    var fecha_inicio = document.querySelector('#fecha_inicio').value;
    var fecha_final = document.querySelector('#fecha_final').value;
    var seleccion = document.querySelector('#seleccion').value;



    // console.log(fecha_inicio);
    // console.log(fecha_final)
    var date = fecha_inicio;
    var date_final = fecha_final;


    var [year, month, day] = date.split('-');
    var [anio, mes, dia] = date_final.split('-');

    var result = [day, month, year].join('/');
    var result_final = [dia, mes, anio].join('/');

    console.log(result);
    console.log(result_final);





    if (result != "" && result_final != "" && seleccion != "") {
        buscar_registrosR(result, result_final, seleccion);
    } else {
        total_registros();
    }
  

    // funcion_total_asistencia();
}

function buscar_registrosR(fecha_ini,fecha_fin,seleccion_final) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActivateXObject('Microsift.XMLHTTP');
    var ajaxUrl = './../../php/regPermutas.php';
    request.open('POST', ajaxUrl, true);
    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    request.send("&fechaInicio=" + fecha_ini + "&fechaFinal=" + fecha_fin + "&seleccion=" + seleccion_final);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#datos').innerHTML = request.responseText;
        }
    }
}







function mifuncionPermR() {

    
    var fecha_inicio = document.querySelector('#fecha_inicio').value;
    var fecha_final = document.querySelector('#fecha_final').value;
    var seleccion = document.querySelector('#seleccion').value;



    // console.log(fecha_inicio);
    // console.log(fecha_final)
    var date = fecha_inicio;
    var date_final = fecha_final;


    var [year, month, day] = date.split('-');
    var [anio, mes, dia] = date_final.split('-');

    var result = [day, month, year].join('/');
    var result_final = [dia, mes, anio].join('/');

    console.log(result);
    console.log(result_final);





    if (result != "" && result_final != "" && seleccion != "") {
        buscar_registrosRP(result, result_final, seleccion);
    } else {
        total_registros();
    }

    // funcion_total_asistencia();
}

function buscar_registrosRP(fechaIni,fechaFin,seleccion_final) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActivateXObject('Microsift.XMLHTTP');
    var ajaxUrl = './../../php/regPermisos.php';
    request.open('POST', ajaxUrl, true);
    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    request.send("&fechaInicial=" + fechaIni + "&fechaFinal=" + fechaFin + "&seleccion=" + seleccion_final);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#datos').innerHTML = request.responseText;
        }
    }
}




function mifuncionPermAu() {

    
    var fecha_inicio = document.querySelector('#fecha_inicio').value;
    var fecha_final = document.querySelector('#fecha_final').value;
    var seleccion = document.querySelector('#seleccion').value;



    // console.log(fecha_inicio);
    // console.log(fecha_final)
    var date = fecha_inicio;
    var date_final = fecha_final;


    var [year, month, day] = date.split('-');
    var [anio, mes, dia] = date_final.split('-');

    var result = [day, month, year].join('/');
    var result_final = [dia, mes, anio].join('/');

    console.log(result);
    console.log(result_final);





    if (result != "" && result_final != "" && seleccion != "") {
        buscar_registrosPA(result, result_final, seleccion);
    } else {
        total_registros();
    }

    // funcion_total_asistencia();
}


function buscar_registrosPA(fechaIni,fechaFin,seleccion_final) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActivateXObject('Microsift.XMLHTTP');
    var ajaxUrl = './../php/regPermisosAuto.php';
    request.open('POST', ajaxUrl, true);
    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    request.send("&fechaInicial=" + fechaIni + "&fechaFinal=" + fechaFin + "&seleccion=" + seleccion_final);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#datos').innerHTML = request.responseText;
        }
    }
}







function funcion_total_asistencia() {

    //en este apartado obtenemos la fecha que viene desde el formulario de ka vista.php

    var fecha_inicio = document.querySelector('#fecha_inicio').value;
    var seleccion = document.querySelector('#seleccion').value;

    console.log(fecha_inicio);

    //le damos a la variable "fecha_inicio un nuevo nombre como date"

    var date = fecha_inicio;

    //declararmos una variable la cual sera un arreglo de nombres "year, month, day, con la funcion split"
    //El método split() divide un objeto de tipo String en un array (vector) 
    //de cadenas mediante la separación de la cadena en subcadenas.

    var [year, month, day] = date.split('-');

    //El método join() une todos los elementos de una matriz (o un objeto similar a una matriz) 
    //en una cadena y devuelve esta cadena.

    var result = [day, month, year].join('/');

    console.log(result);

    //si la variable result es diferente de null se ejecutara la función "buscar_registros".
    if (result != "" && seleccion != "") {
        buscar_registross(result, seleccion);
    }
}


function buscar_registross(busqueda, seleccion_final) {
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActivateXObject('Microsift.XMLHTTP');
    var ajaxUrl = './../php/total_asistencia.php';
    request.open('POST', ajaxUrl, true);
    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    request.send("consulta=" + busqueda + "&seleccion=" + seleccion_final);
    request.onreadystatechange = function() {
        if (request.readyState == 4 && request.status == 200) {
            document.querySelector('#total_asistencia').innerHTML = request.responseText;
        }
    }
}