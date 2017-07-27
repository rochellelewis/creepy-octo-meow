<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8"/>
		<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
		<meta name="viewport" content="width=device-width, initial-scale=1"/>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<!-- Font Awesome -->
		<link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css"
				rel="stylesheet"/>

		<!-- Custom CSS Goes HERE -->
		<link rel="stylesheet" href="css/style.css" type="text/css">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- jQuery - required for Bootstrap Components -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.min.js"></script>

		<!-- Latest compiled and minified JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				  integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				  crossorigin="anonymous"></script>

		<title>Creepy Octo Meow | Vue.js</title>
	</head>
	<body>

		<div class="container">

			<header>
				<h2>Vue.js Sandbox</h2>
			</header>

			<div id="app" class="well">
				{{ message }}
			</div>

			<div id="app-2" class="well">
				<!-- v-bind is a directive -->
				<span v-bind:title="message">Hover your mouse over me for a few seconds to see my dynamically bound title!</span>
			</div>

			<div id="app-3" class="well">
				<p v-if="seen">Now you see me</p>
			</div>

			<div id="app-4" class="well">
				<ol>
					<li v-for="todo in todos">
						{{ todo.text }}
					</li>
				</ol>
			</div>

			<div id="app-5" class="well">
				<p class="lead">{{ message }}</p>
				<button class="btn btn-info" v-on:click="reverseMessage">Reverse Message</button>
			</div>

			<div id="app-6" class="well">
				<p>{{ message }}</p>
				<input type="text" class="form-control" v-model="message">
			</div>

			<div id="app-7" class="well">
				<ol>
					<!--
					  Now we provide each todo-item with the todo object
					  it's representing, so that its content can be dynamic.
					  We also need to provide each component with a "key",
					  which will be explained later.
					-->
					<todo-item
						v-for="item in groceryList"
						v-bind:todo="item"
						v-bind:key="item.id">
					</todo-item>
				</ol>
			</div>

		</div>

		<!-- vue.js development -->
		<script src="assets/vue.js"></script>
		<script src="js/app.js"></script>
	</body>
</html>