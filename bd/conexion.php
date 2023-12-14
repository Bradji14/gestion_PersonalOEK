<?php
  $nombre = "localhost";
  $usuario = "root";
  $password = "";


  $db_nombre = "attendance";


  try{
    $conn =  new PDO("mysql:host=$nombre;dbname=$db_nombre", $usuario, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->query("set names utf8;");

  
  }catch(PDOException $e){
    echo "La conexión ha fallado: ". $e->getMessage();
  }

?>