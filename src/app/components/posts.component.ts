import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {Status} from "../classes/status";

import {Post} from "../classes/post";
import {Profile} from "../classes/profile";

import {PostService} from "../services/post.service";
import {ProfileService} from "../services/profile.service";

@Component({
	templateUrl: "./templates/post.html"
})

export class PostsComponent implements OnInit {

	profile: Profile = new Profile(null, null, null, null, null, null);

	posts: Post[] = [];
	status: Status = null;

	constructor(
		private postService: PostService
	){}

	ngOnInit() : void {
		this.listPosts();
	}

	listPosts() : void {
		this.postService.getAllPosts()
		.subscribe(posts => this.posts = posts);
	}
}
