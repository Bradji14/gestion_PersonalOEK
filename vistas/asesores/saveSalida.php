<?php
include_once "../../bd/conexion.php";

$sql = "SELECT  e.id_empleado, e.nomina, e.name,e.id_esquema_f, e.apellido_Paterno, e.apellido_Materno, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e 
INNER JOIN turno t ON t.id_turno = e.id_turno_F 
INNER JOIN company c ON c.id_company = e.id_company_F";

$query = $conn->prepare($sql);
$query->execute();



date_default_timezone_set('America/Mexico_City');
$mifecha = new DateTime(); 
// $mifecha->modify('-1 hours');  
$ptm=$mifecha->format('H:i:s');

$date=$mifecha->format('Y-m-d H:i');
// echo substr($date,0,10);
$datenow=substr($date,0,10);

$dateHour=substr($date,10,18);
// $dateHour=substr($date,10,18);
session_start();
$nomina= $_SESSION['nomina'];

$ip_add = $_SERVER['REMOTE_ADDR'];

$pattern = '%' . $datenow . '%';

if (isset($_POST['salida'])) {

    $sql1 ="SELECT * from pase WHERE nomina='$nomina' and fecha_salida = '%$datenow%' ";
    $query1 = $conn->prepare($sql1);
    $query1->execute();
    $numeroDeFilas = $query1->rowCount();


    if ($numeroDeFilas > 0) 
    {
        // session_start();
        // $_SESSION['out'] = "salida";
        header("Location:http://192.168.100.200:50/asistencias_empleados/");
      
    }
    else
    {
        foreach ($query as $row) {

            if ($nomina == $row['nomina']) {
                $salida = $row['salida'];
                $esquema = $row['id_esquema_f'];
            }
        }

        if ($esquema == 2) {

            $sql = "UPDATE pase SET fecha_salida=?, salida=? where nomina=? and fecha_reg  LIKE ?";
            $query = $conn->prepare($sql);
            $query->execute([$dateHour, 'S', $nomina,$pattern]);     
            session_start();     
            header("Location:../../login/cerrar_sesion.php");

            if (intval(str_replace(":", '', substr($date, -6))) + 400) {

                $sql = "UPDATE pase SET fecha_salida=?, salida=? where nomina=? and fecha_reg  LIKE ?";
                $query = $conn->prepare($sql);
                $query->execute([$dateHour, 'SA', $nomina,$pattern]);
                session_start();  
                header("Location:../../login/cerrar_sesion.php");
            
            } 
        }
       elseif (intval(str_replace(":", '', substr($date, -6))) < intval(str_replace(":", '', $salida))) {

            $sql = "UPDATE pase SET fecha_salida=?, salida=? where nomina=?  and fecha_reg  LIKE ?";
            $query = $conn->prepare($sql);
            $query->execute([$dateHour, 'SA', $nomina,$pattern]);
            session_start();   
            header("Location:../../login/cerrar_sesion.php");
        } elseif (intval(str_replace(":", '', substr($date, -6))) >= intval(str_replace(":", '', $salida))) {

            $sql = "UPDATE pase SET fecha_salida=?, salida=? where nomina=?  and fecha_reg  LIKE ?";
            $query = $conn->prepare($sql);
            $query->execute([$dateHour, 'S', $nomina,$pattern]);
            session_start();
            header("Location:../../login/cerrar_sesion.php");
        }

        
    }
}


// if (isset($_POST['turn'])) {
//     $sql = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";
//     $query = $conn->prepare($sql);
//     $query->execute([$nomina, $dateHour, 'A',$datenow,$ip_add,2]);
//     session_start();
//     header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
// }

