<!DOCTYPE HTML>
<html>
  <head>
	<meta charset="utf-8" />
    <title>CP Lab Backend Notes API</title>
    <link rel="stylesheet" media="all" href="scripts/components/mocha/mocha.css">
  </head>
  <body>
    <div id="mocha"><p><a href=".">Index</a></p></div>
    <div id="messages"></div>
    <div id="fixtures"></div>

    <script src="scripts/components/mocha/mocha.js"></script>
  	<script src="scripts/components/chai/chai.js"></script>
    <script src="scripts/components/superagent/superagent.js"></script>

    <script>mocha.setup('bdd')</script>
    <script src="scripts/api_tests.js"></script>
    <script>mocha.run();</script>

  </body>
</html>