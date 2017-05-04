import {Component, OnInit} from "@angular/core";
import {ProfileService} from "../services/profile.service";
import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";
import {ActivatedRoute, Params} from "@angular/router";

@Component({
	templateUrl: "./templates/profile.php"
})

export class ProfileComponent implements OnInit{

	profile: Profile = new Profile(0, "", "", "", "", "");
	status: Status = null;

	constructor(private profileService: ProfileService, private route: ActivatedRoute) {}

	ngOnInit() : void {
		this.route.params.forEach((params : Params) => {
			let profileId = +params["id"];
			this.profileService.getProfile(profileId).subscribe(profile => this.profile = profile);
		});
	}

	editProfile() : void {
		this.profileService.editProfile(this.profile).subscribe(status => this.status = status);
	}
}
