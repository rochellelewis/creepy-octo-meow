export class Profile {
	constructor(
		public id: number,
		public profileActivationToken: string,
		public profileEmail: string,
		public profilePassword: string,
		public profileConfirmPassword: string,
		public profileUsername: string
	){}
}