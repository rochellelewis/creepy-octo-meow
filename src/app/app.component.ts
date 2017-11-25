import {Component} from "@angular/core";
import {SessionService} from "./services/session.service";
import {Status} from "./classes/status";

// import {SignInService} from "./services/sign-in.service";
// import {SignInComponent} from "./components/sign-in.component";

@Component({
	// Update selector with YOUR_APP_NAME-app. This needs to match the custom tag in webpack/index.php
	selector: 'creepy-octo-meow',

	// templateUrl path to your public_html/templates directory. .html files only.
	templateUrl: './templates/creepy-octo-meow.html'
})

export class AppComponent {
	status: Status = null;

	constructor(protected sessionService: SessionService) {
		this.sessionService.setSession()
			.subscribe(status => this.status = status);
	}
}
