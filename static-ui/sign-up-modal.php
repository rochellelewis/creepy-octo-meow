<div class="modal fade" id="signUpModal" tabindex="-1" role="dialog" aria-labelledby="signUpModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="signUpModalLabel">Sign Up for a Meow Account</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">

				<form name="signUpForm" id="signUpForm" novalidate>

					<!-- email group -->
					<div class="form-group">
						<label for="profileEmail" class="sr-only">Email</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
							<input type="email" class="form-control" id="profileEmail" name="profileEmail" formControlName="profileEmail" placeholder="Email">
						</div>
					</div>

					<!-- username group -->
					<div class="form-group">
						<label for="profileUsername" class="sr-only">Username</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
							<input type="email" class="form-control" id="profileUsername" name="profileUsername" formControlName="profileUsername" placeholder="Username">
						</div>
					</div>

					<!-- password group -->
					<div class="form-group">
						<label for="profilePassword" class="sr-only">Password</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-lock"></i></span>
							<input type="password" class="form-control" id="profilePassword" name="profilePassword" formControlName="profilePassword" placeholder="Password">
						</div>
					</div>

					<!-- confirm pass group -->
					<div class="form-group">
						<label for="profileConfirmPassword" class="sr-only">Confirm Password</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-ellipsis-h"></i></span>
							<input type="password" class="form-control" id="profileConfirmPassword" name="profileConfirmPassword" formControlName="profileConfirmPassword" placeholder="Confirm Password">
						</div>
					</div>

					<!-- submit -->
					<div class="form-group">
						<button type="button" class="btn btn-primary"><i class="fa fa-paw"></i>&nbsp;Sign Up!</button>
					</div>
				</form>

			</div>
		</div>
	</div>
</div>