window.TaskView = Backbone.View.extend({
    template: _.template($('#task-details').html()),
    render: function(eventName) {
        $("#taskList").html(this.template(this.model.toJSON()));
        return this;
    }
});    