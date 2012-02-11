window.TaskListView = Backbone.View.extend({
    el: $('#taskList'),
    initialize: function() {
        this.model.bind("reset", this.render, this);
    },
    render: function(eventName) {
        $(this.el).empty();
        _.each(this.model.models, function(task) {
            $(this.el).append(
                new TaskListItemView({
                    model: task
                }).render().el);
        }, this);
        return this;
    }
});
    
window.TaskListItemView = Backbone.View.extend({
    template: _.template($('#task-list-item').html()),
    render: function(eventName) {
        $(this.el).html(this.template(this.model.toJSON()));
        return this;
    }
});