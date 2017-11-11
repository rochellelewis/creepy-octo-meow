import {NgModule} from "@angular/core";
import {HttpClientModule} from "@angular/common/http";
import {BrowserModule} from "@angular/platform-browser";
import {ReactiveFormsModule} from "@angular/forms";
import {AppComponent} from "./app.component";
import {allAppComponents, appRoutingProviders, routing} from "./app.routes";

/*
import {PostService} from "./services/post.service";
import {ProfileService} from "./services/profile.service";
import {SignInService} from "./services/sign-in.service";
import {SignOutService} from "./services/sign-out.service";
import {SignUpService} from "./services/sign-up.service";
*/

const moduleDeclarations = [AppComponent];

@NgModule({
	imports:      [BrowserModule, HttpClientModule, ReactiveFormsModule, routing],
	declarations: [...moduleDeclarations, ...allAppComponents],
	bootstrap:    [AppComponent],

	/**update services in providers array below:*/
	providers:    [...appRoutingProviders]
})

export class AppModule {}