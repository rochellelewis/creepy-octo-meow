import {Component, ViewChild, EventEmitter, Output} from "@angular/core";
import {Router} from "@angular/router";
import {Observable} from "rxjs/Observable";

import {SignInService} from "../services/sign-in.service";
import {ProfileService} from "../services/profile.service";

import {Profile} from "../classes/profile";
import {Status} from "../classes/status";
import {SignIn} from "../classes/sign-in";

declare var $: any;

@Component({
	templateUrl: "./templates/sign-in.php",
	selector: "sign-in"
})

export class SignInComponent {

	@ViewChild("signInForm") signInForm : any;

	signin: SignIn = new SignIn("", "");
	//profile: Profile = new Profile(0, "", "", "", "", "");
	status: Status = null;

	constructor(private signInService: SignInService, private router: Router) {}

	isSignedIn = false;

	ngOnChanges() : void {
		this.isSignedIn = this.signInService.isSignedIn;
	}

	signIn() : void {
		this.signInService.postSignIn(this.signin).subscribe(status => {
			this.status = status;
			if(status.status === 200) {
				this.router.navigate(["feed"]);
				this.signInForm.reset();
				//location.reload(true);
				this.signInService.isSignedIn = true;
				this.isSignedIn = true;
				setTimeout(function(){$("#signin-modal").modal("hide");}, 250);
			}
		});
	}
}
