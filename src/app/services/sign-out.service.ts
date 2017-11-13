import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";

@Injectable()
export class SignOutService {

	constructor(protected http:HttpClient) {}

	private signOutUrl = "apis/signout/";

	getSignOut() : Observable<Status> {
		return(this.http.get(this.signOutUrl)
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError));
	}
}