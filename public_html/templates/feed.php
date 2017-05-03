<navbar></navbar>

<main>
	<div class="container-fluid">

		<!-- title row -->
		<div class="row">
			<div class="col-xs-12">
				<h1>Feed Teh Kitty.</h1>
			</div>
		</div>

		<!-- content row -->
		<div class="row">
			<div class="col-xs-12">

				<!-- BEGIN POST ITEM -->
				<div class="panel panel-info" *ngFor="let post of postsFiltered">
					<div class="panel-heading">
						<h3 class="panel-title pull-left">{{post.postTitle}}</h3>
						<button class="pull-right btn btn-default btn-sm" data-toggle="modal" data-target="#delete-post-modal"><i class="fa fa-trash-o"></i></button>
						<button class="pull-right btn btn-default btn-sm" data-toggle="modal" data-target="#update-post-modal"><i class="fa fa-pencil"></i></button>
						<div class="clearfix"></div>
					</div>
					<div class="panel-body">
						<div class="post-date">
							<small><em>{{post.postProfileId}}</em> | <em>{{post.postDate}}</em></small>
						</div>
						<div class="post-content">
							{{post.postContent}}
						</div>
					</div>
				</div><!--/.panel-->
				<!-- END POST ITEM -->

			</div><!--./col-md-8-->
		</div><!--/.row-->
	</div><!--/.container-fluid-->
</main>