<?php
if(session_status() !== PHP_SESSION_ACTIVE) {
	session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<script>
			(function() {
				var basePath = "/";
				var baseIndex = location.pathname.split("/").findIndex(function(directory) {
					return(directory === "public_html");
				});
				if(baseIndex >= 0) {
					basePath = location.pathname.split("/").splice(0, baseIndex + 1).join("/") + "/";
				}
				window["_base_href"] = basePath;
				document.write("<base href=\"" + basePath + "\" />");
			})();
		</script>

		<title>Creepy Octo Meow</title>
	</head>
	<body class="sfooter">
		<!-- This custom tag much match your Angular @Component selector name in app/app.component.ts -->
		<creepy-octo-meow>Loading&hellip;</creepy-octo-meow>
	</body>
</html>