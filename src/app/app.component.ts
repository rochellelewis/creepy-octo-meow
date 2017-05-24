import {Component, ViewChild} from "@angular/core";
import {SignInComponent} from "./components/sign-in.component";
import {SignInService} from "./services/sign-in.service";

@Component({
	// Update selector with YOUR_APP_NAME-app. This needs to match the custom tag in webpack/index.php
	selector: 'creepy-octo-meow',

	// templateUrl path to your public_html/templates directory.
	templateUrl: './templates/creepy-octo-meow.php'
})

export class AppComponent {
	constructor(private signInService: SignInService) {}

	@ViewChild(SignInComponent)
		private signInComponent: SignInComponent;

	isSignedIn = false;

}
