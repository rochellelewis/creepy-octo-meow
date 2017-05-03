import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";

@Component({
	templateUrl: "./templates/feed.php"
})

export class FeedComponent implements OnInit {

	posts: Post[] = [];
	post: Post = new Post(0, 0, "", "", "");
	status: Status = null;

	constructor(private postService: PostService, private router: Router) {}

	ngOnInit() : void {
		this.postService.getAllPosts().subscribe(posts => this.posts = posts);
	}

}
