import {Component, OnInit, Input, ViewChild} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {ForkJoinObservable} from "rxjs/observable/ForkJoinObservable";
import {Status} from "../classes/status";

import {Post} from "../classes/post";
import {Profile} from "../classes/profile";

import {JwtHelperService} from "@auth0/angular-jwt";
import {PostService} from "../services/post.service";
import {ProfileService} from "../services/profile.service";

import 'rxjs/add/operator/switchMap';
import {CreatePostComponent} from "./create-post.component";

//enable jquery $ alias
declare const $: any;

@Component({
	templateUrl: "./templates/post.html"
})

export class PostsComponent implements OnInit {

	post: Post = new Post(null, null, null, null, null);
	profile: Profile = new Profile(null, null, null, null, null, null);

	posts: Post[] = [];
	profiles: Profile[] = [];

	postUsername$: Observable<Profile[]>;
	//postUsernames: any = [];

	@Input() newPost : Post = new Post(null, null, null, null, null);
	@ViewChild(CreatePostComponent) createPost: CreatePostComponent;

	authObj: any = {};
	status: Status = null;

	constructor(
		private postService: PostService,
		private profileService: ProfileService,
		private jwtHelperService: JwtHelperService
	){}

	ngOnInit() : void {
		//this.postService.getAllPosts().switchMap((id: string) => this.getPostProfileUsername(id));

		this.listPosts();
		this.listProfiles();

		//console.log();
		//this.getPostProfileUsernames(this.posts);
	}

	// this causes an infinite loop of calls
	// {{ getPostProfileUsername(post.postProfileId) }}
	/*getPostProfileUsername(id: string) : any {
		this.profileService.getProfile(id)
			.subscribe(profile => this.profile = profile);
		return this.profile.profileUsername;
	}*/

	/*getPostProfileUsername(posts: Post[]) : any {
		this.profileService.getProfile(post.postProfileId)
			.subscribe(profile => this.profile = profile);
		return this.profile.profileUsername;
	}*/


	listPosts() : any {
		this.postService.getAllPosts()
		.subscribe(posts => this.posts = posts);
		/*return this.postService.getAllPosts()
			.switchMap(posts => this.profileService.getProfile(posts.postProfileId), (post, username) => [post, username]);*/
	}

	listProfiles() : void {
		this.profileService.getAllProfiles()
			.subscribe(profiles => this.profiles = profiles);
	}

	getJwtProfileId() : any {
		this.authObj = this.jwtHelperService.decodeToken(localStorage.getItem('jwt-token'));
	}

	postPost() : void {

		//grab profileId off of JWT
		//this.getJwtProfileId();
		//let newPostProfileId = this.authObj.auth.profileId;

		//form new post
		let post = this.newPost;

		this.postService.createPost(post)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					//this.reloadPosts();
					//this.updatePosts.emit(this.posts);
					//console.log(this.posts);

					//this.createPostForm.reset();
					this.createPost.createPostForm.reset();
					this.listPosts();

					//this.router.navigate(["posts"]);
					setTimeout(function(){$("#new-post-modal").modal("hide");}, 1000);

					console.log("post created ok");
				} else {
					console.log("post not created");
				}
			});
	}

	/*getPostProfileUsernames(posts: Post[]) : Observable<Profile> {
		/!*return this.listPosts$()
			.switchMap(posts => this.profileService.getProfile(posts.postProfileId),
				(posts, usernames) => [posts, usernames]);*!/

		//console.log(posts);
		for(let post in posts) {
			this.profileService.getProfile(post.postProfileId)
				.subscribe(profiles => this.profiles = profiles);
			this.postUsernames.push(this.profile.profileUsername);
		}

		//console.log(this.postUsernames);
		return this.postUsernames;
	}
*/


	//{{ getPostProfileUsername(post.postProfileId) | async }}
}
