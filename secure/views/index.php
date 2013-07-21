<!DOCTYPE HTML>
<html>
  <head>
	<meta charset="utf-8" />
    <title>App Name</title>
    
    <!-- Bootstrap -->
    <link href="style/bootstrap.min.css" rel="stylesheet">
    <link href="style/bootstrap-responsive.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
  </head>
  <body>
	<script src="scripts/lib/LAB.min.js"></script>
	<script>
	
	//Name Spaces
		var App = {
			Model: {},
			Collection:{},
			View: {},
			Controller: {},
			debug: false
		};
		
	// Libs
		$LAB
			.script('scripts/lib/rjs.js')
			.script('scripts/lib/rjformat.js')
			.script('scripts/lib/jquery-1.8.2.min.js')
			.script('scripts/lib/jquery-ui-1.8.16.custom.min.js')
			.script('scripts/lib/jquery.gather.js')
			.script('scripts/lib/underscore-min.js')
			.script('scripts/lib/underscore-functional.js')
			.script('scripts/lib/underscore-proto.js')
			.script('scripts/lib/backbone-min.js')
			.script('scripts/lib/creatable.js')
			.script('scripts/lib/creatable.backbone.js')
			.script('scripts/lib/creatable.render.js')
			.script('scripts/lib/creatable-array-ext.1.0.js')
			.script('scripts/lib/bootstrap.min.js')
			
			
	// Views
		.script('scripts/views/dashboard.view.js')
		.script('scripts/views/header.view.js')
		
	// Collections
		.script('scripts/collections/posts.collection.js')
	// Controller
		.script('scripts/controller.js')
	
	</script>
  </body>
</html>