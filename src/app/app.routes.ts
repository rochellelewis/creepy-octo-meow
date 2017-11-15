import {RouterModule, Routes} from "@angular/router";
import {APP_BASE_HREF} from "@angular/common";
import {HTTP_INTERCEPTORS} from "@angular/common/http";
import {DeepDiveInterceptor} from "./services/deep.dive.interceptor";

// import components
import {CreatePostComponent} from "./components/create-post.component";
import {DeletePostComponent} from "./components/delete-post.component";
import {EditPostComponent} from "./components/edit-post.component";
import {EditProfileComponent} from "./components/edit-profile.component";
import {FeedComponent} from "./components/feed.component";
import {HomeComponent} from "./components/home.component";
import {NavbarComponent} from "./components/navbar.component";
import {ProfileComponent} from "./components/profile.component";
import {SignInComponent} from "./components/sign-in.component";
import {SignUpComponent} from "./components/sign-up.component";

// import services
import {PostService} from "./services/post.service";
import {ProfileService} from "./services/profile.service";
import {SignInService} from "./services/sign-in.service";
import {SignUpService} from "./services/sign-up.service";

export const allAppComponents = [
	CreatePostComponent,
	DeletePostComponent,
	EditPostComponent,
	EditProfileComponent,
	FeedComponent,
	HomeComponent,
	NavbarComponent,
	ProfileComponent,
	SignInComponent,
	SignUpComponent
];

export const routes: Routes = [
	{path: "profile/:id", component: ProfileComponent},
	{path: "posts", component: FeedComponent},
	{path: "", component: HomeComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [
	{provide: APP_BASE_HREF, useValue: window["_base_href"]},
	{provide: HTTP_INTERCEPTORS, useClass: DeepDiveInterceptor, multi: true},
	PostService,
	ProfileService,
	SignInService,
	SignUpService
];

export const routing = RouterModule.forRoot(routes);