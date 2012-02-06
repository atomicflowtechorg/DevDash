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
(function(UserModule) {

    UserModule.User = Backbone.Model.extend({ 
        url: "http://devdashapi.atomicflowtech.com/api/user"
    });
    console.log(UserModule.User);
    UserModule.UserList = Backbone.Collection.extend({
        model: UserModule.User,
        url: "http://devdashapi.atomicflowtech.com/api/users"
    });
    UserModule.Router = Backbone.Router.extend({ /* ... */ });

    // This will fetch the tutorial template and render it.
    UserModule.Views.Users = Backbone.View.extend({
        template: "app/templates/users.html",

    
        render: function(done) {
            var view = this;
            alert("loading users...");
            UserModule.users = new UserModule.UserList();
            UserModule.users.fetch({
                success: function() {
                    console.log(UserModule.users.toJSON());
                }
            });   
            console.log(UserModule.users);
            alert("loaded users...");
        }
    });



})(devdash.module("usermodule"));
