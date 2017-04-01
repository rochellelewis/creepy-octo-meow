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
						<h1>Feed Teh Kitty.</h1>
						<p><button class="btn btn-default" data-toggle="modal" data-target="#new-post-modal"><i class="fa fa-plus"></i> Publish Post</button></p>
						<form class="form-inline">
							<div class="form-group">
								<label class="sr-only" for="search-feed">search feed</label>
								<div class="input-group">
									<input type="text" class="form-control" id="search-feed" name="search-feed" placeholder="search posts">
									<span class="input-group-btn">
										<button class="btn btn-default"><i class="fa fa-search"></i></button>
									</span>
								</div>
							</div>
						</form>
					</div>
					<div class="col-md-8">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title pull-left">Post Title</h3>
								<button class="pull-right btn btn-default btn-sm" data-toggle="modal" data-target="#delete-post-modal"><i class="fa fa-trash-o"></i></button>
								<button class="pull-right btn btn-default btn-sm"><i class="fa fa-pencil"></i></button>
								<div class="clearfix"></div>
							</div>
							<div class="panel-body">
								<div class="post-date">
									<small><em>author</em> | <em>date</em></small>
								</div>
								<div class="post-content">
									Post content
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</main>

		<!-- create post modal -->
		<?php require_once ("modals/new-post-modal.php");?>

		<!-- delete modal -->
		<?php require_once ("modals/delete-post-modal.php");?>

		<!-- edit modal -->

	</div><!--./sfooter-content-->

	<!--insert footer -->
	<?php require_once ("footer.php");?>
</body>
</html>