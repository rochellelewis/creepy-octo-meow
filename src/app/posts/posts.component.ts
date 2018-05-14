import {Component, OnInit} from "@angular/core";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {switchMap, mergeMap} from "rxjs/operators";
import {forkJoin} from "rxjs/observable/forkJoin";

//import classes
import {Status} from "../shared/classes/status";
import {Post} from "../shared/classes/post";

//import services
import {AuthService} from "../shared/services/auth-service";
import {PostService} from "../shared/services/post.service";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/classes/profile";
import {Observable} from "rxjs/Observable";

//enable jquery $ alias
declare const $: any;

@Component({
	template: require("./posts.html")
})

export class PostsComponent implements OnInit {

	createPostForm: FormGroup;
	posts: Post[] = [];
	status: Status = null;
	id: any = null;

	profile$: Observable<Profile>;

	constructor(
		private formBuilder: FormBuilder,
		private authService: AuthService,
		private postService: PostService,
		private profileService: ProfileService
	){}

	ngOnInit() : void {

		this.listPosts();

		this.createPostForm = this.formBuilder.group({
			postTitle: ["", [Validators.maxLength(64), Validators.required]],
			postContent: ["", [Validators.maxLength(2000), Validators.required]]
		});
	}

	listPosts() : any {
		let getPosts$ = this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	getPostProfileUsername(id: string) : any {
		return this.profileService.getProfile(id);
	}

	getJwtProfileId() : any {
		if(this.authService.decodeJwt()) {
			return this.authService.decodeJwt().auth.profileId;
		} else {
			return false
		}
	}

	createPost() : any {

		//if no JWT profileId, return false (if u not logged in, u can't post!)
		if(!this.getJwtProfileId()) {
			return false
		}

		//grab profileId off of JWT
		let newPostProfileId = this.getJwtProfileId();

		//create new post
		let post = new Post(null, newPostProfileId, this.createPostForm.value.postContent, null, this.createPostForm.value.postTitle);

		this.postService.createPost(post)
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					this.createPostForm.reset();
					this.listPosts();
				}else{
					console.log('Not logged in!');
				}
			});
	}

}
