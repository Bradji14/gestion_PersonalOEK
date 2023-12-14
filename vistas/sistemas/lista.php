<?php
session_start();
include_once "../../bd/conexion.php";
$stmt = $conn->prepare("SELECT p.nomina,p.entrada,p.salida,p.fecha_reg,p.fecha_entrada,p.fecha_salida,p.hr_break,p.hr_break_fin,
e.name,e.apellido_Paterno,e.apellido_Materno,c.descripcion
FROM pase p
INNER JOIN empleado e ON p.nomina = e.nomina
INNER JOIN company c ON e.id_company_F =c.id_company");
$stmt->execute(); 
if(isset($_SESSION['user'])){
    ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asistencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="icon" href="https://oek.com.mx/wp-content/uploads/2022/01/cropped-OEK-favicon-32x32.png">

    <link href="../../style/mi.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/datetime/1.2.0/css/dataTables.dateTime.min.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>

    <script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />



    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/datetime/1.2.0/js/dataTables.dateTime.min.js"></script>
   

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.print.min.js"></script>

</head>

<nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">

        <img src="../../img/logo2.gif" class="logow">

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <!-- <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a> -->
                </li>
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Asistencias
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="consulta_diaespecifico.php">Pase de lista</a></li>

                    </ul>
                </li> -->

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Alta de Permisos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="permutas.php">Permutas<a></li>
                        <li><a class="dropdown-item" href="permisos.php">Permiso laboral</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Ver Permisos
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="permutasreg.php">Permutas registradas<a></li>
                        <li><a class="dropdown-item" href="permisosreg.php">Permisos registrados</a></li>

                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Control de asistencias
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="lista.php">Asistencias Generales<a></li>
                        <!-- <li><a class="dropdown-item" href="listaDia.php">Asistencias por nomina (Administativos)<a></li> -->
                        <li><a class="dropdown-item" href="listaAdmin.php">Asistencias Totales<a></li>
                    </ul>
                </li>


                <div class="position-absolute top-0 end-0">
                    <div class="text-end p-4">
                    <p class="nameNav" > <i class="fa fa-user m-3" style="font-size: 20px;"></i>ALICIA IBARRA GONZALEZ</p>          


                        <a href="../../login/cerrar_sesion.php"> <i class="fa-solid fa-right-from-bracket"></i> Cerra
                            sesión</a>
                    </div>


                </div>

            </ul>
        </div>
    </div>
</nav>



<body>

    <div id="contab" style="background:#ffff;padding:10px;margin:20px">



        <table border="0" cellspacing="5" cellpadding="5" class="stripe row-border order-column " id="gu">
            <tbody>
                <tr>
                    <td>Rango inicial:</td>
                    <td><input type="text" id="min" name="min"></td>
                </tr>
                <tr>
                    <td>Rango final:</td>
                    <td><input type="text" id="max" name="max"></td>
                </tr>


            </tbody>
        </table>


        <table id="example" class="display nowrap" style="width:100%">


            <thead>
                <tr>
                    <th>NOMINA</th>
                    <th>NOMBRE</th>
                    <th>HORA ENTRADA</th>
                    <th>HORA SALIDA</th>
                    <th>HORA BREAK</th>
                    <th>FIN BREAK </th>
                    <th>ENTRADA</th>
                    <th>FECHA REGISTRO</th>

                </tr>
            </thead>
         
            <tbody>

            <?php
            foreach($stmt as $row):?>
            <tr>
            <td><?=$row['nomina']?></td>
            <td><?=$row['name'].' '.$row['apellido_Paterno'].' '.$row['apellido_Materno']?></td>
            <td><?=substr($row['fecha_entrada'],10,15)?></td>
            <td><?=$row['hr_break']?></td>
            <td><?=$row['hr_break_fin']?></td>
            <td><?=substr($row['fecha_salida'],10,15)?></td>
            <td><?=$row['entrada']?></td>
            <td><?=$row['fecha_reg']?></td>

           
            <?php
            endforeach;
            ?>
        </tbody>

        </table>

    </div>



    <script>
    var minDate, maxDate;
    $.fn.dataTable.ext.search.push(

        function(settings, data, dataIndex) {
            var min = minDate.val();
            var max = maxDate.val();
            var date = new Date(data[7]);

            if (
                (min === null && max === null) ||
                (min === null && date <= max) ||
                (min <= date && max === null) ||
                (min <= date && date <= max)
            ) {
                return true;
            }
            return false;
        }

    );

    $(document).ready(function() {

        minDate = new DateTime($('#min'), {
        format: 'MMMM Do YYYY'
    });
    maxDate = new DateTime($('#max'), {
        format: 'MMMM Do YYYY'
    });
 
    // DataTables initialisation
    
    var table = $('#example').DataTable({
            scrollY: '200px',
            scrollCollapse: true,
            dom: 'Bfrtip',
            buttons: [
                'csv', 'excel'
            ],
           

        });
 
    // Refilter the table
    $('#min, #max').on('change', function () {
        table.draw();
    });



    });
    </script>
</body>
<script src="../../js/buscar_rango.js"></script>

</html>

<?php

}

else{
    header('Location:http://192.168.100.200:50/asistencias_empleados/');
}

?>

