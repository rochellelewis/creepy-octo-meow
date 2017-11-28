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
		//this.listPosts();

		//this.listPosts()
			//.switchMap();
	}

	// this causes an infinite loop of calls
	getPostProfileUsername(id: string) : any {
		this.profileService.getProfile(id)
			.subscribe(profile => this.profile = profile);
		return this.profile.profileUsername;
	}
	//{{ getPostProfileUsername(post.postProfileId) }}
	//{{ getPostProfileUsername(post.postProfileId) | async }}

	listPosts() : any {

		//grab profile
		//const postProfile = this.http.get<Profile>(profileUrl + id);

		//get profile username
		//const postProfileUsername = postProfile.profileUsername;

		//subscribe
		//post.subscribe();

		//parallel.subscribe(profile => this.profile = profile);




		///////////////////////////////
		/*this.postService.getAllPosts()
		.subscribe(posts => this.posts = posts);*/
	}
}
