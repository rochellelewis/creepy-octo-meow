<!-- insert head tag -->
<?php require_once("head-utils.php");?>
<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header -->
		<?php require_once("header.php");?>

		<main>
			<div class="container-fluid">

				<!-- title row -->
				<div class="row">
					<div class="col">
						<h1>Creepy Octo Meow.</h1>
					</div>
				</div>

				<!-- content row -->
				<div class="row">
					<div class="col-sm-6">
						<p>This is some content</p>
					</div>
<div class="col																																																																																																		-sm-6">
						<p>This is some more content.</p>
					</div>
				</div>
			</div>
		</main>

		<!-- login modal -->
		<?php require_once("modals/login-modal.php");?>

		<!-- signup modal -->
		<?php require_once("modals/signup-modal.php");?>

	</div><!--./sfooter-content-->

	<!--insert footer -->
	<?php require_once("footer.php");?>
</body>
</html>