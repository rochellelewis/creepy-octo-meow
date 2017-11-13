import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";

@Injectable()
export class SignUpService {

	constructor(protected http:HttpClient) {}

	private signUpUrl = "apis/signup";

	createProfile(profile: Profile) : Observable<Status> {
		return(this.http.post<Status>(this.signUpUrl, profile));
	}
}