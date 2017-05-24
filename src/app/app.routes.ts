import {RouterModule, Routes} from "@angular/router";

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
	{path: "feed", component: FeedComponent},
	{path: "", component: HomeComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);