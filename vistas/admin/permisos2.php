<body>
    <?php

include ('nav.php');
include_once "../../bd/conexion.php";
    $sql2= "SELECT  e.name, p.id_jefe, e.nomina,j.nombre,j.apellidos,j.id, e.apellido_Paterno,e.apellido_Materno,p.company,p.id_permiso, p.fechaPermiso, p.motivo, p.tiempo_solicitado, c.descripcion from empleado e  INNER JOIN permisos p ON e.nomina = p.id_nomina INNER JOIN company c ON e.id_company_F=c.id_company INNER JOIN jefes_empresa j ON p.id_jefe= j.id WHERE p.estatus=0";
    $query2 = $conn->prepare($sql2);
    $query2->execute();
    $numeroDeFilas = $query2->rowCount();

    $sql3= "SELECT  e.name, p.id_jefe, e.nomina,j.nombre,j.apellidos,j.id, e.apellido_Paterno,e.apellido_Materno,p.company,p.id_permiso, p.fechaPermiso, p.motivo, p.tiempo_solicitado, c.descripcion from empleado e  INNER JOIN permisos p ON e.nomina = p.id_nomina INNER JOIN company c ON e.id_company_F=c.id_company INNER JOIN jefes_empresa j ON p.id_jefe= j.id WHERE p.estatus=1";
    $query3 = $conn->prepare($sql3);
    $query3->execute();
    $numeroDeFilas3 = $query3->rowCount();

    $sql1= "SELECT  e.name, p.id_jefe, e.nomina,j.nombre,j.apellidos,j.id, e.apellido_Paterno,e.apellido_Materno,p.company,p.id_permiso, p.fechaPermiso, p.motivo, p.tiempo_solicitado, c.descripcion from empleado e  INNER JOIN permisos p ON e.nomina = p.id_nomina INNER JOIN company c ON e.id_company_F=c.id_company INNER JOIN jefes_empresa j ON p.id_jefe= j.id WHERE p.estatus=2";
    $query1 = $conn->prepare($sql1);
    $query1->execute();
    $numeroDeFilas1 = $query1->rowCount();

?>

    <div class="container-fluid mb-5">


        <div class="wrap mt-5 shadow p-3 mb-5 bg-body rounded">
            <ul class="tabs">

                <li><a href="#tab1"><i class="fa-solid fa-file-circle-exclamation" style="font-size:20px"></i><span
                            class="tab-text">PERMISOS</span></a></li>
                <li><a href="#tab2"><i class="fa-solid fa-file-circle-check" style="font-size:20px"></i></i><span class="tab-text">PERMISOS
                            ACEPTADOS</span></a></li>
                <li><a href="#tab3"><i class="fa-solid fa-file-circle-xmark" style="font-size:20px"></i></i><span class="tab-text">PERMISOS
                            RECHAZADOS</span></a></li>

            </ul>

            <div class="secciones ">


                <article id="tab1">

                    <div id="div3" class="mt-4">
                        <?php

                        if($numeroDeFilas > 0):?>
                        <form action="checkPerms.php" method="post">


                            <table id="example" class="stripe row-border order-column nth-table1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="display:none">ID PERMISO</th>
                                        <th class="text-center">NOMINA <br>EMPLEADO</th>
                                        <th class="text-center">NOMBRE <br> EMPLEADO</th>
                                        <th class="text-center">COMPAÑIA</th>
                                        <th class="text-center">JEFE INMEDIATO</th>
                                        <th class="text-center">TIEMPO SOLICITADO</th>
                                        <th class="text-center">MOTIVO</th>
                                        <th class="text-center">FECHA PERMISO</th>
                                        <th class="text-center">CHECK</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                foreach($query2 as $row):?>
                                    <tr>

                                        <td style="display:none"><input type="text" value="<?=$row['id_permiso']?>"
                                                name="id[]"></td>
                                        <td><?=$row['nomina']?></td>
                                        <td><?= $row['name'] .' '.$row['apellido_Paterno'].' '.$row['apellido_Materno']?>
                                        </td>
                                        <td><?=$row['company']?></td>
                                        <td><?=$row['nombre'].' '.$row['apellidos']?></td>
                                        <td><?=$row['tiempo_solicitado']?></td>
                                        <td>
                                            <div style='height:100px; overflow-y:scroll; text-align:left;'>
                                                <?=$row['motivo']?></div>
                                        </td>
                                        <td><?=$row['fechaPermiso']?></td>

                                        <td>
                                            <div class="form-group">
                                                <select class="form-control" required name="control[]" style="font-size: 12px">

                                                    <option value="1">Aceptar</option>
                                                    <option value="2">Rechazar</option>

                                                </select>

                                            </div>
                                        </td>


                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                                </tbody>

                            </table>

                            <?php
                            endif;
                            ?>
                            <div class="row w-100 align-items-center">
                                <div class="col text-center">
                                    <button class="btn btn-outline-success mt-5 mb-2">Finalizado</button>

                                </div>
                            </div>
                        </form>

                    </div>


                </article>


                <article id="tab2">



                    <div id="div3" class="mt-4">
                        <?php

                        if($numeroDeFilas3 > 0):?>



                        <table id="example2" class="stripe row-border order-column nth-table1" style="width:100%">
                            <thead>
                                <tr>

                                    <th class="text-center">NOMINA <br>EMPLEADO</th>
                                    <th class="text-center">NOMBRE <br> EMPLEADO</th>
                                    <th class="text-center">COMPAÑIA</th>
                                    <th class="text-center">JEFE INMEDIATO</th>
                                    <th class="text-center">TIEMPO SOLICITADO</th>
                                    <th class="text-center">MOTIVO</th>
                                    <th class="text-center">FECHA PERMISO</th>
                                    <th class="text-center">ESTATUS</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($query3 as $row):?>
                                <tr>


                                    <td><?=$row['nomina']?></td>
                                    <td><?= $row['name'] .' '.$row['apellido_Paterno'].' '.$row['apellido_Materno']?>
                                    </td>
                                    <td><?=$row['company']?></td>
                                    <td><?=$row['nombre'].' '.$row['apellidos']?></td>
                                    <td><?=$row['tiempo_solicitado']?></td>
                                    <td>
                                        <div style='height:100px; overflow-y:scroll; text-align:left;'>
                                            <?=$row['motivo']?></div>
                                    </td>
                                    <td><?=$row['fechaPermiso']?></td>
                                    <td><i class="fa-solid fa-check" style="font-size:20px; background:green;padding:2px"></i></td


                                </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>

                        </table>

                        <?php
                            endif;
                            ?>



                    </div>




                </article>

                <article id="tab3">



                    <div id="div3" class="mt-4">
                        <?php

                        if($numeroDeFilas1 > 0):?>



                        <table id="example3" class="stripe row-border order-column nth-table1" style="width:100%">
                            <thead>
                                <tr>

                                    <th class="text-center">NOMINA <br>EMPLEADO</th>
                                    <th class="text-center">NOMBRE <br> EMPLEADO</th>
                                    <th class="text-center">COMPAÑIA</th>
                                    <th class="text-center">JEFE INMEDIATO</th>
                                    <th class="text-center">TIEMPO SOLICITADO</th>
                                    <th class="text-center">MOTIVO</th>
                                    <th class="text-center">FECHA PERMISO</th>
                                    <th class="text-center">ESTATUS</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach($query1 as $row):?>
                                <tr>


                                    <td><?=$row['nomina']?></td>
                                    <td><?= $row['name'] .' '.$row['apellido_Paterno'].' '.$row['apellido_Materno']?>
                                    </td>
                                    <td><?=$row['company']?></td>
                                    <td><?=$row['nombre'].' '.$row['apellidos']?></td>
                                    <td><?=$row['tiempo_solicitado']?></td>
                                    <td>
                                        <div style='height:100px; overflow-y:scroll; text-align:left;'>
                                            <?=$row['motivo']?></div>
                                    </td>
                                    <td><?=$row['fechaPermiso']?></td>
                                    <td><i class="fa-solid fa-x" style="font-size:20px; background:red; padding:2px"></i></td>


                                </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>

                        </table>

                        <?php
                            endif;
                            ?>



                    </div>

                </article>

            </div>
        </div>





    </div>

    <script>
    $(document).ready(function() {
        $('#example').DataTable({

            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            // paging: false,
            columnDefs: [{
                width: 200,
                targets: 0
            }],
            fixedColumns: true,
        });

        $('#example2').DataTable({

            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            // paging: false,
            columnDefs: [{
                width: 200,
                targets: 0
            }],
            fixedColumns: true,
        });

        $('#example3').DataTable({

            scrollY: "300px",
            scrollX: true,
            scrollCollapse: true,
            // paging: false,
            columnDefs: [{
                width: 200,
                targets: 0
            }],
            fixedColumns: true,
        });


        $('ul.tabs li a:first').addClass('active');
        $('.secciones article').hide();
        $('.secciones article:first').show();

        $('ul.tabs li a').click(function() {
            $('ul.tabs li a').removeClass('active');
            $(this).addClass('active');
            $('.secciones article').hide();

            var activeTab = $(this).attr('href');
            $(activeTab).show();
            return false;
        });

    });
    </script>

    <script src="../../js/buscar.js"></script>


</body>

</html>