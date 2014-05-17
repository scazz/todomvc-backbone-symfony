var app = app || {};

app.AppView = Backbone.View.extend({

  el: '#todoapp',
  
  template: _.template( $('#stats-template').html() ),
  
  events: {
	'keypress #new-todo': 'createOnEnter',
	'click #toggle-all': 'toggleAllComplete',
	'click #clear-completed': 'removeCompletedTodos'

  },
  
  initialize: function() {
    this.allCheckboxes = this.$('#toggle-all')[0]; 
	this.$input = this.$('#new-todo');
	this.$footer = this.$('#footer');
	this.$main = this.$('#main');
	this.$todoList = this.$('#todo-list');
	
	this.listenTo(app.Todos, 'add', this.addOne);
	this.listenTo(app.Todos, 'all', this.render);
	
	app.Todos.fetch();
  },
  
  render: function() {
	var remainingItems = app.Todos.remaining().length;
	var completedItems = app.Todos.completed().length;
	
	if (app.Todos.length) {
	  this.$main.show();
	  this.$footer.show();
	  this.$footer.html( this.template({
		remaining: remainingItems, 
		completed: completedItems 
	  }) );
	} else {
	  this.$main.hide();
	  this.$footer.hide();
	}
  }
  ,
  
  addOne: function ( todo ) {
	var view = new app.TodoView({model: todo });
	this.$todoList.append( view.render().el );
  }
  ,
  
  
  newTodoAttributes: function() {
	return {
		title: this.$input.val(),
		completed: false
	};
  },
  
  
  createOnEnter: function(event) {
	if (event.which !== 13 || ! this.$input.val().trim()) {
		return;
	}
	app.Todos.create( this.newTodoAttributes() );
	this.$input.val("");
  }
  ,
  
  toggleAllComplete: function() {
    var newCompletedState = this.allCheckboxes.checked;
  
    app.Todos.each( function( todo ) {
		todo.save({
			'completed': newCompletedState
		});
	});
  }
  ,
  
  removeCompletedTodos: function() {
	 _.invoke(app.Todos.completed(), 'destroy');
	 return false;
  }
  
  
  

});