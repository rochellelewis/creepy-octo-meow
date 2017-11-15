import {Injectable} from "@angular/core";
import {HttpClient} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {Response} from "@angular/http";

@Injectable()
export class SessionService {

	constructor(protected http: HttpClient) {}

	private sessionUrl = "apis/session/";

	setSession() : Observable<Response> {
		return (this.http.get(this.sessionUrl)
			.map((response : Response) => response));
	}
}