import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

import {Status} from "../shared/classes/status";
import {Post} from "../shared/classes/post";

import {JwtHelperService} from "@auth0/angular-jwt";
import {PostService} from "../shared/services/post.service";
import {ProfileService} from "../shared/services/profile.service";

//enable jquery $ alias
declare const $: any;

@Component({
	template: require("./posts.html")
})

export class PostsComponent implements OnInit {

	createPostForm: FormGroup;
	posts: Post[] = [];
	status: Status = null;
	authObj: any = {};

	//postUsername$: Observable<Profile[]>;
	//profiles: Profile[] = [];
	//postUsernames: any = [];
	//post: Post = new Post(null, null, null, null, null);
	//@Output() newPost = new EventEmitter<Post>();

	constructor(
		private formBuilder: FormBuilder,
		private postService: PostService,
		private profileService: ProfileService,
		private jwtHelperService: JwtHelperService
	){}

	ngOnInit() : void {
		//this.postService.getAllPosts().switchMap((id: string) => this.getPostProfileUsername(id));

		this.listPosts();
		//this.listProfiles();
		//this.getPostProfileUsernames(this.posts);

		this.createPostForm = this.formBuilder.group({
			postTitle: ["", [Validators.maxLength(64), Validators.required]],
			postContent: ["", [Validators.maxLength(2000), Validators.required]]
		});
		//this.applyFormChanges();
	}

	listPosts() : any {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
		/*return this.postService.getAllPosts()
			.switchMap(posts => this.profileService.getProfile(posts.postProfileId), (post, username) => [post, username]);*/
	}

	/*applyFormChanges() : void {
		this.createPostForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.post[field] = values[field];
			}
		});
	}*/

	getJwtProfileId() : any {
		// TODO: add if block here: if localStorage !== null else exception
		this.authObj = this.jwtHelperService.decodeToken(localStorage.getItem('jwt-token'));
	}

	createPost() : void {

		//grab profileId off of JWT
		this.getJwtProfileId();
		let newPostProfileId = this.authObj.auth.profileId;

		//form new post
		let post = new Post(null, newPostProfileId, this.createPostForm.value.postContent, null, this.createPostForm.value.postTitle);

		//emit new post to the post controller
		//this.newPost.emit(post);

		this.postService.createPost(post)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.listPosts();
					this.createPostForm.reset();
				}
			});
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




	/*listProfiles() : void {
		this.profileService.getAllProfiles()
			.subscribe(profiles => this.profiles = profiles);
	}*/

	/*postNewPost(newPost: Post) : void {

		this.postService.createPost(newPost)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.listPosts();
					console.log("post created ok " + status.message + " " + status.status);
					//this.postReply.emit(status);
				} else {
					console.log("post not meowed " + status.message + " " + status.status);
				}
			});
	}*/

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
