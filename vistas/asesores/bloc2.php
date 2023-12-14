<?php

session_start();
include_once "../../bd/conexion.php";

date_default_timezone_set('America/Mexico_City');
$mifecha = new DateTime(); 
// $mifecha->modify('-1 hours'); 
$date=$mifecha->format('Y-m-d H:i');
// echo $date;
// echo substr($date,0,10);
$datenow=substr($date,0,10);


$nomina= $_SESSION['nomina'];
$sqllo = "SELECT name,apellido_Paterno,apellido_Materno from empleado WHERE nomina='$nomina' ";
$query= $conn->prepare($sqllo);
$query->execute();
$numeroDeFilas5 = $query->rowCount();


$sqlp = "SELECT * from pase WHERE nomina='$nomina' AND fecha_reg BETWEEN '2023-06-25' and '2023-07-31' and status=1 ORDER BY fecha_reg ";
$queryp= $conn->prepare($sqlp);
$queryp->execute();
$numeroDeFilas2 = $queryp->rowCount();




$sqlp1 = "SELECT * from pase WHERE nomina='$nomina' and fecha_reg LIKE '%$datenow%' and status=0";
$queryp1= $conn->prepare($sqlp1);
$queryp1->execute();
$numeroDeFilast = $queryp1->rowCount();


foreach ($queryp1 as $row) {

    $hrentrada = $row['fecha_entrada'];
    $brei=$row['hr_break'];
    $bref=$row['hr_break_fin'];

}

// en caso de que ya halla registro de break inicial


if(isset($_SESSION['nomina'])){

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Break|OEK</title>
    <link rel="stylesheet" href="../../style/mi.css">
    <link rel="stylesheet" href="../../style/clock.css">

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


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous">
    </script>



    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>

            .containert span {
            font-size: 40px;
            font-weight: bold;
            position: relative;
            font-family: "Fredoka One";
            cursor: pointer;
            transition: all 300ms ease-in-out;
            }
            .containert span::before {
            content: var(--l);
            position: absolute;
            transform: scale(1.1);
            filter: blur(15px);
            }
            .containert span::after {
            content: var(--l);
            position: absolute;
            height: 200%;
            width: 300px;
            top: 80%;
            left: 0;
            filter: blur(30px);
            transform: rotateX(50deg);
            }
            .containert span:hover {
            filter: contrast(250%);
            }
            .containert span:nth-child(1) {
            color: #00bef8;
            }
            .containert span:nth-child(2) {
            color: #19A9C2;/*name */
            }
            .containert span:nth-child(3) {
            color: #1EB7D1;
            }
            .containert span:nth-child(4) {
            color: #57A9B8;
            }
            .containert h3{
                color:white;
            }
            .button{
                position:relative;
                display:inline-block;
                margin:20px;
                }

                .button a{
                color:white;
                font-family:Helvetica, sans-serif;
                font-weight:bold;
                font-size:36px;
                text-align: center;
                text-decoration:none;
                background-color:#FFA12B;
                display:block;
                position:relative;
                padding:20px 40px;
                
                -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
                text-shadow: 0px 1px 0px #000;
                filter: dropshadow(color=#000, offx=0px, offy=1px);
                
                -webkit-box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
                -moz-box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
                box-shadow:inset 0 1px 0 #FFE5C4, 0 10px 0 #915100;
                
                -webkit-border-radius: 5px;
                -moz-border-radius: 5px;
                border-radius: 5px;
                }

                .button a:active{
                top:10px;
                background-color:#F78900;
                
                -webkit-box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3px 0 #915100;
                -moz-box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3pxpx 0 #915100;
                box-shadow:inset 0 1px 0 #FFE5C4, inset 0 -3px 0 #915100;
                }



        </style>
    
</head>

<body>


    <?php
        foreach($query as $row){
            $name= $row['name'];
            $ap= $row['apellido_Paterno'];
            $am= $row['apellido_Materno'];

        }
     ?>

    <nav style="background:#7F1085">

        <div class="d-flex justify-content-around">

            <div>
                <img src="../../img/oek.png" style="width:250px;height:150px;padding:20px">
            </div>

            <div class="containert">
            <!-- <h3 class="text-center">Bienvenido (a) : </h3> -->
                <span style="color:#D2ADD4"><?=$name?></span>
                <span style="color:#D2ADD4"><?=$ap?></span>
                <span style="color:#D2ADD4"><?=$am?></span>
          
            </div>

            <div class="mt-5 text-light">
              

                
            </div>

            <div class="mt-5">
                <form action="saveSalida.php" method="post">
                    <button name="salida" class="button-52">Salida jornada</button>
                    <!-- <button name="turn" class="button-52">Segundo turno</button> -->

                  
                </form>
            </div>


        </div>

    </nav>


    <div class="m-5">

        <div class="d-flex justify-content-around m-5">

            <div class="hrs mt-5" style="background:#dd1f86;color:#D2ADD4;padding:20px;box-shadow: rgb(38, 57, 77) 0px 20px 30px -10px;border-radius:5px"></div>


            <div class=" justify-content-center">

            <div class="mt-5 bg-danger text-center p-2" style="font-size:25px;color:white">
            <p>Cierra la pestaña del checador antes de irte</p>
            </div>


                <div class="reloj m-2" style="background:#dd1f86;color:#d2add4;border-radius:10px">
                    <p class="fecha"></p>
                    <p class="tiempo"></p>
                </div>

                <div class="mt-5">
                    <form action="saveBreak.php" method="post">

                        <button name="inibre" class="submit mb-5">Inicio Break</button>
                        <button name="finbre" class="submits" style="display:none">Fin Break</button>

                    </form>
                </div>


            </div>

            <div class="mt-5">
                <table id="example" class="" style="width:230px;background:#fbeee0;color:#422800">

        <div class="d-flex justify-content-center p-2" style="background:#2196f3;color:white">

            <p style="font-size:15px" class="p-2">A-<span style="font-size:13px" ><strong> Asistencias </strong> </span> </p>
            <p style="font-size:15px" class="p-2">R-<span style="font-size:13px" ><strong> Retardos </strong> </span> </p>
            <p style="font-size:15px" class="p-2">F-<span style="font-size:13px"><strong> Faltas</strong> </span> </p>
          

        </div>


                    <thead style="background:#001322;color:white">
                        <tr>
                            <th>FECHA</th>
                            <th>ENTRADA</th>
                            <th style="display:none">FECHA</th>
                            <th style="display:none">FECHA</th>
                            <th style="display:none">FECHA</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        foreach($queryp as $rowl)
                        {
                            if($rowl['entrada']=="A")
                            {
                                ?>
                        <tr>
                            <td><?=$rowl['fecha_reg']?></td>
                            <td style="background:#ADE278;color:white;cursor:pointer"><?=$rowl['entrada']?></td>
                            <td style="display:none"><?=$rowl['fecha_entrada']?></td>
                            <td style="display:none"><?=$rowl['hr_break']?></td>
                            <td style="display:none"><?=$rowl['hr_break_fin']?></td>

                        </tr>
                        <?php
                            }

                            if($rowl['entrada']=="R")
                            {
                                ?>
                        <tr>
                            <td><?=$rowl['fecha_reg']?></td>
                            <td style="background:#F6E403;color:white;cursor:pointer"><?=$rowl['entrada']?></td>
                            <td style="display:none"><?=$rowl['fecha_entrada']?></td>
                            <td style="display:none"><?=$rowl['hr_break']?></td>
                            <td style="display:none"><?=$rowl['hr_break_fin']?></td>

                        </tr>
                        <?php
                            }

                            if($rowl['entrada']=="F")
                            {
                                ?>
                        <tr>
                            <td><?=$rowl['fecha_reg']?></td>
                            <td style="background:#D71515;color:white;cursor:pointer"><?=$rowl['entrada']?></td>
                            <td style="display:none"><?=$rowl['fecha_entrada']?></td>
                            <td style="display:none"><?=$rowl['hr_break']?></td>
                            <td style="display:none"><?=$rowl['hr_break_fin']?></td>

                        </tr>

                        <?php
                            }

                            if($rowl['entrada']=="FR")
                            {
                                ?>
                        <tr>
                            <td><?=$rowl['fecha_reg']?></td>
                            <td style="background:#F0961D;color:white;cursor:pointer"><?=$rowl['entrada']?></td>
                            <td style="display:none"><?=$rowl['fecha_entrada']?></td>
                            <td style="display:none"><?=$rowl['hr_break']?></td>
                            <td style="display:none"><?=$rowl['hr_break_fin']?></td>

                        </tr>
                        <?php
                            }


                        }
                        ?>

                        
                    </tbody>
                </table>

            </div>



        </div>


       
    </div>


        

    </div>

    <?php
 if(isset($_SESSION['reset'])){
    ?>
    <script>
    // $('.submit').css('display', 'block ');
    $('.reset').css('display', 'block');
    </script>
    <?php
 }
 ?>




    <?php
 if(isset($_SESSION['regbrei'])){
    ?>
    <script>
    $('.submit').css('display', 'none ');
    $('.submits').css('display', 'block');
 
    $('.hrs').append("<p>Primer registro de break :</p><h4><?php echo $brei ?></h4>")
    </script>
    <?php
 }
 ?>

<?php
 if(isset($_SESSION['regbref'])){
    ?>
    <script>
    // $('.submit').css('display', 'block ');
    $('.submits').css('display', 'none');
    $('.hrs').append("<p>Primer registro de break final:</p><h4><?php echo $bref ?></h4>")
    </script>
    <?php
 }
 ?>



<?php
 if(isset($_SESSION['enreg'])){
    ?>
    <script>
   
    $('.hrs').prepend("<p>Primer registro de entrada:</p><h4><?php echo $hrentrada; ?></h4>")
    </script>
    <?php
 }
 ?>

    <?php
 if(isset($_SESSION['brei'])){
    ?>
    <script>


    $('.submits').css('display', 'block');
    $('.submit').css('display', 'none');
    $('.hrs').append("<p>Hora break:</p><h4><?php echo $_SESSION['brei']; ?></h4>")
    </script>
    <?php
 }
 ?>

    <?php
 if(isset($_SESSION['bref'])){
    ?>
    <script>
    $('.submits').css('display', 'none ');
    $('.submit').css('display', 'none');
    $('.hrs').append("<p>Hora break final:</p><h4><?php echo $_SESSION['bref']; ?></h4>")
    </script>
    <?php
 }
 ?>


    <?php
 if(isset($_SESSION['hr'])){
    ?>
    <script>
    $('.hrs').prepend("<p>Hora entrada:</p><h4><?php echo $_SESSION['hr']; ?></h4>")
    </script>
    <?php
 }
 ?>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js"
        integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js"
        integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous">
    </script>
    <script>
    // $('.modal-body').html(parent.data('key'))

 
    $(document).ready(function() {

       
    
        var table = $('#example').DataTable({
            scrollY: '200px',
            paging: false,
            searching: false,
            ordering: false,
            info: false,
        });

        $('#example tbody').on('click', 'tr', function() {
            var data = table.row(this).data();
            // alert('You clicked on ' + data[0] + "'s row");
            Swal.fire({
                title: `Horarios:`,
                text: 'Hora de entrada: ' + data[2] + '/' + ' Hora break: ' + data[3] + '/' +
                    ' Hora termino break: ' + data[4],
                width: 600,
                padding: '3em',
                color: 'white',
                background: '#12586D',
                backdrop: 'rgba(0,0,123,0.4)'
            })
            // Swal.fire(
            //     'hora de entrada:'+data[2],

            //     'Hora de termino de break:'+data[4]
            //   )
        });
    });


    var list = ['Hay que comer para vivir, y no vivir para comer', 'Tripa vacía, corazón sin alegría ',
        'Yo voy a donde sea si hay comida',
        'No dejes para mañana lo que puedas comerte hoy.',
        'A todo se acostumbra uno, menos a no comer.', 'La mente clara y la cerveza oscura.'
    ];


    const $tiempo = document.querySelector('.tiempo'),
        $fecha = document.querySelector('.fecha');

    function digitalClock() {
        let f = new Date(),
            dia = f.getDate(),
            mes = f.getMonth() + 1,
            anio = f.getFullYear(),
            diaSemana = f.getDay();

        dia = ('0' + dia).slice(-2);
        mes = ('0' + mes).slice(-2)

        let timeString = f.toLocaleTimeString();
        $tiempo.innerHTML = timeString;
        let semana = ['D', 'L', 'M', 'X', 'J', 'V', 'S'];
        let showSemana = (semana[diaSemana]);
        $fecha.innerHTML = `${anio}-${mes}-${dia} ${showSemana}`
    }
    setInterval(() => {
        digitalClock()
    }, 1000);

    const loginText = document.querySelector(".title-text .login");
    const loginForm = document.querySelector("form.login");
    const loginBtn = document.querySelector("label.login");
    const signupBtn = document.querySelector("label.signup");
    const signupLink = document.querySelector("form .signup-link a");
    signupBtn.onclick = (() => {
        loginForm.style.marginLeft = "-50%";
        loginText.style.marginLeft = "-50%";
    });
    loginBtn.onclick = (() => {
        loginForm.style.marginLeft = "0%";
        loginText.style.marginLeft = "0%";
    });
    signupLink.onclick = (() => {
        signupBtn.click();
        return false;
    });
   
   window.location.hash="no-back-button";
    window.location.hash="Again-No-back-button";//esta linea es necesaria para chrome
    window.onhashchange=function(){window.location.hash="no-back-button";}

    </script>


</body>

</html>
<?php
}
else{
     header("Location:http://http://192.168.100.200:50/asistencias_empleados/");
}
?>