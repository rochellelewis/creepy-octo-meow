<!-- insert head tag -->
<?php require_once ("head-utils.php");?>

<body class="sfooter">
	<div class="sfooter-content">

		<!-- insert header -->
		<?php require_once ("header.php");?>

		<main>
			<div class="container-fluid">
				<div class="row">
					<div class="col-md-4">
						<h1>{{Username}}</h1>
					</div>
					<div class="col-md-8">
						<div class="panel panel-default">
							<div class="panel-heading">
								<button class="btn btn-default btn-sm pull-right" data-toggle="modal" data-target="#update-profile-modal"><i class="fa fa-pencil"></i>&nbsp;Edit Profile</button>
								<a class="btn btn-default btn-sm pull-left" href="feed.php"><i class="fa fa-arrow-left"></i> Back to feed</a>
								<div class="clearfix"></div>
							</div>
							<div class="panel-body">

							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

		<!-- update profile modal -->
		<?php require_once ("modals/update-profile-modal.php");?>

	</div><!--./sfooter-content-->

	<!--insert footer -->
	<?php require_once ("footer.php");?>
</body>
</html>