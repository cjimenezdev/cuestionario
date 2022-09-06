<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- CSS only -->
	<title>Preguntas</title>
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

		.lead {
			font-size: xx-large;
			color: #3079e9;
		}

		.card {
			padding: 25px;
			box-shadow: 5px 5px 10px rgba(0, 0, 0, .1);
			margin: 20px;
		}

		.red {
			color: red;
		}
	</style>
</head>

<body>
	<div class="container-fluid">
		<div class="card">
			<div class="row">
				<div class="col-12"><br><br>
					<h3 class="lead">Gestión de preguntas</h3><br>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<label form="id_cuestionario">Seleccione la pregunta</label>
				</div>
				<div class="col-9">
					<select id="pregunta_id" name="pregunta_id" data-live-search="true" class="form-control"></select>
				</div>
			</div>
			<div class="row">
				<div class="col-3"></div>
				<div class="col-9">
					<div class="row">
						<div class="col-6">
							<input type="submit" id="" name="" class="btn btn-sm btn-info" value="Editar" onclick="editar()">
							<a href="#" onclick="opciones()" class="btn btn-sm btn-warning">Opciones</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card">
			<div class="row">
				<div class="col-12"><br><br>
					<h3 class="lead">Utilice este formulario para crear preguntas</h3><br>
				</div>
			</div>
			<form method="post" id="mainForm">
				<div class="row">
					<div class="col-3">
						<label form="id_cuestionario">Seleccione el cuestionario</label>
					</div>
					<div class="col-9">
						<select id="id_cuestionario" name="id_cuestionario" data-live-search="true" class="form-control"></select>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<label form="pregunta_texto">Ingrese el texto de la pregunta</label>
					</div>
					<div class="col-9">
						<input type="text" id="pregunta_texto" name="pregunta_texto" class="form-control" maxlength="200" required>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<label form="pregunta_texto">Seleccione el tipo de pregunta</label>
					</div>
					<div class="col-9">
						<select id="pregunta_tipo" name="pregunta_tipo" class="form-control">
							<option value="text">Texto</option>
							<option value="select">Lista</option>
							<option value="radio">Radio</option>
							<option value="check">CheckBox</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<label form="pregunta_texto">Posición de la pregunta</label>
					</div>
					<div class="col-9">
						<input type="number" id="pregunta_posicion" name="pregunta_posicion" class="form-control" required>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<label form="">Valor en puntos</label>
					</div>
					<div class="col-9">
						<input type="number" id="pregunta_puntos" name="pregunta_puntos" class="form-control" required>
					</div>
				</div>
				<div class="row">
					<div class="col-3">
						<label form="cuestionario_nombre">Estado</label>
					</div>
					<div class="col-9">
						<select id="pregunta_estado" name="pregunta_estado" class="form-control">
							<option value="a">Activo</option>
							<option value="i">Inctivo</option>
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-3"></div>
					<div class="col-9">
						<div class="row">
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
			$.post("configs/funciones.php?accion=mostrarPreguntas", function(r) {
				$("#pregunta_id").html(r);
				$('#pregunta_id').selectpicker('refresh');
			});

			$.post("configs/funciones.php?accion=mostrarCuestionarios", function(r) {
				$("#id_cuestionario").html(r);
				$('#id_cuestionario').selectpicker('refresh');
			});
		}

		function editar() {
			var id = $("#pregunta_id").val();
			$.post("configs/funciones.php?accion=editarPreguntas", {
				id: id
			}, function(datos) {
				datos = JSON.parse(datos);

				$("#pregunta_id").val(datos.pregunta_id);
				$("#pregunta_texto").val(datos.pregunta_texto);
				$("#pregunta_tipo").val(datos.pregunta_tipo);
				$("#pregunta_posicion").val(datos.pregunta_posicion);
				$("#pregunta_estado").val(datos.pregunta_estado);
				$("#id_cuestionario").val(datos.id_cuestionario);
				$("#pregunta_puntos").val(datos.puntos);
			});
		}

		function guardarDatos(e) {
			e.preventDefault(); //No se activará la acción predeterminada del evento
			var formData = new FormData($("#mainForm")[0]);

			$("#btnGuardar").prop("disabled", true);
			$.ajax({
				url: "configs/funciones.php?accion=guardarPreguntas",
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

		function opciones() {
			var id = $("#pregunta_id").val();

			$.post("configs/funciones.php?accion=validarOpciones", {
				id: id
			}, function(datos) {
				if (datos == "text") {
					Swal.fire({
						icon: 'error',
						text: 'Las opciones no se pueden agregar a preguntas de tipo texto',
						showConfirmButton: true
					});
				} else {
					Swal.fire({
						icon: 'info',
						html: '<p>Escriba la opción que quiere registrar</p>' +
							'<form id="opcionForm">' +
							'<input type="text" id="textoOpcion" name="textoOpcion" > ' +
							'</form>' +
							'<hr>' +
							'<p>Seleccione la opción que desea borrar</p>' +
							'<select id="listaOpciones" name="listaOpciones" data-live-search="true" onchange="borrarOpcion()"></select>',
						showConfirmButton: true,
						confirmButtonText: 'Guardar',
						showCancelButton: true,
						cancelButtonText: 'Cancelar'
					}).then((result) => {
						if (result.isConfirmed) {
							$.post("configs/funciones.php?accion=guardarOpciones", {
								texto: $("#textoOpcion").val(),
								id: id
							}, function(r) {

								Swal.fire({
									icon: 'success',
									text: 'Los datos se han guardado',
									showConfirmButton: false,
									timer: 2500
								});

							});
						}
					});
				}
			}).done(function() {
				$.post("configs/funciones.php?accion=cargarOpciones", {
					id: id
				}, function(r) {
					$("#listaOpciones").html(r);
					$('#listaOpciones').selectpicker('refresh');
				});
			});
		}

		function borrarOpcion() {
			var id = $("#listaOpciones").val();

			Swal.fire({
				icon: 'warning',
				title: '¿Borrar esta opción?',
				showCancelButton: true,
				cancelButtonText: 'No',
				confirmButtonText: 'Si'
			}).then((result) => {
				if (result.isConfirmed) {
					$.post("configs/funciones.php?accion=borrarOpciones", {
						id: id
					}, function(r) {
						if (r == 1) {
							Swal.fire({
								icon: 'success',
								text: 'Los datos se han borrado',
								showConfirmButton: false,
								timer: 2500
							});
						}
					});
				}
			});
		}

		init();
	</script>
</body><br><br><br>

</html>