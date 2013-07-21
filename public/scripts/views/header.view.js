App.View.header = Backbone.View.extend({
	className:'navbar navbar-inverse navbar-fixed-top',
	events:{
	
	},
	
	initialize: function(){
	
	},
	
	build: function(){
		return ['.navbar-inner .container',[
			['button.btn.btn-navbar', { 'data-toggle': 'collapse', 'data-target': '.nav-collapse' }, [
				['span.icon-bar'],
				['span.icon-bar'],
				['span.icon-bar'],
			]],
			['a.brand', { href:'#' }, 'Project Name'],
			['div.nav-collapse.collapse',[
				['ul.nav',[
					['li.active',[
						['a',{ href:'#' }, 'Home']
					]],
					['li',[['a',{ href:'#about' }, 'About']]],
					['li',[['a',{ href:'#about' }, 'Contact']]],
					['li',[['a',{ href:'#about' }, 'About']]],
				]],
				['form.navbar-form.pull-right', [
					['input.span2', { type:'text', placeholder:'Email' }],
					['input.span2', { type:'password', placeholder:'Password' }],
					['button.btn', { type:'submit' }, 'Sign In']
				]]
			]]
		]];
	},
});