window.Task = Backbone.Model.extend({
    url: "http://devdashtest.local/api/index.php/api/task"
});
    
window.TaskCollection = Backbone.Collection.extend({
    model: Task,
    url: "http://devdashtest.local/api/index.php/api/tasks"
});