import {RouterModule, Routes} from "@angular/router";
import {HomeComponent} from "./components/home-component";
import {FeedComponent} from "./components/feed-component";

export const allAppComponents = [HomeComponent, FeedComponent];

export const routes: Routes = [
	{path: "", component: HomeComponent},
	{path: "feed", component: FeedComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);