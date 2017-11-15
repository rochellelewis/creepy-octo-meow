import {NgModule} from "@angular/core";
import {HttpClientModule, HttpResponse} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {ReactiveFormsModule} from "@angular/forms";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";

import {SessionService} from "./services/session.service";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, HttpClientModule, HttpResponse, ReactiveFormsModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [...appRoutingProviders]
})

export class AppModule {
	constructor(protected sessionService: SessionService) {}

	run() : void {
		this.sessionService.setSession().subscribe();
	}
}