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
						<h1 class="mb-5">Feed Teh Kitty.</h1>
					</div>
				</div>

				<!-- content row -->
				<div class="row">
					<div class="col">

						<!-- single post item -->
						<div class="card">
							<div class="card-header d-flex justify-content-end">
								<h3 class="panel-title d-inline-block my-0 mr-auto">Post Title</h3>
								<button class="btn btn-default btn-sm mr-2" data-toggle="modal" data-target="#delete-post-modal"><i class="fa fa-trash-o"></i></button>
								<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#update-post-modal"><i class="fa fa-pencil"></i></button>
							</div>
							<div class="card-body">
								<div class="post-date">
									<small><em>author</em> | <em>date</em></small>
									<hr>
								</div>
								<div class="post-content">
									Post content
								</div>
							</div>
						</div>

					</div><!--./col-md-8-->
				</div><!--/.row-->
			</div><!--/.container-fluid-->
		</main>

		<!-- create post modal -->
		<?php require_once("modals/new-post-modal.php");?>

		<!-- delete modal -->
		<?php require_once("modals/delete-post-modal.php");?>

		<!-- update post modal -->
		<?php require_once("modals/update-post-modal.php");?>

	</div><!--./sfooter-content-->

	<!--insert footer -->
	<?php require_once("footer.php");?>
</body>
</html>