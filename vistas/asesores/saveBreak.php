<?php
include_once "../../bd/conexion.php";



// GUARDAR ENTRADA Y SALIDA A,F,R
$sql = "SELECT  e.id_empleado, e.nomina, e.name,e.id_esquema_f, e.apellido_Paterno, e.apellido_Materno, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e 
INNER JOIN turno t ON t.id_turno = e.id_turno_F 
INNER JOIN company c ON c.id_company = e.id_company_F";

$query = $conn->prepare($sql);
$query->execute();



date_default_timezone_set('America/Mexico_City');
$mifecha = new DateTime(); 
// $mifecha->modify('-1 hours'); 
$ptm=$mifecha->format('H:i');

$date=$mifecha->format('Y-m-d H:i');
// echo substr($date,0,10);
$datenow=substr($date,0,10);

session_start();
$nomina= $_SESSION['nomina'];

$pattern = '%' . $datenow . '%';



if (isset($_POST['inibre'])) {

    
    $sqlp1 = "SELECT hr_break,fecha_entrada,entrada from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=0 and hr_break !='' ";
    $queryp1= $conn->prepare($sqlp1);
    $queryp1->execute();
    $numeroDeFilast = $queryp1->rowCount();

    foreach ($queryp1 as $row) {

        $brei=$row['hr_break'];
        $hrEntr=$row['fecha_entrada'];
        $entradaR=$row['entrada'];

    }


    if($numeroDeFilast > 0){

        $sql = "UPDATE pase SET hr_break=?,fecha_entrada=?,entrada=?,status=?  where nomina=? and fecha_reg  LIKE ? and status=2";
        $query = $conn->prepare($sql);
        $query->execute([$brei,$hrEntr,$entradaR,1,$nomina,$pattern]);
        session_start();
        $_SESSION['regbrei']='asd';
        $_SESSION['enreg']=$hrEntr;

        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");

    }
    else{
        $sql = "UPDATE pase SET hr_break=? where nomina=? and fecha_reg  LIKE ?";
        $query = $conn->prepare($sql);
        $query->execute([$ptm,$nomina,$pattern]);
        session_start();
        $_SESSION['brei']=$ptm;
        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
    }


}


if (isset($_POST['finbre'])) {

    $sqlp12 = "SELECT hr_break_fin from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=0 and hr_break_fin !=''";
    $queryp12= $conn->prepare($sqlp12);
    $queryp12->execute();
    $numeroDeFilast2 = $queryp12->rowCount();

    foreach ($queryp12 as $row) {

        $bref=$row['hr_break_fin'];

    }

    if($numeroDeFilast2 > 0){

        $sql = "UPDATE pase SET hr_break_fin=?  where nomina=? and fecha_reg  LIKE ?";
        $query = $conn->prepare($sql);
        $query->execute([$bref,$nomina,$pattern]);
        session_start();
        $_SESSION['regbref']='asd';
        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");

    }
    else{
        $sql = "UPDATE pase SET hr_break_fin=? where nomina=? and fecha_reg  LIKE ?";
        $query = $conn->prepare($sql);
        $query->execute([$ptm, $nomina,$pattern]);
        session_start();
        $_SESSION['bref']=$ptm;
        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
    }


   
}



?>