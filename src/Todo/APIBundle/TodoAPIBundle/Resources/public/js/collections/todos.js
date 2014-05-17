var app = app || {};

var TodoList = Backbone.Collection.extend({

  model: app.Todo,
  
  url: '/api/v1/todos',
  
  //localStorage: new Backbone.LocalStorage('todos-backbone'),

  
  completed: function() {
	return this.filter( function(todo) {
	  return todo.get('completed');
	});
  },
  
  remaining: function() {
    return this.filter( function(todo) {
	  return ! todo.get('completed');
	});
  }, 
  
  nextOrder: function() {
    if ( !this.length ) {
      return 1;
    }
    return this.last().get('order') + 1;
  },

  // Todos are sorted by their original insertion order.
  comparator: function( todo ) {
    return todo.get('order');
  }
});

app.Todos = new TodoList;

