<?php

// tabla de asistencias
session_start();

include_once "../../bd/conexion.php";
// include_once "nav.php";



if (!empty($_POST['fecha_inicio']) && !empty($_POST['seleccion'])) {

     // $consulta = $_POST['fecha_inicio'];
    $seleccion = $_POST['seleccion'];
    $newDate = date("d/m/Y", strtotime($_POST['fecha_inicio']));
    $_SESSION['fechaChida'] = $_POST['fecha_inicio'];
    $date = $_SESSION['fechaChida'];

    $sql1 = "SELECT * FROM listacontrol WHERE fecha='$date' and nomina_emp =1019 and company ='Administrativo'
    UNION ALL
    SELECT * FROM listacontrol WHERE fecha='$date' and nomina_emp =1026 and company ='Administrativo'";
    $query1 = $conn->prepare($sql1);
    $query1->execute();
    $numeroDeFilas = $query1->rowCount();

    $sql = "SELECT  e.id_empleado, e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, R.nomina, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e 
    INNER JOIN registro R ON e.nomina = R.nomina 
    INNER JOIN turno t ON t.id_turno = e.id_turno_F 
    INNER JOIN company c ON c.id_company = e.id_company_F 
    WHERE R.fecha_hora LIKE '%$newDate%' AND e.nomina = '1019' AND c.descripcion='$seleccion' AND estatus=1
    
    UNION ALL
    
    SELECT  e.id_empleado, e.nomina, e.name, e.apellido_Paterno, e.apellido_Materno, R.fecha_hora, R.nomina, t.entrada AS nominar, t.id_turno, t.turno, t.entrada, t.salida, c.descripcion FROM empleado e 
    INNER JOIN registro R ON e.nomina = R.nomina 
    INNER JOIN turno t ON t.id_turno = e.id_turno_F 
    INNER JOIN company c ON c.id_company = e.id_company_F 
    WHERE R.fecha_hora LIKE '%$newDate%' AND e.nomina = '1026' AND c.descripcion='$seleccion' AND estatus=1";
    $query = $conn->prepare($sql);
    $query->execute();

    if ($numeroDeFilas > 0) {
        $_SESSION['lista'] = "Pase de lista ya realizado con anterioridad";
        header("Location:http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/consulta_diaespecifico.php");
      }
      else{

?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Asistencias</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
        <link rel="icon" href="https://oek.com.mx/wp-content/uploads/2022/01/cropped-OEK-favicon-32x32.png">

        <link href="../../style/mi.css" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    </head>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container-fluid">

            <img src="../../img/logo2.gif" class="logow">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <!-- <a class="nav-link active" aria-current="page" href="../index.php">Inicio</a> -->
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Asistencias
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="consulta_diaespecifico.php">Pase de lista</a></li>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Alta de Permisos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="permutas.php">Permutas<a></li>
                            <li><a class="dropdown-item" href="permisos.php">Permiso laboral</a></li>
                            <!-- <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li> -->
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Ver Permisos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="permutasreg.php">Permutas registradas<a></li>
                            <li><a class="dropdown-item" href="permisosreg.php">Permisos registrados</a></li>

                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Control de asistencias
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="lista.php">Asistencias (HSBC-Movistar)<a></li>
                        <li><a class="dropdown-item" href="listaDia.php">Asistencias por nomina (Administativos)<a></li>
                        <li><a class="dropdown-item" href="lista.php">Asistencias (Administrativos)<a></li>
                        </ul>
                    </li>
                    <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Pemisos Autorizados
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="permutasregAuto.php">Permutas <a></li>
                        <li><a class="dropdown-item" href="permisosregAuto.php">Permisos    </a></li>
                    </ul>
                </li> -->
                    <div class="position-absolute top-0 end-0">

                        <div class="text-end p-4">
                        <p class="nameNav"> <i class="fa fa-user m-3" style="font-size: 20px;"></i>JOSE MAURICIO CASTILLO MENDEZ</p>          

                        <a href="../../login/cerrar_sesion.php">  <i class="fa-solid fa-right-from-bracket"></i> Cerra sesión</a>
                        </div>


                    </div>

                </ul>
            </div>
        </div>
    </nav>



    <body>
    <?php
        if (isset($_SESSION['lista'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $_SESSION['lista'] ?></strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php
            session_unset();
        endif ?>

        <h5 class="text-center">Tabla de ASISTENCIAS</h5>

        <form action="as.php" method="post">
            <div class="container-fluid h-100">
                <div class="row w-100 align-items-center">
                    <div class="col text-center">
                        <button class="btn btn-success mt-5 mb-2"> Confirmar pase de lista</button>
                        <a href="consulta_diaespecifico.php" class="btn btn-warning mt-5 mb-2"> Regresar</a>
                        
                    </div>
                    
                </div>
                <div class="mb-3 col-md-12" id="div2">
                    <table class="table tableAs">


                        <thead class="" style="position: sticky;top: 0;">
                            <tr style="background:#2A4163;">
                                <th>NOMINA</th>
                                <th>NOMBRE</th>
                                <th>COMPAÑIA</th>
                                <th>FECHA</th>
                                <th class="text-center">REGISTRO <br> ENTRADAS- SALIDAS</th>
                                <th class="text-center">ESTATUS</th>
                                <th>HORARIOS <br> CORRECTOS</th>
                                <th>LISTA</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php

                            foreach ($query as $row) :

                                if (intval(str_replace(":", '', substr($row['fecha_hora'], -6))) <= intval(str_replace(":", '', $row['entrada']))) : ?>
                                    <tr data-key="<?= $row['nomina'] ?>">
                                        <td><input type="number" value="<?= $row['nomina'] ?>" name="id[]"></td>
                                        <td><?= $row['name'] . ' ' . $row['apellido_Paterno'] . ' ' . $row['apellido_Materno'] ?></td>
                                        <td><input type="text" value="<?= $row['descripcion'] ?>" name="desc[]"></td>
                                        <td><input type="text" value="<?= substr($row['fecha_hora'], 0, 10) ?>" name="fech"></td>
                                        <td class='text-center' style='background-color: #0D5982; color:white; font-weight: bold;'><?= substr($row['fecha_hora'], -6) ?></td>
                                        <td style='background-color: #0D5982; color:white; font-weight: bold;'> ASISTENCIAS</td>
                                        <td><?= $row['entrada'] ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" required name="control[]">
                                                    <option selected value="A">A</option>
                                                    <option value="R">R</option>
                                                    <option value="F">F</option>
                                                    <option value="SA">SA</option>
                                                    <option value="S">S</option>
                                                    <option value="0">Sin valor</option>

                                                </select>

                                            </div>
                                        </td>
                                    </tr>
                                <?php

                                elseif (intval(str_replace(":", '', substr($row['fecha_hora'], -6))) >= intval(str_replace(":", '', $row['salida']))) : ?>
                                    <tr data-key="<?= $row['nomina'] ?>">
                                        <td><input type="number" value="<?= $row['nomina'] ?>" name="id[]"></td>
                                        <td><?= $row['name'] . ' ' . $row['apellido_Paterno'] . ' ' . $row['apellido_Materno'] ?></td>
                                        <td><input type="text" value="<?= $row['descripcion'] ?>" name="desc[]"></td>
                                        <td><input type="text" value="<?= (substr($row['fecha_hora'], 0, 10)) ?>" name="fech"></td>
                                        <td class='text-center' style='background-color: #36941B ; color:white; font-weight: bold;'><?= substr($row['fecha_hora'], -6) ?></td>
                                        <td style='background-color: #36941B ; color:white; font-weight: bold;'> SALIDA</td>
                                        <td><?= $row['salida'] ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" required name="control[]">
                                                    <option selected value="S">S</option>
                                                    <option value="R">R</option>
                                                    <option value="F">F</option>
                                                    <option value="SA">SA</option>
                                                    <option value="A">A</option>
                                                    <option value="0">Sin valor</option>

                                                </select>

                                            </div>
                                        </td>
                                    </tr>

                                <?php
                                elseif (intval(str_replace(":", '', substr($row['fecha_hora'], -6))) <= intval(str_replace(":", '', $row['entrada'])) + 5) : ?>
                                    <tr data-key="<?= $row['nomina'] ?>">
                                        <td><input type="number" value="<?= $row['nomina'] ?>" name="id[]"></td>
                                        <td><?= $row['name'] . ' ' . $row['apellido_Paterno'] . ' ' . $row['apellido_Materno'] ?></td>
                                        <td><input type="text" value="<?= $row['descripcion'] ?>" name="desc[]"></td>
                                        <td><input type="text" value="<?= (substr($row['fecha_hora'], 0, 10)) ?>" name="fech"></td>
                                        <td class='text-center' style='background-color: #CD6D00; color:white; font-weight: bold;'><?= substr($row['fecha_hora'], -6) ?></td>
                                        <td style='background-color: #CD6D00; color:white; font-weight: bold;'> RETARDO</td>
                                        <td><?= $row['entrada'] ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" required name="control[]">
                                                    <option selected value="R">R</option>
                                                    <option value="A">A</option>
                                                    <option value="F">F</option>
                                                    <option value="SA">SA</option>
                                                    <option value="S">S</option>
                                                    <option value="0">Sin valor</option>

                                                </select>

                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                elseif (intval(str_replace(":", '', substr($row['fecha_hora'], -6))) >= intval(str_replace(":", '', $row['entrada'])) + 6 && intval(str_replace(":", '', substr($row['fecha_hora'], -6))) <= intval(str_replace(":", '', $row['entrada'])) + 100) : ?>
                                    <tr data-key="<?= $row['nomina'] ?>">
                                        <td><input type="number" value="<?= $row['nomina'] ?>" name="id[]"></td>
                                        <td><?= $row['name'] . ' ' . $row['apellido_Paterno'] . ' ' . $row['apellido_Materno'] ?></td>
                                        <td><input type="text" value="<?= $row['descripcion'] ?>" name="desc[]"></td>
                                        <td><input type="text" value="<?= (substr($row['fecha_hora'], 0, 10)) ?>" name="fech"></td>
                                        <td class='text-center' style='background-color: #E0F113; color:black; font-weight: bold;'><?= substr($row['fecha_hora'], -6) ?></td>
                                        <td style='background-color: #E0F113; color:black; font-weight: bold;'>FALTA POR RETARDO</td>
                                        <td><?= $row['entrada'] ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" required name="control[]">
                                                    <option selected value="F">F</option>
                                                    <option value="R">R</option>
                                                    <option value="A">A</option>
                                                    <option value="SA">SA</option>
                                                    <option value="S">S</option>
                                                    <option value="0">Sin valor</option>

                                                </select>

                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                elseif (intval(str_replace(":", '', substr($row['fecha_hora'], -6))) <= intval(str_replace(":", '', $row['entrada'])) + 230) : ?>
                                    <tr data-key="<?= $row['nomina'] ?>">
                                        <td><input type="number" value="<?= $row['nomina'] ?>" name="id[]"></td>
                                        <td><?= $row['name'] . ' ' . $row['apellido_Paterno'] . ' ' . $row['apellido_Materno'] ?></td>
                                        <td><input type="text" value="<?= $row['descripcion'] ?>" name="desc[]"></td>
                                        <td><input type="text" value="<?= (substr($row['fecha_hora'], 0, 10)) ?>" name="fech"></td>
                                        <td class='text-center' style='background-color: purple; color:white; font-weight: bold;'><?= substr($row['fecha_hora'], -6) ?></td>
                                        <td style='background-color: purple; color:white; font-weight: bold; font-size:14px'>entrada dist</td>
                                        <td><?= $row['entrada'] . ' ' . $row['salida'] ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" required name="control[]">
                                                    <option selected="A">A</option>
                                                    <option value="R">R</option>
                                                    <option value="F">F</option>
                                                    <option value="SA">SA</option>
                                                    <option value="S">S</option>
                                                    <option value="0">Sin valor</option>

                                                </select>

                                            </div>
                                        </td>
                                    </tr>

                                <?php
                                elseif (intval(str_replace(":", '', substr($row['fecha_hora'], -6))) < intval(str_replace(":", '', $row['salida']))) : ?>
                                    <tr data-key="<?= $row['nomina'] ?>">
                                        <td><input type="number" value="<?= $row['nomina'] ?>" name="id[]"></td>
                                        <td><?= $row['name'] . ' ' . $row['apellido_Paterno'] . ' ' . $row['apellido_Materno'] ?></td>
                                        <td><input type="text" value="<?= $row['descripcion'] ?>" name="desc[]"></td>
                                        <td><input type="text" value="<?= (substr($row['fecha_hora'], 0, 10)) ?>" name="fech"></td>
                                        <td class='text-center' style='background-color: #F30E0E; color:white; font-weight: bold;'><?= substr($row['fecha_hora'], -6) ?></td>
                                        <td style='background-color: #F30E0E; color:white; font-weight: bold; font-size:14px'>SALIDA ANTICIPADA</td>
                                        <td><?= $row['salida'] ?></td>
                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" required name="control[]">
                                                    <option selected value="SA">SA</option>
                                                    <option value="R">R</option>
                                                    <option value="F">F</option>
                                                    <option value="A">A</option>
                                                    <option value="S">S</option>
                                                    <option value="0">Sin valor</option>

                                                </select>

                                            </div>
                                        </td>
                                    </tr>

                            <?php

                                endif;
                            endforeach;
                            ?>
                        </tbody>
                        <table>


                </div>
        </form>

    </body>

    </html>


<?php
      }
} else {

    header("Location: http://192.168.100.200:50/asistencias_empleados/vistas/sistemas/consulta_diaespecifico.php");
}
