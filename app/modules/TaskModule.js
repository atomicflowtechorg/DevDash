// Use an IIFE...
// (http://benalman.com/news/2010/11/immediately-invoked-function-expression/)
// to assign your module reference to a local variable, in this case Example.
//
// Change line 16 'Example' function(Example) to the name of your module, and change line 38 namespace.module("example")); to
// the lowercase version of your module name.  Then change the namespace
// for all the Models/Collections/Views/Routers to use your module name.
//
// For example: Renaming this to use the module name: Project
//
// Line 16: (function(Project) {
// Line 38: })(namespace.module("project"));
//
// Line 18: Project.Model = Backbone.Model.extend({
//
(function(TaskModule) {

  TaskModule.Task = Backbone.Model.extend({ 
    // probably can delete - url: "http://devdashapi.atomicflowtech.com/api/tasks"
  });
  
  TaskModule.TaskList = Backbone.Collection.extend({
    model: TaskModule.Task,
    url: "http://devdashapi.atomicflowtech.com/api/tasks"
  });

  TaskModule.Router = Backbone.Router.extend({ /* ... */ });

  // This will fetch the taskView template and render it.
  TaskModule.Views.Tutorial = Backbone.View.extend({
    template: "app/templates/taskView.html",
    //el: $("#dataDisplayContent"),

    initialize: function() {
      TaskModule.tasks = new TaskModule.TaskList();
      TaskModule.tasks.fetch({
        success: function() {
          console.log (TaskModule.tasks.toJSON());
         console.log( _.pluck( TaskModule.tasks.toJSON(), 'name') );
                }
            });   
        // this.render();
    },

    render: function(doneFunction) {
      var view = this;
      // var html = ich.tasks(this.template);
      // Fetch the template, render it to the View element and call done.
      var info = {"id":"94","name":"Another Task Post With API","assignedTo":"brandonjf","listId":"9","status":"Assigned","notes":"I made this task with the API and Post\r\n\r\nword","dateDue":"0000-00-00 00:00:00","dateCompleted":"0000-00-00 00:00:00"}
      devdash.getTemplate(this.template,info, function(tmpl) {view.el.innerHTML = tmpl; doneFunction(view.el);} );
      _.each(TaskModule.tasks.toJSON(), function(task){alert(task)});
       console.log (TaskModule.tasks.toJSON());
    }
  });



})(devdash.module("taskmodule"));
