import {Component, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {FormBuilder, FormGroup, Validators} from "@angular/forms";

import {CookieService} from "ng2-cookies";
import {SignUpService} from "../../shared/services/sign-up.service";
import {Status} from "../../shared/classes/status";
import {Profile} from "../../shared/classes/profile";

//enable jquery $ alias
declare const $: any;

@Component({
	templateUrl: "./sign-up.html",
	selector: "sign-up"
})

export class SignUpComponent implements OnInit{

	signUpForm: FormGroup;
	profile: Profile = new Profile(null, null, null, null, null, null);
	status: Status = null;

	constructor(
		private formBuilder: FormBuilder,
		private signUpService: SignUpService,
		private router: Router
	){}

	ngOnInit() : void {
		this.signUpForm = this.formBuilder.group({
			profileEmail: ["", [Validators.maxLength(64), Validators.required]],
			profileUsername: ["", [Validators.maxLength(64), Validators.required]],
			profilePassword: ["", [Validators.maxLength(250), Validators.required]],
			profileConfirmPassword: ["", [Validators.maxLength(250), Validators.required]]
		});
		this.applyFormChanges();
	}

	applyFormChanges() : void {
		this.signUpForm.valueChanges.subscribe(values => {
			for(let field in values) {
				this.profile[field] = values[field];
			}
		});
	}

	signUp() : void {
		this.signUpService.postProfile(this.profile)
			.subscribe(status => {
				this.status = status;
				if(this.status.status === 200) {
					this.signUpService.postProfile(this.profile);
					this.signUpForm.reset();
					console.log("signup successful");
					setTimeout(function(){$("#signup-modal").modal("hide");}, 5000);
				} else {
					console.log("signup fail");
				}
			});
	}
}
