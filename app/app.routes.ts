import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {FeedComponent} from "./components/feed-component";
import {ProfileComponent} from "./components/profile-component";

export const allAppComponents = [HomeComponent, FeedComponent, ProfileComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "feed", component: FeedComponent},
	{path: "profile", component: ProfileComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);