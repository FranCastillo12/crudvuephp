<script src="vue.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.js"></script>

<div id="myApp">
	<div class="container">
		<h1 class="text-center">CRUD</h1>

		<div class="row">
			<div class="offset-md-3 col-md-6">
				<form method="POST" action="create.php" v-on:submit.prevent="doCreate">
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="nombre" class="form-control" />
					</div>

					<div class="form-group">
						<label>Apellidos</label>
						<input type="text" name="apellidos" class="form-control" />
					</div>

					<div class="form-group">
						<label>direccion</label>
						<input type="text" name="direccion" class="form-control" />
					</div>

					<div class="form-group">
						<label>telefono</label>
						<input type="text" name="telefono" class="form-control" />
					</div>

					<div class="form-group">
						<label>edad</label>
						<input type="text" name="edad" class="form-control" />
					</div>

					<div class="form-group">
						<label>altura</label>
						<input type="text" name="altura" class="form-control" />
					</div>
					

					<input type="submit" value="Create User" class="btn btn-primary" />
				</form>
			</div>
		</div>

		

		<table class="table">
			<tr>
				<th>Nombre</th>
				<th>Apellidos</th>
				<th>Direccion</th>
				<th>telefono</th>
				<th>edad</th>
				<th>altura</th>
				<th>Actions</th>
			</tr>

			<tr v-for="(user, index) in users">
				<td v-text="user.nombre"></td>
				<td v-text="user.apellidos"></td>
				<td v-text="user.direccion"></td>
				<td v-text="user.telefono"></td>
				<td v-text="user.edad"></td>
				<td v-text="user.altura"></td>
				<td>
					<button type="button" v-bind:data-id="user.nombre" v-on:click="showEditUserModal" class="btn btn-primary">Modificar</button>

					<form method="POST" action="delete.php" v-on:submit.prevent="doDelete" style="display: contents;">
						<input type="hidden" name="nombre" v-bind:value="user.nombre" />
						<input type="submit" name="submit" class="btn btn-danger" value="Eliminar" />
					</form>
				</td>
			</tr>
		</table>
	</div>

	<!-- Modal -->
	<div class="modal" id="editUserModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Editar</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				
				<div class="modal-body">
					<form method="POST" action="update.php" v-on:submit.prevent="doUpdate" id="form-edit-user" v-if="user != null">
						<input type="hidden" name="nombre" v-bind:value="user.nombre" />

						<div class="form-group">
							<label>Nombre</label>
							<input type="text" name="nombre" v-bind:value="user.nombre" class="form-control" />
						</div>

						<div class="form-group">
							<label>Apellidos</label>
							<input type="text" name="apellidos" v-bind:value="user.apellidos" class="form-control" />
						</div>

						<div class="form-group">
							<label>direccion</label>
							<input type="text" name="direccion" v-bind:value="user.direccion" class="form-control" />
						</div>

						<div class="form-group">
							<label>telefono</label>
							<input type="text" name="telefono" v-bind:value="user.telefono"  class="form-control" />
						</div>

						<div class="form-group">
							<label>edad</label>
							<input type="text" name="edad" v-bind:value="user.edad" class="form-control" />
						</div>

						<div class="form-group">
							<label>altura</label>
							<input type="text" name="altura" v-bind:value="user.altura" class="form-control" />
						</div>
					</form>
				</div>

				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="submit" name="submit" class="btn btn-primary" form="form-edit-user">Aceptar</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	// initialize Vue JS
	const myApp = new Vue({
		el: "#myApp",
		data: {
			users: [],
			user: null
		},
		methods: {
			// delete user
			doDelete: function () {
				const self = this;
				const form = event.target;

				const ajax = new XMLHttpRequest();
				ajax.open("POST", form.getAttribute("action"), true);

				ajax.onreadystatechange = function () {
					if (this.readyState == 4) {
						if (this.status == 200) {
							// console.log(this.responseText);

							// remove from local array
							for (var a = 0; a < self.users.length; a++) {
								if (self.users[a].nombre == form.id.value) {
									self.users.splice(a, 1);
									break;
								}
							}
						}
					}
				};

				const formData = new FormData(form);
				ajax.send(formData);
			},

			// update the user
			doUpdate: function () {
				const self = this;
				const form = event.target;

				const ajax = new XMLHttpRequest();
				ajax.open("POST", form.getAttribute("action"), true);

				ajax.onreadystatechange = function () {
					if (this.readyState == 4) {
						if (this.status == 200) {
							// console.log(this.responseText);

							const user = JSON.parse(this.responseText);
							// console.log(user);

							// update in local array
							// get index from local array
							var index = -1;
							for (var a = 0; a < self.users.length; a++) {
								if (self.users[a].nombre == user.nombre) {
									index = a;
									break;
								}
							}

							// create temporary array
							const tempUsers = self.users;

							// update in local temporary array
							tempUsers[index] = user;

							// update the local array by removing all old elements and inserting the updated users
							self.users = [];
							self.users = tempUsers;
						}
					}
				};

				const formData = new FormData(form);
				ajax.send(formData);

				// hide the modal
				$("#editUserModal").modal("hide");
			},

			showEditUserModal: function () {
				const id = event.target.getAttribute("data-id");
				
				// get user from local array and save in current object
				for (var a = 0; a < this.users.length; a++) {
					if (this.users[a].nombre == id) {
						this.user = this.users[a];
						break;
					}
				}

				$("#editUserModal").modal("show");
			},

			// get all users from database
			getData: function () {
				const self = this;

				const ajax = new XMLHttpRequest();
				ajax.open("POST", "read.php", true);

				ajax.onreadystatechange = function () {
					if (this.readyState == 4) {
						if (this.status == 200) {
							// console.log(this.responseText);
							const users = JSON.parse(this.responseText);
							self.users = users;
						}
					}
				};

				const formData = new FormData();
				ajax.send(formData);
			},

			doCreate: function () {
				const self = this;
				const form = event.target;

				const ajax = new XMLHttpRequest();
				ajax.open("POST", form.getAttribute("action"), true);

				ajax.onreadystatechange = function () {
					if (this.readyState == 4) {
						if (this.status == 200) {
							// console.log(this.responseText);

							const user = JSON.parse(this.responseText);

							// prepend in local array
							self.users.unshift(user);
						}
					}
				};

				const formData = new FormData(form);
				ajax.send(formData);
			}
		},
		// call an AJAX to fetch data when Vue JS is mounted
		mounted: function () {
			this.getData();
		}
	});
</script>

<style>
	table, th, td {
		border: 1px solid black;
		border-collapse: collapse;
	}
	th, td {
		padding: 25px;
	}
</style>