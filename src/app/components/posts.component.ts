import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {AsyncPipe} from "@angular/common";
import {Status} from "../classes/status";

import {Post} from "../classes/post";
import {Profile} from "../classes/profile";

import {PostService} from "../services/post.service";
import {ProfileService} from "../services/profile.service";

@Component({
	templateUrl: "./templates/post.html"
})

export class PostsComponent implements OnInit {

	post: Post = new Post(null, null, null, null, null);
	profile: Profile = new Profile(null, null, null, null, null, null);

	posts: Post[] = [];
	profiles: Profile[] = [];

	status: Status = null;

	constructor(
		private postService: PostService,
		private profileService: ProfileService
	){}

	ngOnInit() : void {
		this.listPosts();
	}

	getPostProfileUsername(id: string) : string {
		this.profileService.getProfile(id)
			.subscribe(profile => this.profile = profile);
		return this.profile.profileUsername;
	}

	//{{ getPostProfileUsername(post.postProfileId) }}
	//{{ getPostProfileUsername(post.postProfileId) | async }}

	listPosts() : void {
		this.postService.getAllPosts()
		.subscribe(posts => this.posts = posts);
	}
}
