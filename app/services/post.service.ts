import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Post, Profile} from "../classes/post";
import {Observable} from "rxjs/Observable";

import {DateTimeFormat} = Intl.DateTimeFormat;

@Injectable ()
export class PostService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	// define the API endpoint
	private postUrl = "api/post/";

	// connect to the post API and delete the post
	deletePost(id: number) : Observable<Status> {
		return(this.http.delete(this.postUrl + id)
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError));
	}

	// connect to the profile API and edit/update the post
	editPost(post: Post) : Observable<Status> {
		return(this.http.get(this.postUrl + post.id, post)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to the profile API and create the post
	createPost(post: Post) : Observable<Status> {
		return(this.http.get(this.postUrl, Post)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get post by id
	getPost(id: number) : Observable<Post> {
		return(this.http.get(this.postUrl, Post)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get posts by profile id
	getPostsByProfileId(postProfileId : number) : Observable<Post[]> {
		return(this.http.get()

		);
	}

	// connect to post API and get posts by content

	// connect to post API and get posts by date range

	// connect to post API and get post by title

	// connect to post API and get all posts
}