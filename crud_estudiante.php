<?php
  if (!empty($_POST)) {
    $ACCION = utf8_decode($_POST["accion"]);

    // Datos
    $id = utf8_decode($_POST["id_estudiante"]);
    $carne = utf8_decode($_POST["carne"]);
    $nombres = utf8_decode($_POST["nombres"]);
    $apellidos = utf8_decode($_POST["apellidos"]);
    $direccion = utf8_decode($_POST["direccion"]);
    $telefono = utf8_decode($_POST["telefono"]);
    $correo_electronico = utf8_decode($_POST["correo_electronico"]);
    $id_tipo_sangre = utf8_decode($_POST["id_tipo_sangre"]);
    $fecha_nacimiento = utf8_decode($_POST["fecha_nacimiento"]);

    // Acciones
    if (!empty($ACCION)) {
      switch($ACCION) {
        case 'C':
          $sql='INSERT INTO estudiantes(carne,nombres,apellidos,direccion,telefono,correo_electronico,id_tipo_sangre,fecha_nacimiento) VALUES ("'.$carne.'","'.$nombres.'","'.$apellidos.'","'.$direccion.'","'.$telefono.'","'.$correo_electronico.'",'.$id_tipo_sangre.',"'.$fecha_nacimiento.'");';
          break;
        case 'U':
          $sql='UPDATE estudiantes SET carne="'.$carne.'", nombres="'.$nombres.'", apellidos="'.$apellidos.'", direccion="'.$direccion.'", telefono="'.$telefono.'", correo_electronico="'.$correo_electronico.'", id_tipo_sangre='.$id_tipo_sangre.', fecha_nacimiento="'.$fecha_nacimiento.'" WHERE id_estudiante='.$id;
          break;
        case 'D':
          $sql='DELETE FROM estudiantes WHERE id_estudiante='.$id;
          break;
        default:
          $sql='';
      }

      // Realizando SQL
      include("datos_conexion.php");
      $db_conexion=mysqli_connect($db_host,$db_usr,$db_pass,$db_nombre);
      if ($db_conexion->query($sql)===true) {
        $db_conexion->close();
        header('Location: index.php');
      } else $db_conexion->close();
    }
  }
?>
