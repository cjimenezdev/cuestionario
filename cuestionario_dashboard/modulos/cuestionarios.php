<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSS only -->
	<title>Cuestionarios</title>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" type="text/javascript"></script>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<!-- google fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Oleo+Script+Swash+Caps&family=Open+Sans&display=swap" rel="stylesheet">

	<style type="text/css">
		body {
			margin: 0;
			font-family: 'Open Sans', sans-serif;
		}

		input,
		select {
			margin: 5px;
		}

		label {
			font-weight: bold;
		}

		li {
			list-style: none;
		}

		.lead {
			font-size: xx-large;
			color: #3079e9;
		}

		.card {
			padding: 25px;
			box-shadow: 5px 5px 10px rgba(0, 0, 0, .1);
			margin: 20px;
		}

		.buttons {
			display: flex;
		}

		.center {
			display: flex;
			justify-content: center;
		}

		.red {
			color: red;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="card">
			<div class="row">
				<div class="col-12"><br><br>
					<h3 class="lead">Gestión de los cuestionarios</h3><br>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<label>Seleccione el cuestionario</label>
				</div>
				<div class="col-9">
					<select id="cuestionarios" name="cuestionarios" data-live-search="true" class="form-control"></select>
				</div>
			</div>
			<div class="row">
				<div class="col-3"></div>
				<div class="col-9">
					<div class="row">
						<div class="center">
							<input type="submit" id="" name="" class="btn btn-sm btn-info" value="Editar" onclick="editar()">
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="row">
				<div class="col-12"><br><br>
					<h3 class="lead">Utilice este formulario para crear cuestionarios</h3><br>
				</div>
			</div>
			<form method="post" id="mainForm">
				<div class="row">
					<div class="col-3">
						<label form="cuestionario_nombre">Ingrese el nombre para el cuestionario</label>
					</div>
					<div class="col-9">
						<input type="hidden" id="cuestionario_id" name="cuestionario_id">
						<input type="text" id="cuestionario_nombre" name="cuestionario_nombre" class="form-control" maxlength="200" required>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<label form="cuestionario_nombre">Descripción del cuestionario</label>
					</div>
					<div class="col-9">
						<input type="text" id="cuestionario_descripcion" name="cuestionario_descripcion" class="form-control" maxlength="2000" required>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<label form="cuestionario_nombre">Estado</label>
					</div>
					<div class="col-9">
						<select id="cuestionario_estado" name="cuestionario_estado" class="form-control">
							<option value="a">Activo</option>
							<option value="i">Inctivo</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-3"></div>
					<div class="col-9">
						<div class="buttons">
							<div class="col-6">
								<input type="submit" id="guardarBtn" name="guardarBtn" class="btn btn-sm btn-success" value="Guardar">
							</div>
							<div class="col-6">
								<input type="button" name="cancelarBtn" id="cancelarBtn" class="btn btn-sm btn-danger" value="Cancelar" onclick="limpiarForm();">
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>

	</div>
	<script type="text/javascript">
		function init() {
			$("#mainForm").on("submit", function(e) {
				guardarDatos(e);
			});

			cargarSelect();
		}

		function limpiarForm() {
			Swal.fire({
				icon: 'warning',
				title: '¿Cancelar y borrar los datos?',
				showCancelButton: true,
				cancelButtonText: 'No',
				confirmButtonText: 'Si'
			}).then((result) => {
				if (result.isConfirmed) {
					$("#mainForm")[0].reset();
				}
			});
		}

		function cargarSelect() {
			$.post("configs/funciones.php?accion=mostrarCuestionarios", function(r) {
				$("#cuestionarios").html(r);
				$('#cuestionarios').selectpicker('refresh');
			});
		}

		function editar() {
			var id = $("#cuestionarios").val();
			$.post("configs/funciones.php?accion=editarCuestionario", {
				id: id
			}, function(datos) {
				datos = JSON.parse(datos);

				$("#cuestionario_id").val(datos.cuestionario_id);
				$("#cuestionario_nombre").val(datos.cuestionario_nombre);
				$("#cuestionario_descripcion").val(datos.cuestionario_descripcion);
				$("#cuestionario_estado").val(datos.cuestionario_estado);
			});
		}

		function guardarDatos(e) {
			e.preventDefault(); //No se activará la acción predeterminada del evento
			var formData = new FormData($("#mainForm")[0]);

			$("#btnGuardar").prop("disabled", true);
			$.ajax({
				url: "configs/funciones.php?accion=guardarCuestionario",
				type: "POST",
				data: formData,
				contentType: false,
				processData: false,
				success: function(datos) {
					if (datos == "1") {
						Swal.fire({
							icon: 'success',
							text: 'Los datos se han guardado',
							showConfirmButton: false,
							timer: 2500
						});
						mostrar_formulario(false);
						tabla.ajax.reload();
						limpiar_formulario();
					} else {
						Swal.fire({
							icon: 'error',
							text: 'Los datos no se han podido guardar',
							showConfirmButton: false,
							timer: 2500
						});
					}
				}
			});
		}

		init();
	</script>
</body>
<br><br><br>

</html>