import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Post} from "../classes/post";
import {PostService} from "../services/post.service";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";

@Component({
	templateUrl: "./templates/feed.php"
})

export class FeedComponent implements OnInit {

	postsFiltered : Post[] = [];
	postObservable : Observable<Post> = null;

	constructor(private postService: PostService, private router: Router) {}

	ngOnInit() : void {
		this.postService.getAllPosts();
	}

}
