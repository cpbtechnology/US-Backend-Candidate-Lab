App.View.Dashboard = Backbone.View.extend({

	events:{
		"click button.submit" 		: "submit",
	},
	
	initialize: function(){
		var that = this;
		this.collection = new App.Collection.Posts();
		this.collection.fetch({success: function(){
			that.render();
		}});
	},
	
	build: function(){
		return ['.container',[
			//new App.View.header(),
			['ul', this.collection.map(function(post){
				return ['li',[
					['.title', post.get('title')],
					['.post_text', post.get('post_text')],
				]];
			})],
			['.form',[
				['input.title', {placeholder: 'title', name: 'title'}],
				['input.text', {placeholder: 'text', name: 'post_text'}],
				['button.submit','submit'],
			]]
		]]
	},
	
	submit: function(){
		var that = this;
		var values = $(this.el).gather();
		this.collection.create(values, {
			wait: true,
			success: function(){
				that.render();	
			}
		});
	}
	
	
});