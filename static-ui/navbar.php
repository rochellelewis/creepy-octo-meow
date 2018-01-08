<header>
	<nav class="navbar navbar-expand-lg navbar-dark">
		<a class="navbar-brand" href="https://bootcamp-coders.cnm.edu/~rlewis37/meow-app-5/static-ui/home-view.php">=^ Meow App 5 ^=</a><small class="d-none d-md-inline-block text-muted mr-auto"><em>An Angularific Demo.</em></small>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Hello, {{username}}
					</a>
					<div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
						<a class="dropdown-item" href="#"><i class="fa fa-user"></i>&nbsp;&nbsp;My Profile</a>
						<a class="dropdown-item" href="posts-view.php"><i class="fa fa-pencil"></i>&nbsp;&nbsp;New Post</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="#"><i class="fa fa-sign-out"></i>&nbsp;&nbsp;Sign Out</a>
					</div>
				</li>
			</ul>
		</div>
	</nav>
</header>