window.Task = Backbone.Model.extend({
    url: "http://devdash.local/api/index.php/api/task"
});
    
window.TaskCollection = Backbone.Collection.extend({
    model: Task,
    url: "http://devdash.local/api/index.php/api/tasks"
});