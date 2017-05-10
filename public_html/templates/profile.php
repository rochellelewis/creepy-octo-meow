<navbar></navbar>

<main>
	<div class="container-fluid">

		<!-- title row -->
		<div class="row">
			<div class="col-xs-12">
				<h1>{{ profile.profileUsername }}</h1>
			</div>
		</div>


		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a class="btn btn-default btn-sm" routerLink="/feed"><i class="fa fa-arrow-left"></i> Back to feed</a>
						<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#update-profile-modal"><i class="fa fa-pencil"></i>&nbsp;Edit Profile</button>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
						<div><strong>username</strong>:&nbsp;{{ profile.profileUsername }}</div>
						<div><strong>email</strong>:&nbsp;{{ profile.profileEmail }}</div>
					</div>
				</div>
			</div>
		</div>

	</div><!--./container-fluid-->
</main>