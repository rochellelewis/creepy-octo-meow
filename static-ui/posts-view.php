<!DOCTYPE html>
<html lang="en">

	<?php require_once ("head-utils.php");?>

	<body class="sfooter">
		<div class="sfooter-content">

			<?php require_once("navbar.php");?>

			<main class="my-5">
				<div class="container-fluid text-center text-sm-left">

					<div class="row mb-3">
						<div class="col">
							<h1>Meow Forum</h1>
						</div>
					</div>

					<div class="card-columns">
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Card title that wraps to a new line</h4>
								<p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
							</div>
						</div>
						<div class="card p-3">
							<blockquote class="blockquote mb-0 card-body">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
								<footer class="blockquote-footer">
									<small class="text-muted">
										Someone famous in <cite title="Source Title">Source Title</cite>
									</small>
								</footer>
							</blockquote>
						</div>
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Card title</h4>
								<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
								<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
						<div class="card bg-primary text-white text-center p-3">
							<blockquote class="blockquote mb-0">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat.</p>
								<footer class="blockquote-footer">
									<small>
										Someone famous in <cite title="Source Title">Source Title</cite>
									</small>
								</footer>
							</blockquote>
						</div>
						<div class="card text-center">
							<div class="card-body">
								<h4 class="card-title">Card title</h4>
								<p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
								<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
						<div class="card p-3 text-right">
							<blockquote class="blockquote mb-0">
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
								<footer class="blockquote-footer">
									<small class="text-muted">
										Someone famous in <cite title="Source Title">Source Title</cite>
									</small>
								</footer>
							</blockquote>
						</div>
						<div class="card">
							<div class="card-body">
								<h4 class="card-title">Card title</h4>
								<p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This card has even longer content than the first to show that equal height action.</p>
								<p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
							</div>
						</div>
					</div><!--/.card-columns-->
				</div><!--/.container-fluid-->
			</main>

		</div>

		<?php require_once("footer.php");?>

		<?php require_once("sign-up-modal.php");?>

	</body>
</html>