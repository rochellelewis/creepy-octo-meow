import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {Post} from "../classes/post";

@Injectable ()
export class PostService {

	constructor(protected http:HttpClient) {}

	// define the API endpoint
	private postUrl = "apis/post/";

	// connect to the post API and delete the post
	deletePost(id: string) : Observable<Status> {
		return(this.http.delete<Status>(this.postUrl + id));
	}

	// connect to the profile API and edit/update the post
	editPost(post: Post) : Observable<Status> {
		return(this.http.put<Status>(this.postUrl + post.id, post));
	}

	// connect to the profile API and create the post
	createPost(post: Post) : Observable<Status> {
		return(this.http.post<Status>(this.postUrl, post));
	}

	// connect to post API and get post by id
	getPost(id: string) : Observable<Post> {
		return(this.http.get<Post>(this.postUrl + id));
	}

	// connect to post API and get posts by profile id
	getPostsByProfileId(postProfileId : string) : Observable<Post> {
		return(this.http.get<Post>(this.postUrl + postProfileId));
	}

	// connect to post API and get posts by content
	getPostsByPostContent(postContent : string) : Observable<Post> {
		return(this.http.get<Post>(this.postUrl + postContent));
	}

	// connect to post API and get posts by date range
	getPostsByPostDateRange(postDate: string) :Observable<Post> {
		return(this.http.get<Post>(this.postUrl + postDate));
	}

	// connect to post API and get post by title
	getPostsByPostTitle(postTitle: string) : Observable<Post> {
		return(this.http.get<Post>(this.postUrl + postTitle));
	}

	// connect to post API and get all posts
	getAllPosts() : Observable<Post[]> {
		return(this.http.get<Post[]>(this.postUrl));
	}
}