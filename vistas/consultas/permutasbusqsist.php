<?php

session_start();

if(isset($_POST['save'])){

    require "../../bd/conexion.php";

    $nom1=$_POST['nom1'];
    $nom2=$_POST['nom2'];
    $turnoreq1=$_POST['turnoreq1'];
    $turnoreq2=$_POST['turnoreq2'];
    $motivo=$_POST['motivo'];
    $compa=$_POST['compa'];
    //2023-02-11
    $newDate = date("Y/m/d", strtotime($_POST['dateP']));
    
    // $date=$_POST['date'];
    $fechaActual = date('Y-m-d');

    if(!empty($nom1) && !empty($nom2) && !empty($turnoreq1) && !empty($turnoreq2)&& !empty($motivo) && !empty($newDate))
    {
        $sql="SELECT nomina FROM empleado WHERE nomina ='$nom1' ;";
        $query = $conn->prepare($sql);
        $query->execute();
        # Ver cuántas filas devuelve
        $numeroDeFilas = $query->rowCount();

        $sql1="SELECT nomina FROM empleado WHERE nomina ='$nom2' ;";
        $query1 = $conn->prepare($sql1);
        $query1->execute();
        # Ver cuántas filas devuelve
        $numeroDeFilas1 = $query1->rowCount();
        
  
        if($numeroDeFilas<=0 && $numeroDeFilas1<=0 || $numeroDeFilas<=0 || $numeroDeFilas1<=0){
          
          $_SESSION['nomina']="Nominas ingresadas no validas";
          header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/permutas.php"); 
        }
        if($sql==$sql1)
          {
            $_SESSION['nominaR']="Ingrese nominas distintas";
            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/permutas.php");
          }
          else{
            $sql = "INSERT INTO permutas(nomina_primerE,nomina_primerS,id_turno_cambio,id_turno_cambio2,motivoPermuta,fecha_permuta,company,created_at) VALUES (?,?,?,?,?,?,?,?)";
            $query = $conn->prepare($sql);
            $query->execute([$nom1,$nom2,$turnoreq1,$turnoreq2,$motivo,$newDate,$compa,$fechaActual]);
            $_SESSION['listo']="Permuta con exito";

            header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/permutas.php");
            }
       
        
    }
    else
    {
        $_SESSION['vacio']="Campos vacios";
        header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/permutas.php");
    }

}