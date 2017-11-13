import {Component, ViewChild, EventEmitter, Output, OnInit} from "@angular/core";
import {Router} from "@angular/router";
import {Status} from "../classes/status";

import {SignInService} from "../services/sign-in.service";
import {SignUpService} from "../services/sign-up.service";
import {ProfileService} from "../services/profile.service";
import {PostService} from "../services/post.service";

import {SignIn} from "../classes/sign-in";
import {Profile} from "../classes/profile";

@Component({
	templateUrl: "./templates/navbar.html",
	selector: "navbar"
})

export class NavbarComponent {

}