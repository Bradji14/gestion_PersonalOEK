<body>
    <?php

include ('nav.php');
include_once "../../bd/conexion.php";

$sql = "  SELECT nomina_emp,company, GROUP_CONCAT(count ORDER BY pase ASC SEPARATOR ', ' ) AS 'asd' FROM (SELECT nomina_emp, pase,company, CONCAT(pase, count(nomina_emp)) AS count FROM listacontrol l GROUP BY pase, nomina_emp) A GROUP BY nomina_emp  ORDER BY nomina_emp;";
$query = $conn->prepare($sql);
$query->execute();

$numeroDeFilas = $query->rowCount();


?>

    <div class="container-fluid mb-5">


        <div class="wrap mt-5 shadow p-3 mb-5 bg-body rounded">


            <div id="div3" class="mt-4">
                <?php

                        if($numeroDeFilas > 0):?>

                <table id="example" class="display nowrap nth-table" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">NOMINA EMPLEADO</th>
                            <th class="text-center">CAMPAÑA</th>
                            <th class="text-center">TOTAL</th>
          
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                foreach($query as $row):?>
                        <tr>
                            <td class="text-center"><?=$row['nomina_emp']?></td>

                            <td class="text-center"><?=$row['company']?></td>

                            <td class="text-center"><?=$row['asd']?></td>

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
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
        </script>

        <script src="../../js/buscar.js"></script>


</body>

</html>