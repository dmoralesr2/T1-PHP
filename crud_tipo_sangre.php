<?php
  if (!empty($_POST)) {
    $ACCION = utf8_decode($_POST["accion"]);

    // Datos
    $id = utf8_decode($_POST["id_tipo_sangre"]);
    $sangre = utf8_decode($_POST["sangre"]);

    // Acciones
    if (!empty($ACCION)) {
      switch($ACCION) {
        case 'C':
          $sql='INSERT INTO tipos_sangre(sangre) VALUES ("'.$sangre.'");';
          break;
        case 'U':
          $sql='UPDATE tipos_sangre SET sangre="'.$sangre.'" WHERE id_tipo_sangre='.$id;
          break;
        case 'D':
          $sql='DELETE FROM tipos_sangre WHERE id_tipo_sangre='.$id;
          break;
        default:
          $sql='';
      }

      // Realizando SQL
      include("datos_conexion.php");
      $db_conexion=mysqli_connect($db_host,$db_usr,$db_pass,$db_nombre);
      if ($db_conexion->query($sql)===true) {
        $db_conexion->close();
        header('Location: tipo_sangre.php');
      } else $db_conexion->close();
    }
  }
?>
