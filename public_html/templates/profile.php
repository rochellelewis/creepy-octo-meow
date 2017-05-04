<navbar></navbar>

<main>
	<div class="container-fluid">

		<!-- title row -->
		<div class="row">
			<div class="col-xs-12">
				<h1>{{ profile.profileUsername }} </h1>
			</div>
		</div>


		<div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<a class="btn btn-default btn-sm" href="feed.php"><i class="fa fa-arrow-left"></i> Back to feed</a>
						<button class="btn btn-default btn-sm" data-toggle="modal" data-target="#update-profile-modal"><i class="fa fa-pencil"></i>&nbsp;Edit Profile</button>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">

					</div>
				</div>
			</div>
		</div>

		<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
			<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
			{{ status.message }}
		</div>

	</div><!--./container-fluid-->
</main>