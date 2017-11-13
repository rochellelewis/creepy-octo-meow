import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {SignIn} from "../classes/sign-in";

@Injectable ()
export class SignInService {

	constructor (protected http:HttpClient) {}

	private signInUrl = "apis/signin/";
	private signOutUrl = "apis/signout/";

	// pre form the post to initiate sign in
	postSignIn(signIn: SignIn) : Observable<Status> {
		return(this.http.post<Status>(this.signInUrl, signIn));
	}

	getSignOut() : Observable<Status> {
		return(this.http.get<Status>(this.signOutUrl));
	}
}