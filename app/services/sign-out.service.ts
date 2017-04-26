import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {BaseService} from "./base.service";
import {Status} from "../classes/status";
import {Observable} from "rxjs/Observable";

@Injectable()
export class SignOutService extends BaseService {

	constructor(protected http:Http) {
		super(http);
	}

	private signOutUrl = "/apis/signout/"
}