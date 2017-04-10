import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {FeedComponent} from "./components/feed-component";
import {ProfileComponent} from "./components/profile-component";
import {NavbarComponent} from "./components/navbar-component";
import {CreatePostComponent} from "./components/create-post-component";
import {EditPostComponent} from "./components/edit-post-component";
import {DeletePostComponent} from "./components/delete-post-component";
import {LogInComponent} from "./components/login-component";
import {SignUpComponent} from "./components/signup-component";
import {EditProfileComponent} from "./components/edit-profile-component";

export const allAppComponents = [
	HomeComponent,
	FeedComponent,
	ProfileComponent,
	NavbarComponent,
	CreatePostComponent,
	EditPostComponent,
	DeletePostComponent,
	LogInComponent,
	SignUpComponent,
	EditProfileComponent
];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "feed", component: FeedComponent},
	{path: "profile/:id", component: ProfileComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);