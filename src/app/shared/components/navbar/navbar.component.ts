import {Component} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../../classes/status";

import {CookieService} from "ng2-cookies";
import {SignInService} from "../../services/sign-in.service";
import {AuthService} from "../../services/auth-service";

@Component({
	template: require("./navbar.html"),
	selector: "navbar"
})

export class NavbarComponent {
	status: Status = null;
	isAuthenticated: any = null;
	profileUsername: string = null;

	constructor(
		private signInService: SignInService,
		private cookieService: CookieService,
		private authService: AuthService,
		private router: Router
	){
		this.isAuthenticated = this.authService.loggedIn();
		this.profileUsername = this.getUsername();
	}

	getUsername() : string {
		if(this.authService.decodeJwt()) {
			return this.authService.decodeJwt().auth.profileUsername;
		} else {
			return ''
		}
	}

	signOut() : void {
		this.signInService.getSignOut()

			.subscribe(status => {
				this.status = status;
				if(status.status === 200) {

					//delete cookies and jwt
					this.cookieService.deleteAll();
					localStorage.clear();

					//send user back home, refresh page
					this.router.navigate([""]);
					location.reload();
					console.log("goodbye");
				}
			});
	}
}