<?php

session_start();


require "../bd/conexion.php";

$sql = "SELECT  e.id_empleado, e.nomina, e.name,e.id_esquema_f, e.apellido_Paterno, e.apellido_Materno, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e 
INNER JOIN turno t ON t.id_turno = e.id_turno_F 
INNER JOIN company c ON c.id_company = e.id_company_F";

$query = $conn->prepare($sql);
$query->execute();

$nomina = $_POST['nomina'];
$pass=$_POST['pass'];
date_default_timezone_set('America/Mexico_City');
$mifecha = new DateTime(); 
$mifecha->modify('-1 hours'); 
$date=$mifecha->format('Y-m-d H:i');
// echo substr($date,0,10);
$datenow=substr($date,0,10);

$dateHour=substr($date,10,18);
$ip_add = $_SERVER['REMOTE_ADDR'];

$pattern = '%' . $datenow . '%';

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
                    $sql = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";
                    $query = $conn->prepare($sql);
                    $query->execute([$nomina, $dateHour, 'A',$datenow,$ip_add,1]);
                    session_start();
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['ac'] = "Asistencia correcta";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");

                }
                elseif (intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada))+50) {

                    $sql = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";
                    $query = $conn->prepare($sql);
                    $query->execute([$nomina, $dateHour, 'A',$datenow,$ip_add,1]);
                    session_start();
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['ac'] = "Asistencia correcta";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                }
                elseif (intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada)) + 5) {
            
                    $sql = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";
                    $query = $conn->prepare($sql);
                    $query->execute([$nomina, $dateHour, 'R',$datenow,$ip_add,1]);
                    session_start();
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['r'] = "Asistencia con retardo";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                } 
                elseif (intval(str_replace(":", '', substr($date, -6))) >= intval(str_replace(":", '', $entrada)) + 6 && intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada)) + 100) {
            
                    $sql = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";
                    $query = $conn->prepare($sql);
                    $query->execute([$nomina, $dateHour, 'F',$datenow,$ip_add,1]);
                    session_start();
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['af'] = "Asistencia con falta";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
                }
                elseif (intval(str_replace(":", '', substr($date, -6))) <= intval(str_replace(":", '', $entrada)) + 1000) {
            
                    $sql = "INSERT INTO pase(nomina,fecha_entrada,entrada,fecha_reg,ipRed,status) VALUES (?,?,?,?,?,?)";
                    $query = $conn->prepare($sql);
                    $query->execute([$nomina, $dateHour, 'F',$datenow,$ip_add,1]);
                    session_start();
                    $_SESSION['nomina']=$nomina;
                    $_SESSION['af'] = "Asistencia con falta";
                    $_SESSION['hr']=$dateHour;
                    header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/asesores/bloc.php");
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

