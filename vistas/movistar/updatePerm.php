<?php
include ('nav.php');

include_once "../../bd/conexion.php";
// session_start();

// header("Content-Type: text/html; charset=UTF-8");


if(isset($_GET['id'])){

    $id=$_GET['id'];
    $sql2= "SELECT  e.name, p.id_jefe, e.nomina,j.nombre,j.apellidos,j.id, e.apellido_Paterno,e.apellido_Materno,p.id_permiso, p.fechaPermiso, p.motivo, p.tiempo_solicitado, c.descripcion from empleado e  INNER JOIN permisos p ON e.nomina = p.id_nomina INNER JOIN company c ON e.id_company_F=c.id_company INNER JOIN jefes_empresa j ON p.id_jefe= j.id WHERE p.id_permiso= '$id'";
    $query2 = $conn->prepare($sql2);
    $query2->execute();
    $numeroDeFilas = $query2->rowCount();

    if($numeroDeFilas > 0){

        foreach($query2 as $row){

        }
            
        
    } 
}

if(isset($_POST['update'])){

    $id=$_GET['id'];
    $motivo=$_POST['motivo'];
    $time=$_POST['time'];
    $fecha=$_POST['fecha'];

    $sql = "UPDATE permisos SET motivo=?, tiempo_solicitado=?, fechaPermiso=? WHERE id_permiso='$id'";
    $stmt= $conn->prepare($sql);
    $stmt->execute([$motivo,$time,$fecha]);
    $_SESSION['true']="Permiso actualizado";
    // header("Location: http://http://192.168.100.200:50//asistencias_empleados/vistas/sistemas/permisosreg.php");
    // sleep(1);

}

?>


<body>

<div class="container p-4">

<?php

if(isset($_SESSION['true'])):?>
    <script>
        Swal.fire({
        position: 'top-end',
        icon: 'success',
        title: 'Permiso actualizado',
        showConfirmButton: false,
        timer: 1500
        })
    </script>
<?php
// session_unset();
endif?>
                    <div class="row">
                        <div class="col-md-4 mx-auto">
                        <div class="card card-body" style="background: #1f66a8; color:white">
                            <form action="updatePerm.php?id=<?=$row['id_permiso']?>" method="POST" class="needs-validation">

                            <div class="form-group">
                                <label class="form-label">Jefe inmediato</label>
                                <input type="text" name="jefe" value="<?=$row['nombre'].' '.$row['apellidos']?>" class="form-control" disabled style="color: black; text-transform: uppercase; background: white;">
                               
                                <label for="motivo">Motivo permiso</label>
                                <textarea class="form-control" id="motivoPerm" rows="2" name="motivo"></textarea>
                                
                                <label class="form-label">Tiempo solicitado</label>
                                <input type="text" name="time" value="<?=$row['tiempo_solicitado']?>" class="form-control" style="color: black; background: white;">
                              
                                <label class="form-label">Fecha del permiso</label>
                                <input type="text" name="fecha" value="<?=$row['fechaPermiso']?>" class="form-control is-invalid" style="color: black; background: white;">
                                <div class="invalid-feedback"style="color:white!important;">
                                   Use el formato DD/MM/YYYY
                                </div>
                                <button class="btn btn-warning mt-3 den " name="update" >Actualizar</button>
                                <a href="permisosregmov.php" class="btn btn-danger mt-3 float-end ">Regresar</a>
                                
                            </div>
                            </form>
                        </div>
                        </div>
                        
                    </div>
                </div>

<script>

    $('#motivoPerm').text("<?=$row['motivo']?>")
    // var ptm=$('.den');
    //     ptm.click(function(e){
    //         window.close();
                
    //     })
   
    

  

    
</script>
</body>
</html>


