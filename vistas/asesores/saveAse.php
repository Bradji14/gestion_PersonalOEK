<?php

$fi=fopen("C:\Users\SISTEMAS\Desktop\archivo.txt","a")
or die ("problema al crear archivo");

fwrite($fi,$_POST['dates']);
fclose($fi);

header('Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php');

