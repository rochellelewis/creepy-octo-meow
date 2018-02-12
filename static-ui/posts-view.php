<!DOCTYPE html>
<html lang="en">

	<?php require_once ("head-utils.php");?>

	<body class="sfooter">
		<div class="sfooter-content">

			<?php require_once("navbar.php");?>

			<main class="my-5">
				<div class="container-fluid text-center text-lg-left">

					<div class="row mb-3">
						<div class="col">
							<h1>Meow Forum</h1>
						</div>
					</div>

					<div class="row">
						<div class="col-12 col-lg-3">
							<form>
								<div class="form-group">
									<input type="text" class="form-control" name="postTitle" id="postTitle" placeholder="Title">
								</div>
								<div class="form-group">
									<textarea name="postContent" id="postContent" class="form-control" placeholder="2000 chars max" rows="10"></textarea>
								</div>
								<button type="submit" class="btn btn-block btn-warning mb-3">Submit</button>
							</form>
						</div>
						<div class="col-12 col-lg-9">
							<div class="card-columns">
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post title that wraps to a new line</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
									<button class="post-delete btn btn-sm btn-danger">x</button>
								</div>
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
								<div class="card">
									<div class="card-body blue-card">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
								<div class="card">
									<div class="card-body">
										<h4 class="card-title">Post Title</h4>
										<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
										<p class="card-text"><small class="text-muted">Author Name | Date</small></p>
									</div>
								</div>
							</div><!--/.card-columns-->
						</div>

					</div>


				</div><!--/.container-fluid-->
			</main>

		</div>

		<?php require_once("footer.php");?>

		<?php require_once("sign-up-modal.php");?>

	</body>
</html>