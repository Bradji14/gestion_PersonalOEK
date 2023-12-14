<?php
session_start();

include_once "../../bd/conexion.php";
// include_once "nav.php";

if (!empty($_POST['fecha_inicio']) && !empty($_POST['seleccion']) || empty($_POST['fecha_inicio']) && empty($_POST['seleccion']) ){

    // $consulta = $_POST['fecha_inicio'];
    $seleccion = $_POST['seleccion'];
    $_SESSION['fechaChida']= $_POST['fecha_inicio'];
    // $newDate = date("d/m/Y", strtotime($_POST['fecha_inicio']));
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Asistencias</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <link rel="icon" href="https://oek.com.mx/wp-content/uploads/2022/01/cropped-OEK-favicon-32x32.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />


    <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://markcell.github.io/jquery-tabledit/assets/js/tabledit.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link href="../../style/mi.css" rel="stylesheet" />

</head>


<nav class="navbar navbar-expand-lg hsbc">
    <div class="container-fluid">

        <img src="../../img/MUNDO.png" class="logom">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!-- <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a> -->
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Asistencias
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="consultaHSBC.php">Pase de lista</a></li>
                        <!-- <li><a class="dropdown-item" href="consulta_rangoHSBC.php">Asistencia de un rango de fechas</a> -->
                </li>
                <!-- <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
            </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Alta de Permisos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="permutashsbc.php">Permutas<a></li>
                    <li><a class="dropdown-item" href="permisoshsbc.php">Permiso laboral</a></li>
                    <!-- <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                </ul>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Ver Permisos
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="permutasreghsbc.php">Permutas registradas<a></li>
                    <li><a class="dropdown-item" href="permisosreghsbc.php">Permisos registrados</a></li>

                </ul>
            </li>

            <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Pemisos Autorizados
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="permutasregAuto.php">Permutas <a></li>
                        <li><a class="dropdown-item" href="permisosregAutoHs.php">Permisos    </a></li>
                    </ul>
                </li> -->
            <div class="position-absolute top-0 end-0">

                <div class="text-end p-4">
                    <p class="nameNav"> <i class="fa fa-user m-3" style="font-size: 20px;"></i>AGUSTIN LAREDO CARMONA
                    </p>

                    <a href="../../login/cerrar_sesion.php"> <i class="fa-solid fa-right-from-bracket"></i> Cerra
                        sesión</a>

                </div>

            </div>

            </ul>
        </div>
    </div>
</nav>



<body>



    <div class="col-md-12 text-light p-3 mb-5" style="font-size:16px;background:#0D2535">
        <h4 class="text-center text-light mb-3" style="font-size:20px;">SIMBOLOGIA</h4>
        <div class="d-flex justify-content-around">

            <p style="font-size:20px">A - <span style="font-size:17px">Asistencias correctas</span></p>
            <p style="font-size:20px">R - <span style="font-size:17px">Retardos</span></p>
            <p style="font-size:20px">F - <span style="font-size:17px">Faltas</span></p>
            <!-- <p style="font-size:20px">S - <span style="font-size:17px">Salidas correctas</span></p>
            <p style="font-size:20px">SA - <span style="font-size:17px">Salidas anticipadas</span></p> -->


        </div>

    </div>



    <div class="container mt-5">
        <h3 align="center" style="color:#ffff">Tabla de ASISTENCIAS-SALIDAS</h3>
        <br>
        <div class="panel panel-default">
            <div class="panel-body p-5">
                <div class="table-responsive">
                    <table id="sample_data" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="text-align:center;">NOMINA</th>
                                <th style="text-align:center;">NOMBRE</th>
                                <th style="text-align:center;">ESQUEMA</th>
                                <th style="text-align:center;">HORA <br> ENTRADA</th>
                                <th style="text-align:center;">HORA <br> SALIDA</th>
                                <th style="text-align:center;">REGISTRO<br>ENTRADA</th>
                                <th style="text-align:center;">FECHA DE REGISTRO</th>
                                <th style="text-align:center;">ESTATUS</th>

                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <br>
    <br>
</body>

</html>


<script type="text/javascript" language="javascript">
$(document).ready(function() {

    var dataTable = $('#sample_data').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            url: "lista/fetch.php",
            type: "POST"
        }
    });
    //  $column = array("id", "nomina", "fecha_hora", "name");

    $('#sample_data').on('draw.dt', function() {

        $('#sample_data').Tabledit({

            url: 'lista/action.php',
            dataType: 'json',
            columns: {
                identifier: [0, 'nomina'],
                editable: [
                    [5, 'entrada','{"1":"A","2":"R","3":"F"}'],
                    [7, 'status', '{"4":"0","5":"1"}']
                    // [7, 'status','{"4":"0","5":"1"}']
                    
                ],
              
                // editable:[[1, 'nomina'], [2, 'fecha_hora'], [3, 'name', '{"1":"Male","2":"Female"}']]
            },
            restoreButton: false,
            onSuccess: function(data, textStatus, jqXHR) {
                if (data.action == 'delete') {
                    $('#' + data.id).remove();
                    $('#sample_data').DataTable().ajax.reload();
                }
            }

        });
    });
})
</script>
<?php
      }
           else{

    header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/hsbc/consultaHSBC.php");
}