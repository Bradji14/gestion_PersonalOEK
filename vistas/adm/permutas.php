<?php
//  session_start();

include ('nav.php');

include_once "../../bd/conexion.php";

$sql="SELECT * FROM turno;";
$query = $conn->prepare($sql);
$query->execute();
?>

<body>


    <div class="container p-4 ">

        <div class="row">


            <div class="col-md-4 mx-auto ">
                <div class="card card-body formbody">
                    <div class="pform">
                    <p class="text-center">Permutas laborales</p>
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="cargando spinner-border" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <?php
                if(isset($_SESSION['nomina'])):?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?=$_SESSION['nomina']?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                session_unset();
                endif?>

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
                if(isset($_SESSION['nominaR'])):?>
                    <div class="alert alert-primary alert-dismissible fade show" role="alert">
                        <strong><?=$_SESSION['nominaR']?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php
                session_unset();
                endif?>
                
                 <?php
                if(isset($_SESSION['listo'])):?>
                    <script>
                    $.alert({
                        title: '<?=$_SESSION['listo']?>',
                        content: 'Permuta guardada',
                        icon: 'fa fa-circle-check',
                        theme: 'modern',
                        type: 'blue',
                    });
                    </script>
                    <?php
                session_unset();
                endif?>




                    <form method="POST" action="../consultas/permutasbusq.php" class="forName "autocomplete="off" novalidate>
                        
                        <label>Ingrese nominas:</label>
                        <div class="input-group">
                            <input id="df" type="number" required class="form-control" placeholder="permutante 1"
                                name="nom1" onblur="buscar_datos();" style="background:white; color:black"> <span class="input-group-addon" >-</span>
                            <input id="dq" type="number" required class="form-control" placeholder="permutante 2"
                                name="nom2" onblur="buscar_datos2();" style="background:white; color:black">
                        </div>

                        <br>


                        <div class="row dates">
                            <div class="parra">
                                <p class="text-center text-light">Datos de los permutantes:</p>
                            </div>

                            <div class="col-md-6 date1">
                                <label>Nombre:</label>
                                <input type="text" class="form-control" id="nameper1" disabled>

                                <label>Turno:</label>
                                <input type="text" class="form-control" id="turnoperm1" disabled>

                                <label>Nombre:</label>
                                <input type="text" class="form-control" id="compa" name="compa" style="display: none;">
                               
                            </div>

                            <div class="col-md-6 date2">
                                <label>Nombre:</label>
                                <input type="text" class="form-control" id="nameper2" disabled>

                                <label>Turno:</label>
                                <input type="text" class="form-control" id="turnoperm2" disabled>
                              
                            </div>

                        </div>


                        <label class="">Turno permitido a cambiar:</label>
                        <div class="input-group">
                            <select class="form-control" required name="turnoreq1" id="pru">
                                <!-- <option selected>Seleccione una opcion...</option> -->
                            </select>
                            <span class="input-group-addon">-</span>
                            <select class="form-control" required name="turnoreq2" id="pru2">
                                <!-- <option selected>Seleccione una opcion...</option> -->

                            </select>
                        </div>
                        <br>


                        <div class="form-group">
                            <label for="motivo">Motivo permiso</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" name="motivo"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="dateP">Fecha para permiso</label>
                            <input type="date" class="form-control" name="dateP" id="dateP" required>
                        
                        </div>

                        <br>
                        <button type="submit" class="btn btp save" name="save">Guardar</button>
                    </form>
                </div>
            </div>

        </div>
        <script>
        $(document).ready(function() {
            $('.cargando').hide();
            $('.date1').hide();
            $('.date2').hide();
            $('.parra').hide()

            // var inival = $("#df").val();
            // $("#df").change(function() {
            //     if ($("#df").val() != inival) {
            //         $('#nameper1').text('');
            //         $('#nameper1').append('Nombre: ');
            //         $('#turnoperm1').text('')
            //         $('#turnoperm1').append('Turno: ')
            //         $('#pru2').empty()
            //     }
            // });

            // var inival = $("#dq").val();
            // $("#dq").change(function() {
            //     if ($("#dq").val() != inival) {
            //         $('#nameper2').text('');
            //         $('#nameper2').append('Nombre: ');
            //         $('#turnoperm2').text('')
            //         $('#turnoperm2').append('Turno: ')
            //         $('#pru').empty()
            //     }
            // });

        })

        function buscar_datos() {

            var doc = $('#df').val();
            var po = $('#dq').val();
            // console.log(doc)

            var params = {
                'buscar': 1,
                'doc': doc,
                'po': po
            };

            $.ajax({
                url: '../consultas/prueba.php',
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
                        $('#compa').val(data.compa)
                        $('#pru2').append(`<option value="${data.id_turno_F}">${data.turno_F}</option>`)
                    }

                }

            })
        }

        function buscar_datos2() {

            var po = $('#dq').val();
            // console.log(doc)

            var params = {
                'buscar': 1,
                'po': po
            };

            $.ajax({
                url: '../consultas/prueba2.php',
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
                        $('.date2').show();
                        $('#nameper2').val(data.name)
                        $('#turnoperm2').val(data.turno)
                        // $('#compa').val(data.compa)

                        $('#pru').append(`<option value="${data.id_turno}">${data.turno}</option>`)
                    }


                }

            })
        }
        </script>

</body>

</html>