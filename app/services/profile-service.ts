import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base-service";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";
import {Observable} from "rxjs/Observable";

@Injectable ()
export class ProfileService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	// define the API endpoint
	private profileUrl = "api/profile";

	// connect to the profile API and delete the profile
	deleteProfile(id: number) : Observable<Status> {
		return(this.http.delete(this.profileUrl + id)
			.map(BaseService.extractMessage)
			.catch(BaseService.handleError));
	}

	// connect to the profile API and edit/update the profile
	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.get(this.profileUrl + id)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to profile API and get profile by id
	getProfile(id: number) : Observable<Profile> {
		return(this.http.get(this.profileUrl + id)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to profile API and get profile by activation token
	getProfileByProfileActivationToken(profileActivationToken: string) : Observable<Profile[]> {
		return(this.http.get(this.profileUrl + profileActivationToken)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to profile API and get profile by email
	getProfileByProfileEmail(profileEmail: string) : Observable<Profile[]> {
		return(this.http.get(this.profileUrl + profileEmail)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}

	// connect to profile API and get profile by username
	getProfileByProfileUsername(profileUsername: string) : Observable<Profile[]> {
		return(this.http.get(this.profileUrl + profileUsername)
			.map(BaseService.extractData)
			.catch(BaseService.handleError));
	}
}