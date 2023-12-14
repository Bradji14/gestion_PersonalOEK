document.addEventListener("DOMContentLoaded", function(){
    total_registros();
});

document.addEventListener('mousemove',function(){

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
    if(result != "" && seleccion != ""){
        buscar_registros(result, seleccion);
    }else{
        total_registros();
    }
});


function buscar_registros(busqueda, seleccion_final){
    var request = (window.XMLHttpRequest) ? new XMLHttpRequest() : new ActivateXObject('Microsift.XMLHTTP');
    var ajaxUrl = './../php/buscar.php';
    request.open('POST',ajaxUrl,true);
    request.setRequestHeader('Content-type', 'Application/x-www-form-urlencoded');
    request.send("consulta="+busqueda+"&seleccion="+seleccion_final);
    request.onreadystatechange = function(){
        if(request.readyState == 4 && request.status == 200){
            document.querySelector('#datos').innerHTML = request.responseText;
        }
    }
}

