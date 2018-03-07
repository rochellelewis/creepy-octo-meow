import {Component, OnInit} from "@angular/core";
import {ActivatedRoute} from "@angular/router";
import {Status} from "../shared/classes/status";

import {Profile} from "../shared/classes/profile";

import {AuthService} from "../shared/services/auth-service";
import {ProfileService} from "../shared/services/profile.service";

@Component({
	template: require("./profile.html")
})

export class ProfileComponent implements OnInit {

	profileId : string = this.route.snapshot.params["id"];

	//for testing only - grab current logged in profileId off JWT
	tempId: string = this.authService.decodeJwt().auth.profileId;

	profile: Profile = new Profile(null,null,null,null,null,null);

	constructor(
		private authService: AuthService,
		private profileService: ProfileService,
		private route: ActivatedRoute
	) {}

	ngOnInit() : void {
		this.getUser();
	}

	getUser() : void {
		//for testing
		/*this.profileService.getProfile(this.tempId)
			.subscribe(profile => this.profile = profile);*/

		//live
		this.profileService.getProfile(this.profileId)
			.subscribe(profile => this.profile = profile);
	}

}