import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ForkJoinObservable} from "rxjs/observable/ForkJoinObservable";
import {Status} from "../classes/status";

import {Post} from "../classes/post";
import {Profile} from "../classes/profile";

import {PostService} from "../services/post.service";
import {ProfileService} from "../services/profile.service";

import 'rxjs/add/operator/switchMap';

@Component({
	templateUrl: "./templates/post.html"
})

export class PostsComponent implements OnInit {

	post: Post = new Post(null, null, null, null, null);
	profile: Profile = new Profile(null, null, null, null, null, null);

	posts: Post[] = [];
	profiles: Profile[] = [];
	postUsernames: any = [];

	status: Status = null;

	constructor(
		private postService: PostService,
		private profileService: ProfileService
	){}

	ngOnInit() : void {
		this.listPosts();
		this.getPostProfileUsernames(this.posts);
	}

	// this causes an infinite loop of calls
	/*getPostProfileUsername(id: string) : any {
		this.profileService.getProfile(id)
			.subscribe(profile => this.profile = profile);
		return this.profile.profileUsername;
	}*/

	listPosts() : void {
		this.postService.getAllPosts()
		.subscribe(posts => this.posts = posts);
	}

	getPostProfileUsernames(posts: Post[]) : any {
		//let postUsernames = [];

		for(let post of posts) {
			this.profileService.getProfile(post.postProfileId)
				.subscribe(profiles => this.profiles = profiles);
			this.postUsernames.push(this.profile.profileUsername);
		}

		//console.log(this.postUsernames);
		return this.postUsernames;
	}

	//{{ getPostProfileUsername(post.postProfileId) }}
	//{{ getPostProfileUsername(post.postProfileId) | async }}
}
