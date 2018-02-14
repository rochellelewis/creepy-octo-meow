import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {ProfileService} from "../shared/services/profile.service";
import {Profile} from "../shared/classes/profile";
import {Status} from "../shared/classes/status";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";
import "rxjs/add/operator/switchMap";

@Component({
	//templateUrl: "./home.html"
	template: require("./home.html")
})

export class HomeComponent {}
