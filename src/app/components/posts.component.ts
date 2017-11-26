import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
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

	createPostForm: FormGroup;
	editPostForm: FormGroup;

	deleted: boolean = false;

	post: Post = new Post();

	/*posts: Post[] = [];
	post: Post = new Post("", 0, "", "", "");
	status: Status = null;

	constructor(private postService: PostService, private router: Router) {}

	ngOnInit() : void {
		this.postService.getAllPosts().subscribe(posts => this.posts = posts);
	}*/

}
