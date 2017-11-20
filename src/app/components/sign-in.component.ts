import {Component, ViewChild, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";

import {SessionService} from "../services/session.service";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";

//enable jquery $ alias
declare const $: any;

@Component({
	templateUrl: "./templates/sign-in.html",
	selector: "sign-in"
})

export class SignInComponent {

	@ViewChild("signInForm") signInForm : any;
	signin: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(
		private sessionService: SessionService,
		private signInService: SignInService,
		private router: Router
	) {}

	isSignedIn = false;

	ngOnChanges() : void {
		this.isSignedIn = this.signInService.isSignedIn;
	}

	signIn() : void {
		this.signInService.postSignIn(this.signin)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.sessionService.setSession();
					this.isSignedIn = true;
					this.signInService.isSignedIn = true;
					this.signInForm.reset();
					this.router.navigate(["posts"]);
					console.log("signin successful");
					setTimeout(function(){$("#signin-modal").modal('hide');},1000);
				} else {
					console.log("failed login");
				}
			});
	}
}
