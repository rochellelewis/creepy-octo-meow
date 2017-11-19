import {Injectable} from "@angular/core";
import {HttpEvent, HttpHandler, HttpInterceptor, HttpRequest, HttpResponse} from "@angular/common/http";
import {Observable} from "rxjs/Observable";

/**
 * class that intercepts data for Deep Dive's API standard
 *
 * All APIs in Deep Dive return an object with three state variables:
 *
 * 1. status (int, required): 200 if successful, any other integer if not
 * 2. data (any, optional): result of a GET request
 * 3. message (string, optional): status message result of a non GET request
 *
 * this interceptor will use the HttpResponse to return either the data or the status message
 **/
@Injectable()
export class DeepDiveInterceptor implements HttpInterceptor {

	/**
	 * intercept method that extracts the data or status message based on standards outlined above
	 *
	 * @param {HttpRequest<any>} request incoming HTTP request
	 * @param {HttpHandler} next outgoing handler for next interceptor
	 * @returns {Observable<HttpEvent<any>>} Observable for next interceptor to subscribe to
	 **/
	intercept(request: HttpRequest<any>, next: HttpHandler): Observable<HttpEvent<any>> {
		// hand off to the next interceptor

		const clonedRequest = request.clone({
			responseType: "text"
		});

		return(next.handle(clonedRequest).map((event: HttpEvent<any>) => {
			// if this is an HTTP Response, from Angular...
			if(event instanceof HttpResponse) {

				// create an event to return (by default, return the same event)
				let dataEvent = event;

				// extract the data or message from the response body
				let body = event.body;

				dataEvent = dataEvent.clone<any>({body: JSON.parse(dataEvent.body)});
				return(dataEvent);
			}
		}));
	}
}