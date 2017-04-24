import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base-service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class ActivationService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	// define the API endpoint
	private activationUrl = "api/activation/";

	// connect to profile API and get profile by id
	getActivation(activation: string) : Observable<Status> {
		return(this.http.get(this.activationUrl + "?profileActivationToken" + activation)
		.map(BaseService.extractData)
		.catch(BaseService.handleError));
	}
}