$(function () {
    var username = "lucasmp";
    //var username = prompt("enter your username","lucasmp");
    
    var AppRouter = Backbone.Router.extend({
        routes: {
            ""          : "tasklist",
            "tasks/:id" : "taskDetails",
            "tasksUpdate/:id" : "taskUpdate"
        },
 
        tasklist: function() {
            console.log('Loading: tasklist');
            this.taskList = new TaskCollection();
            this.taskListView = new TaskListView({
                model: this.taskList
            });
            this.taskList.fetch();
        },
 
        taskDetails: function(id) {
            console.log('Loading: taskDetails');
            this.task = this.taskList.get(id);
            this.taskView = new TaskView({
                model: this.task
            });
            this.taskView.render();
        },
        taskUpdate: function(id) {
            console.log('updating task');
            this.task = this.taskList.get(id);
            
            var new_name = prompt("enter new name",this.task.get("name"));
            this.task.set({
                name:new_name
            });
            this.taskView = new TaskView({
                model: this.task
            });
            this.taskView.render();
            this.task.save({
                success:function(){
                    alert("success!");
                },
                error: function(){
                    alert("failure");
                }
            })
        }
    });
    tpl.loadTemplates(['task-details', 'task-list-item'], function(){
        
    });
    app = new AppRouter();
    Backbone.history.start();

});

//Example Link to test functionality
//$('#tasks').click(function () {
//    alert(tasks.url);
//    var tasksNames = tasks.pluck("fldName");
//    alert(JSON.stringify(tasksNames));
//});