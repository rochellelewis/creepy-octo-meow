import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";
import {CookieService} from "ng2-cookies";

import {SessionService} from "../services/session.service";
import {SignInService} from "../services/sign-in.service";
import {SignIn} from "../classes/sign-in";

//enable jquery $ alias
declare const $: any;

@Component({
	templateUrl: "./templates/sign-in.html",
	selector: "sign-in"
})

export class SignInComponent implements OnInit {

	signInForm: FormGroup;
	signin: SignIn = new SignIn(null, null);
	status: Status = null;

	constructor(
		private cookieService: CookieService,
		private sessionService: SessionService,
		private formBuilder: FormBuilder,
		private signInService: SignInService,
		private router: Router) {}

	ngOnInit() : void {
		this.signInForm = this.formBuilder.group({
			profileEmail: ["", [Validators.maxLength(64), Validators.required]],
			profilePassword: ["", [Validators.maxLength(255), Validators.required]]
		});
		this.applyFormChanges();
	}

	applyFormChanges() : void {
		this.signInForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.signin[field] = values[field];
			}
		});
	}

	signIn() : void {
		this.signInService.postSignIn(this.signin)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.sessionService.setSession();
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
