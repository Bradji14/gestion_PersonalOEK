<?php
include ('nav.php');
include_once "../../bd/conexion.php";


$sql="SELECT * FROM area;";
$query = $conn->prepare($sql);
$query->execute();


?>

<body>



    <div class="container p-4 ">

        <div class="row">
            <div class="col-md-4 mx-auto">
                
                <div class="card card-body formbody">
                    <div class="pform">
                    <p class="text-center">Permisos laborales</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <div class="cargando spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <?php
                if(isset($_SESSION['vacio'])):?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?=$_SESSION['vacio']?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                session_unset();
                endif?>

                    <?php
                if(isset($_SESSION['nomina'])):?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><?=$_SESSION['nomina']?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                session_unset();
                endif?>
                    <?php
                if(isset($_SESSION['listo']) && isset($_SESSION['name'])):?>
                    <script>
                    $.alert({
                        title: '<?=$_SESSION['name']?>',
                        content: 'Permiso agregado',
                        icon: 'fa fa-circle-check',
                        theme: 'modern',
                        type: 'blue',
                    });
                    </script>
                    <?php
                session_unset();
                endif?>


                    <form action="../consultas/permisobusqsist.php" method="POST" class="forName" autocomplete="off" novalidate>

                        <div class="form-group">
                            <label for="empleado" class="form-label" id="nameEmpleado">Nomina empleado</label>
                            <input type="number" class="form-control" name="empleado" required id="nomi"
                                onblur="buscar_datos();" style="background:white;  color:black;">
                        </div>

                        <div class="row dates">

                            <!-- <div class="parra">
                                <p class="text-center">Datos del empleado</p>
                            </div> -->

                            <div class="col-md-6 date1">
                                <label class="text-center">Nombre:</label>
                                <input type="text" class="form-control" id="nameper1" disabled>
                                <!-- <p id="nameper1">Nombre: </p> <span id="turnoperm1">Turno: </span> -->
                            </div>

                            <div class="col-md-6 date1">
                                <label class="text-center">Turno:</label>
                                <input type="text" class="form-control" id="turnoperm1" disabled>
                            </div>
                            <div class="col-md-6 date1">

                                <input type="text" class="form-control" id="company" name="compa" style="display:none">
                            </div>


                        </div>

                        <div class="form-group">
                            <label class="formn-label">Area</label>
                            <select class="form-control" required name="area">
                                <option selected>Seleccione una opcion...</option>
                                <?php
                            foreach($query as $row)
                            {
                                ?>
                                <option value="<?=$row['id_area']?>"> <?=$row['descripcion']?> </option>
                                <?php
                            }?>

                            </select>

                        </div>
                        <div class="form-group">
                            <label class="formn-label">Jefe inmediato</label>
                            <select class="form-control" required name="jefe">
                                <option selected>Seleccione una opcion...</option>
                                <?php
                            $sql2="SELECT * FROM jefes_empresa;";
                            $query2 = $conn->prepare($sql2);
                            $query2->execute();
                            
                            
                            foreach($query2 as $row)
                            {
                                ?>
                                <option value="<?=$row['id']?>"><?=$row['nombre'].' '.$row['apellidos']?> </option>

                                <?php
                            }?>

                            </select>

                        </div>
                        <div class="form-group">
                            <label for="motivo">Motivo permiso</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="motivo"
                                required></textarea>
                            <!-- <input type="text" class="form-control" name="motivo" id="motivo"> -->
                            <!-- <div class="invalid-feedback">Ingrese motivo</div> -->

                        </div>

                        <!-- <br> -->
                        <label>Tiempo solicitado</label>
                        <div class="input-group">


                            <input type="number" placeholder="Ingrese cantidad" class="form-control" required
                                name="numbers"  style="background:white; color:black">
                            <span class="input-group-addon">-</span>
                            <select class="form-control" required name="options">
                                <option selected>Seleccione una opcion...</option>
                                <option value="Dia(s)">Dia(s)</option>
                                <option value="Hora(s)">Hora(s)</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="dateP">Fecha para permiso</label>
                            <input type="date" class="form-control" name="dateP" id="dateP" required>
                            <!-- <div class="invalid-feedback">Ingrese fecha</div> -->

                        </div>

                        <br>
                        <button type="submit" class="btn btp" name="save">Guardar</button>
                    </form>
                </div>
            </div>

        </div>
        <script>
        $(document).ready(function() {
            $('.cargando').hide();
            $('.parra').hide();
            $('.date1').hide();

            // var inival = $("#nomi").val();
            // $("#nomi").change(function() {
            //     if ($("#nomi").val() != inival) {
            //         $('#nameper1').text('');
            //         $('#nameper1').append('Nombre: ');
            //         $('#turnoperm1').text('')
            //         $('#turnoperm1').append('Turno: ')
            //     }
            // });
        })

        function buscar_datos() {

            var doc = $('#nomi').val();

            var params = {
                'buscar': 1,
                'doc': doc,
            };

            $.ajax({
                url: '../consultas/permisos_search.php',
                method: 'POST',
                dataType: 'JSON',
                data: params,
                beforeSend: function() {
                    $('.forName').hide();
                    $('.cargando').show();
                },
                complete: function() {
                    $('.forName').show();
                    $('.cargando').hide();

                },
                success: function(data) {


                    if (data) {
                        $('.date1').show();
                        $('.parra').show()
                        $('#nameper1').val(data.name);
                        $('#turnoperm1').val(data.turno_F)
                        $('#company').val(data.compa)
                    }
                }


            }).done(function() {
                console.log('Loading data...')
            })
        }
        </script>
</body>

</html>