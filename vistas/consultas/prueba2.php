<?php



if(isset($_POST['buscar'])){
    require "../../bd/conexion.php";

    $id=$_POST['po'];
   
    $valores=array();
    $valores['existe']="0";

    $query3 =$conn->query("SELECT *, company.descripcion FROM empleado  INNER JOIN turno ON empleado.id_turno_F=turno.id_turno INNER JOIN company ON empleado.id_company_F=company.id_company WHERE empleado.nomina ='$id';");
    // $query3 = $conn->query("SELECT * FROM empleado INNER JOIN permisos ON empleado.nomina=permisos.id_nomina WHERE empleado.nomina='$empleado'");
    // $query = $conn->prepare($sql);
    // $query->execute();

    while ($row = $query3->fetch()) {
        $valores['existe']="1";
        $valores['name']=$row['name'].' '.$row['apellido_Paterno'].' '.$row['apellido_Materno'];
        $valores['turno']=$row['turno'].' '.$row['entrada'].'-'.$row['salida'];
        $valores['compa']=$row['descripcion'];
        $valores['id_turno']=$row['id_turno'];
        sleep(1);
        $ptm=json_encode($valores);
        echo $ptm;
        
    }
}