export class Post {
	constructor(
		public id: number,
		public postProfileId: number,
		public postContent: string,
		public postDate: string,
		public postTitle: string
	){}
}