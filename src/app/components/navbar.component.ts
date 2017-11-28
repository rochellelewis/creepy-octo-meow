import {Component} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";

import {CookieService} from "ng2-cookies";
import {SignInService} from "../services/sign-in.service";

import {SignUpService} from "../services/sign-up.service";
import {ProfileService} from "../services/profile.service";

import {SignIn} from "../classes/sign-in";
import {Profile} from "../classes/profile";

//enable jquery $ alias
declare const $: any;

@Component({
	templateUrl: "./templates/navbar.html",
	selector: "navbar"
})

export class NavbarComponent {
	status: Status = null;

	constructor(
		private signInService: SignInService,
		private cookieService: CookieService,
		private router: Router
	){}

	signOut() : void {
		this.signInService.getSignOut()
			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {
					//this.cookieService.deleteAll();
					localStorage.clear();
					this.router.navigate([""]);
					//location.reload();
					console.log("goodbye");
				}
			});
	}
}