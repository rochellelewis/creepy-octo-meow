import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {Observable} from "rxjs";
import {Status} from "../classes/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import "rxjs/add/observable/from";

@Component({
	templateUrl: "./templates/post.html"
})

export class PostComponent {

	/*posts: Post[] = [];
	post: Post = new Post("", 0, "", "", "");
	status: Status = null;

	constructor(private postService: PostService, private router: Router) {}

	ngOnInit() : void {
		this.postService.getAllPosts().subscribe(posts => this.posts = posts);
	}*/

}
