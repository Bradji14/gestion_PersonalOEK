<body>
    <?php

include ('nav.php');
include_once "../../bd/conexion.php";

  $sql3="SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.company,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerE INNER JOIN turno t ON p.id_turno_cambio=t.id_turno INNER JOIN company c ON p.company =c.descripcion  UNION ALL SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.company,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerS INNER JOIN turno t ON p.id_turno_cambio2=t.id_turno INNER JOIN company c ON p.company =c.descripcion ORDER BY id_permuta ";
  $query3 = $conn->prepare($sql3);
  $query3->execute();
  $numeroDeFilas3 = $query3->rowCount();

  
?>

    <div class="container-fluid mb-5">


        <div class="wrap mt-5 shadow p-3 mb-5 bg-body rounded">



            <div id="div3" class="mt-4">
                <?php

                        if($numeroDeFilas3 > 0):?>

                    <table id="example" class="stripe row-border order-column nth-table" style="width:100%">
                        <thead>
                            <tr>

                                <th>NOMINA</th>
                                <th>NOMBRE <br>COMPLETO</th>
                                <th>ENTRADA PERMUTADA</th>
                                <th>SALIDA PERMUTADA</th>
                                <th>MOTIVO</th>                       

                                <th>FECHA PERMUTA</th>
                                <th>CAMPAÑA</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                foreach($query3 as $row):?>
                            <tr>

                                <td><?=$row['nomina']?></td>
                                <td><?= $row['name'] .' '.$row['apellido_Paterno'].' '.$row['apellido_Materno']?></td>
                                
                                <td><?=$row['entrada']?></td>
                                <td><?=$row['salida']?></td>
                                <td>
                                    <div style='height:100px; overflow-y:scroll; text-align:left;'>
                                        <?=$row['motivoPermuta']?></div>
                                </td>
                                <td><?=$row['fecha_permuta']?></td>
                                <td><?=$row['company']?></td>


                          


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

            </div>


            </article>





        </div>
    </div>





    </div>

    <script>
    $(document).ready(function() {
        $('#example').DataTable({
            ordering: false,
        info: false,
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