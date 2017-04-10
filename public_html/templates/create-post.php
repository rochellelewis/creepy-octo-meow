<div class="modal fade" id="new-post-modal" tabindex="-1" role="dialog" aria-labelledby="create-post">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="create-post">New Post.</h4>
			</div>
			<div class="modal-body">
				<form action="">
					<div class="form-group">
						<label for="postTitle" class="sr-only">Title</label>
						<input type="text" class="form-control" id="postTitle" name="postTitle" placeholder="post title">
					</div>
					<div class="form-group">
						<label for="postContent" class="sr-only">Content</label>
						<textarea class="form-control" name="postContent" id="postContent" cols="30" rows="10" placeholder="2000 characters max"></textarea>
					</div>
					<button class="btn btn-info" type="submit">Meow!</button>
					<button class="btn btn-default" type="reset" data-dismiss="modal">Cancel</button>
				</form>
			</div>
		</div>
	</div>
</div>