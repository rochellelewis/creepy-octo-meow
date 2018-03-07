// import @angular dependencies
import {RouterModule, Routes} from "@angular/router";
import {AuthGuardService as AuthGuard} from "./shared/services/auth-guard.service";

// import components
import {PostsComponent} from "./posts/posts.component"
import {HomeComponent} from "./home/home.component";
import {NavbarComponent} from "./shared/components/navbar/navbar.component";
import {ProfileComponent} from "./profile/profile.component";
import {SignInComponent} from "./shared/components/sign-in/sign-in.component";
import {SignUpComponent} from "./sign-up/sign-up.component";
import {AboutComponent} from "./about/about.component";

// import services
import {AuthService} from "./shared/services/auth-service";
import {AuthGuardService} from "./shared/services/auth-guard.service";
import {CookieService} from "ng2-cookies";
import {SessionService} from "./shared/services/session.service";
import {PostService} from "./shared/services/post.service";
import {ProfileService} from "./shared/services/profile.service";
import {SignInService} from "./shared/services/sign-in.service";
import {SignUpService} from "./shared/services/sign-up.service";

// import interceptors
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./shared/interceptors/deep.dive.interceptor";

// array of components to be passed off to the module
export const allAppComponents = [
	PostsComponent,
	HomeComponent,
	NavbarComponent,
	ProfileComponent,
	SignInComponent,
	SignUpComponent,
	AboutComponent
];

// setup routes
export const routes: Routes = [
	{path: "profile/:id", component: ProfileComponent},
	{path: "posts", component: PostsComponent, canActivate: [AuthGuard]},
	{path: "about", component: AboutComponent},
	{path: "", component: HomeComponent},
	{path: "**", redirectTo: ""}
];

// array of services
const services: any[] = [
	AuthService,
	AuthGuardService,
	CookieService,
	SessionService,
	PostService,
	ProfileService,
	SignInService,
	SignUpService
];

// array of providers
const providers : any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true}
];

export const appRoutingProviders: any[] = [providers, services];

export const routing = RouterModule.forRoot(routes);