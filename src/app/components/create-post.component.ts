import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../classes/status";

import {Post} from "../classes/post";

import {JwtHelperService} from "@auth0/angular-jwt";
import {PostService} from "../services/post.service";

//enable jquery $ alias
declare const $: any;

@Component({
	templateUrl: "./templates/create-post.html",
	selector: "create-post"
})

export class CreatePostComponent implements OnInit {

	createPostForm: FormGroup;
	post: Post = new Post(null, null, null, null, null);
	posts: Post[] = [];
	status: Status = null;

	authObj: any = {};

	constructor(
		private formBuilder: FormBuilder,
		private jwtHelperService: JwtHelperService,
		private postService: PostService,
	){}

	ngOnInit() : void {
		this.createPostForm = this.formBuilder.group({
			postTitle: ["", [Validators.maxLength(64), Validators.required]],
			postContent: ["", [Validators.maxLength(2000), Validators.required]]
		});
		this.applyFormChanges();
	}

	applyFormChanges() : void {
		this.createPostForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.post[field] = values[field];
			}
		});
	}

	reloadPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	getJwtProfileId() : any {
		this.authObj = this.jwtHelperService.decodeToken(localStorage.getItem('jwt-token'));
	}

	createPost() : void {

		this.getJwtProfileId();
		let newPostProfileId = this.authObj.auth.profileId;
		//console.log(newPostProfileId);

		//form new post
		let post = new Post(null, newPostProfileId, this.createPostForm.value.postContent, null, this.createPostForm.value.postTitle);

		this.postService.createPost(post)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.reloadPosts();
					this.createPostForm.reset();
					console.log("post created ok");
					setTimeout(function(){$("#new-post-modal").modal("hide");}, 3000);
				} else {
					console.log("post not created");
				}
			});
	}

}
