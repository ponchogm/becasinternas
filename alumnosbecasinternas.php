<!DOCTYPE html>
<html lang="es">
<head>
	  <meta charset="utf-8">
	  <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	  <meta name="viewport" content="width=device-width, initial-scale=1">  
	  <title>Beneficios 2018 - Universidad Metropolitana de Ciencias de la Educación</title>
	  <meta name="description" content="umce beneficios">
	  <meta name="author" content="umce">
	  <meta name="robots" content="noindex"/>
	  <meta name="robots" content="nofollow">  
      <link href="../img/templates/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
      <link href="bootstrap-3.3.7-dist/css/bootstrap.css" rel="stylesheet" type="text/css">
      <script src="js/jquery/1.12.4/jquery.min.js"></script>
      <script src="bootstrap-3.3.7-dist/js/bootstrap.js"></script>
      <script src="js/funcionesalumno.js"></script>
</head>
<body>
	
    <?php include "cabecera.php"; ?>
	<div class="container" style="margin-top:10px">
		<h2 class="sub-header">Alumnos Becas Internas</h2>
		<div class="input-group"> <span class="input-group-addon">Buscar</span>
        <input id="filtrar" type="text" class="form-control" placeholder="Ingresa el RUT que deseas Buscar">
      </div>
		<div class="row" style="margin-top:10px">
			<div class="col-md-12">  
				
				<div class="table-responsive">
					<table class="table table-striped">
						<thead>
							<tr>
								<th width="10%">Rut</th>
								<th width="40%">Nombre</th>
								<th width="10%">Código Carrera</th>
								<th width="20%">Fecha Postulación</th>
								<th width="20%">Beca Interna</th>
							</tr>
						</thead>
						<tbody id="listaalumnos" class="buscar">
						</tbody>
					</table>
					<ul id="paginador" class="pagination pagination-sm">
					   
					</ul>

				</div>
			</div>
		</div>
		<button class='btn btn-success'>Exportar a Excel</button>
	</div>

    <!-- Modal mensajes cortos-->
	<div class="modal fade" id="myModalLittle" tabindex="-1" role="dialog" aria-labelledby="myModalLittleLabel">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Mensaje</h4>
				</div>
				<div class="modal-body">
					<p id="msg" class="msg"></p>
				</div>
				<div class="modal-footer">
					<button type="button" id="cerrarModalLittle" class="btn btn-default" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
</body>
</html>