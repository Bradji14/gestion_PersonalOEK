<body>
    <?php

include ('nav.php');
include_once "../../bd/conexion.php";

  $sql3="SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.company,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerE INNER JOIN turno t ON p.id_turno_cambio=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE  p.company ='HSBC'  UNION ALL SELECT e.nomina, e.name,e.apellido_Paterno,e.apellido_Materno,p.company,p.motivoPermuta,p.id_permuta,p.fecha_permuta,t.entrada,t.salida,c.descripcion FROM empleado e INNER JOIN permutas p ON e.nomina=p.nomina_primerS INNER JOIN turno t ON p.id_turno_cambio2=t.id_turno INNER JOIN company c ON p.company =c.descripcion WHERE  p.company ='HSBC'  ORDER BY id_permuta ";
  $query3 = $conn->prepare($sql3);
  $query3->execute();
  $numeroDeFilas3 = $query3->rowCount();

  
?>

    <div class="container-fluid mb-5">


        <div class="wrap mt-5 shadow p-3 mb-5 bg-body rounded">



            <div id="div3" class="mt-4">

                <div class="col-md-12 mt-5 d-flex justify-content-around">

                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            color="#284455" class="bi bi-circle-fill" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="8" />
                        </svg> Permutante 1
                    </p>
                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            color="#50a5d6" class="bi bi-circle-fill" viewBox="0 0 16 16">
                            <circle cx="8" cy="8" r="8" />
                        </svg> Permutante 2
                    </p>

                </div>
                <?php

                        if($numeroDeFilas3 > 0):?>

                <table id="example" class="stripe row-border order-column nth-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">NOMINA</th>
                            <th class="text-center">NOMBRE <br>COMPLETO</th>
                            <th class="text-center">ENTRADA PERMUTADA</th>
                            <th class="text-center">SALIDA PERMUTADA</th>
                            <th class="text-center">MOTIVO</th>
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
                

            </div>


            </article>





        </div>
    </div>





    </div>

    <script>
    $(document).ready(function() {
        $('#example').DataTable({

            ordering: false,
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