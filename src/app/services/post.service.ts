import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {Post} from "../classes/post";

import DateTimeFormat = Intl.DateTimeFormat;

@Injectable ()
export class PostService {

	constructor(protected http:HttpClient) {}

	// define the API endpoint
	private postUrl = "apis/post/";

	// connect to the post API and delete the post
	deletePost(id: number) : Observable<Status> {
		return(this.http.delete(this.postUrl + id)
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError));
	}

	// connect to the profile API and edit/update the post
	editPost(post: Post) : Observable<Status> {
		return(this.http.put(this.postUrl + post.id, post)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to the profile API and create the post
	createPost(post: Post) : Observable<Status> {
		return(this.http.post(this.postUrl, Post)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get post by id
	getPost(id: number) : Observable<Post> {
		return(this.http.get(this.postUrl + id)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get posts by profile id
	getPostsByProfileId(postProfileId : number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postProfileId, Post)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get posts by content
	getPostsByPostContent(postContent : string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postContent)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get posts by date range
	getPostsByPostDateRange(postDate: number) :Observable<Post[]> {
		return(this.http.get(this.postUrl + postDate)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get post by title
	getPostsByPostTitle(postTitle: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postTitle)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to post API and get all posts
	getAllPosts() : Observable<Post[]> {
		return(this.http.get(this.postUrl)
			.map(BaseService.extractData)
			.catch(BaseService.handleError)
		);
	}
}