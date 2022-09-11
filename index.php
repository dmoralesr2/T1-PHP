<?php include("datos_conexion.php"); ?>
<!doctype html>
<html lang="es">
  <head>
    <title>Estudiantes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS v5.2.0-beta1 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Estudiantes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="tipo_sangre.php">Tipos de Sangre</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
    <main class="m-4">
      <div class="card">
        <div class="card-header d-flex justify-content-end">
          <button type="button" class="btn btn-success px-3" data-bs-toggle="modal" data-bs-target="#modalForm" onclick="setAccion('C', null);">Agregar Registro</button>
        </div>
        <div class="card-body table-responsive">
          <table class="table table-striped table-hover">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Carne</th>
                <th scope="col">Nombres</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Direccion</th>
                <th scope="col">Telefono</th>
                <th scope="col">Correo</th>
                <th scope="col">Tipo de Sangre</th>
                <th scope="col">Nacimiento</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $db_conexion=mysqli_connect($db_host,$db_usr,$db_pass,$db_nombre);
                $db_conexion->real_query('SELECT e.*, DATE_FORMAT(e.fecha_nacimiento, "%d/%m/%Y") AS nacimiento, DATE_FORMAT(e.fecha_nacimiento, "%Y-%m-%d") AS fecha_nacimiento, ts.sangre FROM estudiantes e INNER JOIN tipos_sangre ts ON ts.id_tipo_sangre=e.id_tipo_sangre;');
                $resultado=$db_conexion->use_result();
                while ($fila=$resultado->fetch_assoc()) { ?>
                <tr data-bs-toggle="modal" data-bs-target="#modalForm" onclick='setAccion("U", <?php echo json_encode($fila); ?>);'>
                  <td><?php echo $fila['id_estudiante']; ?></td>
                  <td><?php echo $fila['carne']; ?></td>
                  <td><?php echo $fila['nombres']; ?></td>
                  <td><?php echo $fila['apellidos']; ?></td>
                  <td><?php echo ($fila['direccion']?$fila['direccion']:'- - -'); ?></td>
                  <td><?php echo ($fila['telefono']?$fila['telefono']:'- - -'); ?></td>
                  <td><?php echo ($fila['correo_electronico']?$fila['correo_electronico']:'- - -'); ?></td>
                  <td><?php echo $fila['sangre']; ?></td>
                  <td><?php echo $fila['nacimiento']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </main>
    <footer class="bg-dark text-center p-3 text-white">
      DOMY - UMG Desarrollo Web
    </footer>

    <!-- Modal Body-->
    <div class="modal modal-lg fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="modalTitleId"
      aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalTitleId">Formulario Estudiante</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <form id="form1" action="crud_estudiante.php" method="post">
                <div class="col">
                  <div class="mb-3">
                    <label for="id_estudiante" class="form-label">ID</label>
                    <input type="number" name="id_estudiante" id="id_estudiante" class="form-control" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="carne" class="form-label">Carne *</label>
                    <input type="text" pattern="E[0-9]{3}" name="carne" id="carne" class="form-control" placeholder="Ej: E001" autofocus required>
                  </div>
                  <div class="mb-3">
                    <label for="nombres" class="form-label">Nombres *</label>
                    <input type="text" name="nombres" id="nombres" class="form-control" placeholder="Ej: Donal Obed" required>
                  </div>
                  <div class="mb-3">
                    <label for="apellidos" class="form-label">Apellidos *</label>
                    <input type="text" name="apellidos" id="apellidos" class="form-control" placeholder="Ej: Morales Reyes" required>
                  </div>
                  <div class="mb-3">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Ej: Ciudad">
                  </div>
                  <div class="mb-3">
                    <label for="telefono" class="form-label">Telefono</label>
                    <input type="number" name="telefono" id="telefono" class="form-control" placeholder="Ej: 00000000">
                  </div>
                  <div class="mb-3">
                    <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                    <input type="email" name="correo_electronico" id="correo_electronico" class="form-control" placeholder="Ej: x@y.z">
                  </div>
                  <div class="mb-3">
                    <label for="id_tipo_sangre" class="form-label">Tipo de Sangre *</label>
                    <select class="form-control" name="id_tipo_sangre" id="id_tipo_sangre" required>
                    <?php
                      $db_conexion=mysqli_connect($db_host,$db_usr,$db_pass,$db_nombre);
                      $db_conexion->real_query('SELECT * FROM tipos_sangre;');
                      $resultado=$db_conexion->use_result();
                      while ($fila=$resultado->fetch_assoc()) { ?>
                        <option id="<?php echo $fila['id_tipo_sangre']; ?>" value="<?php echo $fila['id_tipo_sangre']; ?>"><?php echo $fila['sangre']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div>
                    <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento *</label>
                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control" placeholder="Ej: YYYY-MM-DD" required>
                  </div>
                </div>
                <input type="hidden" id="accion" name="accion" value="C">
              </form>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            <div id="BTN_C">
              <button type="submit" form="form1" class="btn btn-success">Agregar</button>
            </div>
            <div id="BTN_UD" class="d-none">
              <button type="submit" form="form1" class="btn btn-primary">Editar</button>
              <button type="button" class="btn btn-danger" onclick="openDel();">Eliminar</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.5/dist/umd/popper.min.js" integrity="sha384-Xe+8cL9oJa6tN/veChSP7q+mnSPaj5Bcu9mPX5F5xIGE0DVittaqT5lorf0EI7Vk" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.min.js" integrity="sha384-ODmDIVzN+pFdexxHEHFBQH3/9/vQ9uori45z4JjnFsRydbmQbmL5t1tQ0culUzyK" crossorigin="anonymous"></script>
    <script>
      function setAccion(value, dato) {
        document.getElementById('accion').value = value;
        document.getElementById('id_estudiante').value = dato ? dato.id_estudiante : 0;
        document.getElementById('carne').value = dato ? dato.carne : '';
        document.getElementById('nombres').value = dato ? dato.nombres : '';
        document.getElementById('apellidos').value = dato ? dato.apellidos : '';
        document.getElementById('direccion').value = dato ? dato.direccion : '';
        document.getElementById('telefono').value = dato ? dato.telefono : '';
        document.getElementById('correo_electronico').value = dato ? dato.correo_electronico : '';
        document.querySelector('#id_tipo_sangre').value = dato ? dato.id_tipo_sangre : 0;
        document.getElementById('fecha_nacimiento').value = dato ? dato.fecha_nacimiento : '';
        // Estilo de Boton
        document.getElementById('BTN_C').className = dato ? 'd-none' : '';
        document.getElementById('BTN_UD').className = dato ? '' : 'd-none';
      }
      function openDel() {
        const res = confirm("Esta seguro que desea eliminar el registro?");
        if (res) {
          document.getElementById('accion').value = 'D';
          document.getElementById('form1').submit();
        }
      }
    </script>
  </body>
</html>
