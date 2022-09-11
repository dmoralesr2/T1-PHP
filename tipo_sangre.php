<?php include("datos_conexion.php"); ?>
<!doctype html>
<html lang="es">
  <head>
    <title>Tipos de Sangre</title>
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
              <a class="nav-link" href="index.php">Estudiantes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="tipo_sangre.php">Tipos de Sangre</a>
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
                <th scope="col">Nombre</th>
              </tr>
            </thead>
            <tbody>
              <?php
                $db_conexion=mysqli_connect($db_host,$db_usr,$db_pass,$db_nombre);
                $db_conexion->real_query('SELECT * FROM tipos_sangre;');
                $resultado=$db_conexion->use_result();
                while ($fila=$resultado->fetch_assoc()) { ?>
                <tr data-bs-toggle="modal" data-bs-target="#modalForm" onclick='setAccion("U", <?php echo json_encode($fila); ?>);'>
                  <td><?php echo $fila['id_tipo_sangre']; ?></td>
                  <td><?php echo $fila['sangre']; ?></td>
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
            <h5 class="modal-title" id="modalTitleId">Formulario Tipo de Sangre</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <form id="form1" action="crud_tipo_sangre.php" method="post">
                <div class="col">
                  <div class="mb-3">
                    <label for="id_tipo_sangre" class="form-label">ID</label>
                    <input type="number" name="id_tipo_sangre" id="id_tipo_sangre" class="form-control" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="sangre" class="form-label">Nombre *</label>
                    <input type="text" name="sangre" id="sangre" class="form-control" placeholder="Ej: Tipo A" autofocus required>
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
        document.getElementById('id_tipo_sangre').value = dato ? dato.id_tipo_sangre : 0;
        document.getElementById('sangre').value = dato ? dato.sangre : '';

        // Estilo de Boton
        document.getElementById('BTN_C').className = dato ? 'd-none' : '';
        document.getElementById('BTN_UD').className = dato ? '' : 'd-none';
      }

      function openDel() {
        const res = confirm("Esta seguro que desea eliminar el registro?\nNota: Eliminara todos los estudiantes que posean este tipo de sangre.");
        if (res) {
          document.getElementById('accion').value = 'D';
          document.getElementById('form1').submit();
        }
      }
    </script>
  </body>
</html>