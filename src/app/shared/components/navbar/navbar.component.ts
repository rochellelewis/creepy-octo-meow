import {Component} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../../classes/status";

import {CookieService} from "ng2-cookies";
import {SignInService} from "../../services/sign-in.service";

@Component({
	//templateUrl: "./navbar.html",
	template: require("./navbar.html"),
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