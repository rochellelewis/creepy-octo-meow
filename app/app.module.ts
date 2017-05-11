import {NgModule} from "@angular/core";
import {BrowserModule} from "@angular/platform-browser";
import {FormsModule} from "@angular/forms";
import {HttpModule} from "@angular/http";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";

import {BaseService} from "./services/base.service";
import {PostService} from "./services/post.service";
import {ProfileService} from "./services/profile.service";
import {SignInService} from "./services/sign-in.service";
import {SignOutService} from "./services/sign-out.service";
import {SignUpService} from "./services/sign-up.service";

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, FormsModule, HttpModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],
	providers:    [
		appRoutingProviders,
		PostService,
		ProfileService,
		SignInService
	]
})

export class AppModule {}