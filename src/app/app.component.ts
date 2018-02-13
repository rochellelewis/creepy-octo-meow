import {Component} from "@angular/core";
import {SessionService} from "./shared/services/session.service";
import {Status} from "./shared/classes/status";

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
