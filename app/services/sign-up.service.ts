import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Observable} from "rxjs/Observable";

@Injectable()
export class SignUpService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	private signUpUrl = "apis/signup";

	createProfile(profile: Profile) : Observable<Status> {
		return(this.http.post(this.signUpUrl, profile)
			.map(BaseService.extractData)
			.catch(BaseService.handleError)
		);
	}
}