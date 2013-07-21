App.Controller.App = Backbone.Router.extend({
	routes: {
		"":					"home",
	},
	/** Renders the given Backbone.View in the body. */
	render: function(view) {
		$("body").empty().append(Creatable.create(view));
	},

	home: function() {
			var dashboard = new App.View.Dashboard();
			this.render(dashboard);
	},

});

window.app = new App.Controller.App();
Backbone.history.start();