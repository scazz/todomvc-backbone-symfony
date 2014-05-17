var app = app || {}; 

app.TodoView = Backbone.View.extend({

  tagName: 'li',

  template: _.template( $('#item-template').html() ),
  
  events: {
	'click .destroy': 'clear',
	'click .toggle': 'toggleComplete',
	'click #toggle-all': 'toggleAllComplete'
  },

  initialize: function() {
	this.listenTo(this.model, 'change', this.render);
	this.listenTo(this.model, 'destroy', this.remove);
  },
  
  render: function() {
	// get template and fill with model
	this.$el.html(this.template( this.model.toJSON() ));
	this.$input = this.$('.edit');
	return this;
  },
  
  clear: function() {
	this.model.destroy();
  }
  ,
  
  toggleComplete: function() {
	this.model.toggleCompleted();
  }
  ,
  
  toggleAllComplete: function() {
	console.log("ugh");
  }

});