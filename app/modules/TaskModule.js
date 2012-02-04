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
    url: "http://devdashapi.atomicflowtech.com/api/tasks"
  });
  console.log(TaskModule.Task);
  TaskModule.TaskList = Backbone.Collection.extend({
    // model: TaskModule.Task,
    url: "http://devdashapi.atomicflowtech.com/api/tasks/"
    

  });
  TaskModule.Router = Backbone.Router.extend({ /* ... */ });

  // This will fetch the tutorial template and render it.
  TaskModule.Views.Tutorial = Backbone.View.extend({
    template: "app/templates/example.html",

    
    render: function(done) {
      var view = this;
      alert("loading list...");
      TaskModule.tasks = new TaskModule.TaskList(); 
      console.log(TaskModule.tasks);
      alert("loaded list...");

      // Fetch the template, render it to the View element and call done.
      devdash.fetchTemplate(this.template, function(tmpl) {
        view.el.innerHTML = tmpl();

        done(view.el);
      });
    }
  });



})(devdash.module("taskmodule"));
