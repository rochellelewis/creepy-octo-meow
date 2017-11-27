import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../classes/status";

import {Post} from "../classes/post";
import {Profile} from "../classes/profile";

import {CookieService} from "ng2-cookies";
import {PostService} from "../services/post.service";
import {ProfileService} from "../services/profile.service";

//enable jquery $ alias
declare const $: any;

@Component({
	templateUrl: "./templates/create-post.html",
	selector: "create-post"
})

export class CreatePostComponent implements OnInit {

	createPostForm: FormGroup;
	post: Post = new Post(null, null, null, null, null);
	profile: Profile = new Profile(null, null, null, null, null, null);
	status: Status = null;

	cookieJar: any = {};

	constructor(
		private formBuilder: FormBuilder,
		private cookieService: CookieService,
		private postService: PostService,
		private profileService: ProfileService,
		private router: Router
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

	/*getProfile() : void {
		this.profileService.getProfile()
			.subscribe(this.profile);
	}*/

	createPost() : void {
		//get logged in profile of the author
		/*this.cookieJar = this.cookieService.getAll();
		this.profileService.getProfile(this.cookieJar["profileId"])
			.subscribe(profile => this.profile = profile);*/

		//form new post
		//let post = new Post(null, this.profile.id, this.createPostForm.value.postContent, null, this.createPostForm.value.postTitle);
		//post.postProfileId = this.profileService.getProfile(this.profile.profileId);

		/*this.postService.createPost(post)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.createPostForm.reset();

					console.log("post created ok");
					setTimeout(function(){$("#new-post-modal").modal("hide");}, 1000);
				} else {
					console.log("post not created");
				}
			});*/
	}

}
