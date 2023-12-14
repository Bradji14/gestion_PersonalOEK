<?php

session_start();
require "../bd/conexion.php";

$sql = "SELECT  e.id_empleado, e.nomina, e.name,e.id_esquema_f, e.apellido_Paterno, e.apellido_Materno, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e 
INNER JOIN turno t ON t.id_turno = e.id_turno_F 
INNER JOIN company c ON c.id_company = e.id_company_F";
$query = $conn->prepare($sql);
$query->execute();

date_default_timezone_set('America/Mexico_City');



$query = $conn->prepare($sql);
$query->execute();

$nomina = $_POST['nomina'];
$pass=$_POST['pass'];
$mifecha = new DateTime(); 
// $mifecha->modify('-1 hours'); 
$date=$mifecha->format('Y-m-d H:i');
$datenow=substr($date,0,10);
 
$dateHour=substr($date,10,18);
$ip_add = $_SERVER['REMOTE_ADDR'];

$pattern = '%' . $datenow . '%';

$fech1='27-06-2023';
$fech2='30-09-2023';

$fechaActual = strtotime($fech1);
$fechaFin = strtotime($fech2);



if (!empty($nomina) && !empty($pass)) {

    if (isset($_POST['entrada'])) {


        $sqllo = "SELECT * from ase_tel WHERE nomina='$nomina' and password='$pass'";
        $query5 = $conn->prepare($sqllo);
        $query5->execute();
        $numeroDeFilas5 = $query5->rowCount();

        foreach ($query5 as $row) {

            if ($row['password']=="Asesor2023") {
               session_start();
               $_SESSION['changeErr']="d";
               header("Location:http://192.168.100.200:50/asistencias_empleados/");
               exit();
 
            }

        }
        
        if ($numeroDeFilas5 > 0) {
           
            $sql1 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=1";
            $query1 = $conn->prepare($sql1);
            $query1->execute();
            $numeroDeFilas = $query1->rowCount();

    
            if($numeroDeFilas > 0){
                session_start();
                $_SESSION['entrada'] = "entradas";
                header("Location:http://192.168.100.200:50/asistencias_empleados/");    
            }
            else{
               
                foreach ($query as $row) {

                    if ($nomina == $row['nomina']) {
                        $entrada = $row['entrada'];
                        $esquema = $row['id_esquema_f'];
                       
                    }

                }

                if ($esquema == 2) {

                    
                    $sql1 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=2";
                    $query1 = $conn->prepare($sql1);
                    $query1->execute();
                    $numeroDeFilas = $query1->rowCount();

                    if($numeroDeFilas > 0){

                        $sql = "UPDATE pase SET fecha_entrada=?,entrada=?,fecha_reg=?,ipRed=?,status=? where nomina=? and fecha_reg  LIKE ?";
                        $query = $conn->prepare($sql);
                        $query->execute([$dateHour, 'A',$datenow,$ip_add,1,$nomina,$datenow]);
                        session_start();
                        $_SESSION['nomina']=$nomina;
                        $_SESSION['ac'] = "Asistencia correcta";
                        $_SESSION['hr']=$dateHour;
                        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                    }


                   else{

                    $sql21= "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                    $query21 = $conn->prepare($sql21);
                    $query21->execute([$nomina,$dateHour, 'A',$datenow,$ip_add,1]);


                    $sql2 = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                    $query2 = $conn->prepare($sql2);


                    for ($i = $fechaActual; $i <= $fechaFin; $i = strtotime('+1 day', $i))
                    {

                        $fecha = date('Y-m-d', $i);
                        $sql15 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$fecha%' and status=2";
                        $query15 = $conn->prepare($sql15);
                        $query15->execute();
                        $numeroDeFilas5 = $query15->rowCount();

                        if($numeroDeFilas5 > 0){
                            // break;
                            $_SESSION['nomina']=$nomina;
                            $_SESSION['ac'] = "Asistencia correcta";
                            $_SESSION['hr']=$dateHour;
                            header("Location:http://localhost/asistencias_empleados/vistas/asesores/bloc.php");
                        }
                        else{
                            $query2->execute([$nomina,'-', 'F',$fecha,$ip_add,2]);
                        }
                   } 
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['ac'] = "Asistencia correcta";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                }
            }


                elseif (intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada))) {

                    
                    $sql1 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=2";
                    $query1 = $conn->prepare($sql1);
                    $query1->execute();
                    $numeroDeFilas = $query1->rowCount();

                    
                    if($numeroDeFilas > 0){
                        
                        $sql = "UPDATE pase SET fecha_entrada=?,entrada=?,fecha_reg=?,ipRed=?,status=? where nomina=? and fecha_reg  LIKE ?";
                        $query = $conn->prepare($sql);
                        $query->execute([$dateHour, 'A',$datenow,$ip_add,1,$nomina,$datenow]);  
                        session_start();
                        $_SESSION['nomina']=$nomina;
                        $_SESSION['ac'] = "Asistencia correcta";
                        $_SESSION['hr']=$dateHour;
                        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                    }

                    else{
                        
                        $sql21= "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                        $query21 = $conn->prepare($sql21);
                        $query21->execute([$nomina,$dateHour, 'A',$datenow,$ip_add,1]);
    
                        $sql2 = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                        $query2 = $conn->prepare($sql2);
    
                        for ($i = $fechaActual; $i <= $fechaFin; $i = strtotime('+1 day', $i)){
    
                            $fecha = date('Y-m-d', $i);
                            $sql15 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$fecha%' and status=2";
                            $query15 = $conn->prepare($sql15);
                            $query15->execute();
                            $numeroDeFilas5 = $query15->rowCount();
    
                            if($numeroDeFilas5 > 0){
                                // break;
                                $_SESSION['nomina']=$nomina;
                                $_SESSION['ac'] = "Asistencia correcta";
                                $_SESSION['hr']=$dateHour;
                                header("Location:http://localhost/asistencias_empleados/vistas/asesores/bloc.php");
                            }
                            else{
                                $query2->execute([$nomina,'-', 'F',$fecha,$ip_add,2]);
                            }      
                       } 
                        $_SESSION['nomina']=$nomina;
                        $_SESSION['ac'] = "Asistencia correcta";
                        $_SESSION['hr']=$dateHour;
                        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                    }

                   
                }


                elseif (intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada)) + 5) {
            
                    $sql1 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=2";
                    $query1 = $conn->prepare($sql1);
                    $query1->execute();
                    $numeroDeFilas = $query1->rowCount();

                    if($numeroDeFilas > 0){
                        $sql = "UPDATE pase SET fecha_entrada=?,entrada=?,fecha_reg=?,ipRed=?,status=? where nomina=? and fecha_reg  LIKE ?";
                        $query = $conn->prepare($sql);
                        $query->execute([$dateHour, 'R',$datenow,$ip_add,1,$nomina,$datenow]);
                        session_start();
                        $_SESSION['nomina']=$nomina;
                        $_SESSION['r'] = "Asistencia con retardo";
                        $_SESSION['hr']=$dateHour;
                        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                    }

                    else{

                        $sql21= "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                        $query21 = $conn->prepare($sql21);
                        $query21->execute([$nomina,$dateHour, 'R',$datenow,$ip_add,1]);
    
                        $sql2 = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                        $query2 = $conn->prepare($sql2);
    
                        for ($i = $fechaActual; $i <= $fechaFin; $i = strtotime('+1 day', $i)){
    
                            $fecha = date('Y-m-d', $i);
                            $sql15 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$fecha%' and status=2";
                            $query15 = $conn->prepare($sql15);
                            $query15->execute();
                            $numeroDeFilas5 = $query15->rowCount();
    
                            if($numeroDeFilas5 > 0){
                                // break;
                                $_SESSION['nomina']=$nomina;
                                $_SESSION['ac'] = "Asistencia correcta";
                                $_SESSION['hr']=$dateHour;
                                header("Location:http://localhost/asistencias_empleados/vistas/asesores/bloc.php");
                            }
                            else{
                                $query2->execute([$nomina,'-', 'F',$fecha,$ip_add,2]);
                            }      
                       } 
                        $_SESSION['nomina']=$nomina;
                        $_SESSION['ac'] = "Asistencia correcta";
                        $_SESSION['hr']=$dateHour;
                        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                    
                         } 

                        }

                elseif (intval(str_replace(":", '', substr($date, -6))) >= intval(str_replace(":", '', $entrada)) + 6 && intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada)) + 100) {
        
                    
                    $sql1 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=2";
                    $query1 = $conn->prepare($sql1);
                    $query1->execute();
                    $numeroDeFilas = $query1->rowCount();

                if($numeroDeFilas > 0){

                    $sql = "UPDATE pase SET fecha_entrada=?,entrada=?,fecha_reg=?,ipRed=?,status=? where nomina=? and fecha_reg  LIKE ?";
                    $query = $conn->prepare($sql);
                    $query->execute([$dateHour, 'FR',$datenow,$ip_add,1,$nomina,$datenow]);
                   
                    session_start();
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['af'] = "Asistencia con falta";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                }
                else{
                    $sql21= "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                    $query21 = $conn->prepare($sql21);
                    $query21->execute([$nomina,$dateHour, 'FR',$datenow,$ip_add,1]);

                    $sql2 = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                    $query2 = $conn->prepare($sql2);

                    for ($i = $fechaActual; $i <= $fechaFin; $i = strtotime('+1 day', $i)){

                        $fecha = date('Y-m-d', $i);
                        $sql15 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$fecha%' and status=2";
                        $query15 = $conn->prepare($sql15);
                        $query15->execute();
                        $numeroDeFilas5 = $query15->rowCount();

                        if($numeroDeFilas5 > 0){
                            // break;
                            $_SESSION['nomina']=$nomina;
                            $_SESSION['ac'] = "Asistencia correcta";
                            $_SESSION['hr']=$dateHour;
                            header("Location:http://localhost/asistencias_empleados/vistas/asesores/bloc.php");
                        }
                        else{
                            $query2->execute([$nomina,'-', 'F',$fecha,$ip_add,2]);
                        }      
                   } 
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['ac'] = "Asistencia correcta";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                }

            }
                elseif (intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada)) + 1000) {

                    $sql1 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=2";
                    $query1 = $conn->prepare($sql1);
                    $query1->execute();
                    $numeroDeFilas = $query1->rowCount();


                    if($numeroDeFilas > 0){

                        $sql = "UPDATE pase SET fecha_entrada=?,entrada=?,fecha_reg=?,ipRed=?,status=? where nomina=? and fecha_reg  LIKE ?";
                        $query = $conn->prepare($sql);
                        $query->execute([$dateHour, 'FR',$datenow,$ip_add,1,$nomina,$datenow]);
                        session_start();
                        $_SESSION['nomina']=$nomina;
                        $_SESSION['af'] = "Asistencia con falta";
                        $_SESSION['hr']=$dateHour;
                        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                    }
                    else{

                        $sql21= "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                        $query21 = $conn->prepare($sql21);
                        $query21->execute([$nomina,$dateHour, 'FR',$datenow,$ip_add,1]);
    
                        $sql2 = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";    
                        $query2 = $conn->prepare($sql2);
    
                        for ($i = $fechaActual; $i <= $fechaFin; $i = strtotime('+1 day', $i)){
    
                            $fecha = date('Y-m-d', $i);
                            $sql15 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$fecha%' and status=2";
                            $query15 = $conn->prepare($sql15);
                            $query15->execute();
                            $numeroDeFilas5 = $query15->rowCount();
    
                            if($numeroDeFilas5 > 0){
                                // break;
                                $_SESSION['nomina']=$nomina;
                                $_SESSION['ac'] = "Asistencia correcta";
                                $_SESSION['hr']=$dateHour;
                                header("Location:http://localhost/asistencias_empleados/vistas/asesores/bloc.php");
                            }
                            else{
                                $query2->execute([$nomina,'-', 'F',$fecha,$ip_add,2]);
                            }      
                       } 
                        $_SESSION['nomina']=$nomina;
                        $_SESSION['ac'] = "Asistencia correcta";
                        $_SESSION['hr']=$dateHour;
                            header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                        }
                        
                    }
            }
        
        }
        else{
            $_SESSION['error'] = "Datos erroneos";
            header("Location:http://192.168.100.200:50/asistencias_empleados/");
            }

        
    } 
    
} 

else {

    header("Location:http://192.168.100.200:50/asistencias_empleados/");
    // session_destroy();
}

