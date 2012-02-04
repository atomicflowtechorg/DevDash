jQuery(function($) {
  var TaskModule, Router, app;
  app = devdash.app;
  TaskModule = devdash.module("taskmodule");
  Router = Backbone.Router.extend({
    routes: {
      "": "index", 
      devdash: "devdash",
      tutorial: "tutorial",
      ":hash": "index"
    },
    index: function(hash) {
      var route, tutorial;
      route = this;
      tutorial = new TaskModule.Views.Tutorial();
      return tutorial.render(function(el) {
         return $("#dataDisplay").html(el);
      });
    },
    tutorial: function(hash) {
      var route, tutorial;
      route = this;
      tutorial = new TaskModule.Views.Tutorial();
      return tutorial.render(function(el) {
        $("#dataDisplay").html(el);
        if (hash && !route._alreadyTriggered) {
          Backbone.history.navigate("", false);
          location.hash = hash;
          return route._alreadyTriggered = true;
        }
      });
    }
  });
  app.router = new Router();
  Backbone.history.start({
    pushState: true
  });
  return $(document).on("click", "a:not([data-bypass])", function(evt) {
    var href, protocol;
    href = $(this).attr("href");
    protocol = this.protocol + "//";
    if (href && href.slice(0, protocol.length) !== protocol) {
      evt.preventDefault();
      return app.router.navigate(href, true);
    }
  });
});