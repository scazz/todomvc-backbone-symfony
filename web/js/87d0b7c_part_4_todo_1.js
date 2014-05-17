var app = app || {};

app.Todo = Backbone.Model.extend({ 

  defaults: {
    title: '',
	completed: false
  },
  
  toggleCompleted: function() {
    this.save({
		completed: ! this.get('completed')
	});
  }

});