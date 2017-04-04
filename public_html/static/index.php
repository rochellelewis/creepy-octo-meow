<!-- insert head tag -->
<?php require_once ("head-utils.php");?>
	<body class="sfooter">
		<div class="sfooter-content">

			<main>
				<div class="container">
					<div class="row">
						<div class="col-sm-10 col-sm-offset-1">
							<div class="welcome text-center">
								<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#login-modal">Log In</button>
								<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#signup-modal">Sign Up</button>
							</div>
						</div>
					</div>
				</div>
			</main>

			<!-- login modal -->
			<?php require_once ("modals/login-modal.php");?>

			<!-- signup modal -->
			<?php require_once ("modals/signup-modal.php");?>

		</div><!--./sfooter-content-->

		<!--insert footer -->
		<?php require_once ("footer.php");?>
	</body>
</html>