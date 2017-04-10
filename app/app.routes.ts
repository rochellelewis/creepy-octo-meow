import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {FeedComponent} from "./components/feed-component";
import {ProfileComponent} from "./components/profile-component";
import {NavbarComponent} from "./components/navbar-component";

export const allAppComponents = [HomeComponent, FeedComponent, ProfileComponent, NavbarComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "feed", component: FeedComponent},
	{path: "profile/:id", component: ProfileComponent},
	{path: "**", redirectTo: ""}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);