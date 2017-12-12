import {Component, EventEmitter, OnInit, Output, Input} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {JwtHelperService} from "@auth0/angular-jwt";

import {Status} from "../classes/status";
import {Post} from "../classes/post";

@Component({
	templateUrl: "./templates/create-post.html",
	selector: "create-post"
})

export class CreatePostComponent implements OnInit {

	createPostForm: FormGroup;
	post: Post = new Post(null, null, null, null, null);
	status: Status = null;
	authObj: any = {};

	@Output() newPost = new EventEmitter<Post>();
	@Input() postReply: string = "";

	constructor(
		private formBuilder: FormBuilder,
		private jwtHelperService: JwtHelperService
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

	getJwtProfileId() : any {
		this.authObj = this.jwtHelperService.decodeToken(localStorage.getItem('jwt-token'));
	}

	createPost() : void {

		//grab profileId off of JWT
		this.getJwtProfileId();
		let newPostProfileId = this.authObj.auth.profileId;

		//form new post
		let post = new Post(null, newPostProfileId, this.createPostForm.value.postContent, null, this.createPostForm.value.postTitle);

		//emit new post to the post controller
		this.newPost.emit(post);
	}

}
