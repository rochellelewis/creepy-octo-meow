import {HttpClient} from "@angular/common/http";
import {Injectable} from "@angular/core";
import {Observable} from "rxjs/Observable";
import {Status} from "../classes/status";
import {Profile} from "../classes/profile";

@Injectable ()
export class ProfileService {

	constructor(protected http:HttpClient) {}

	// define the API endpoint
	private profileUrl = "apis/profile/";

	// connect to the profile API and edit/update the profile
	editProfile(profile: Profile) : Observable<Status> {
		return(this.http.put<Status>(this.profileUrl + profile.id, profile));
	}

	// connect to profile API and get profile by id
	getProfile(id: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + id));
	}

	// connect to profile API and get profile by email
	getProfileByProfileEmail(profileEmail: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + profileEmail));
	}

	// connect to profile API and get profile by username
	getProfileByProfileUsername(profileUsername: string) : Observable<Profile> {
		return(this.http.get<Profile>(this.profileUrl + profileUsername));
	}

	// connect to profile API and get all profiles
	getAllProfiles() : Observable<Profile[]> {
		return(this.http.get<Profile[]>(this.profileUrl));
	}
}