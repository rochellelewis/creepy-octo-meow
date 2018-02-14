import {Component} from "@angular/core";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";
import "rxjs/add/operator/switchMap";

@Component({
	template: require("./about.html")
})

export class AboutComponent {}
