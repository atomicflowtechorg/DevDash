<?php

class TaskModel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function task_get($taskId) {
        $this->load->library('Task');


        $taskerTask = $this->db->query("SELECT fkUsername FROM tblTaskerTask WHERE fkTaskId=$taskId");
        $listTask = $this->db->query("SELECT fkListId FROM tblListTask WHERE fkTaskId=$taskId");
        $listQueryParams = $listQuery = $taskQueryParams = $taskQuery = "";

        if ($listTask->num_rows === 1) {
            $listQueryParams = ",d.fldListName, d.pkListId";
            $listQuery = "INNER JOIN tblListTask e ON a.pkTaskId = e.fkTaskId INNER JOIN tblList d ON e.fkListId = d.pkListId";
        }
        if ($taskerTask->num_rows == 1) {
            $taskQueryParams = ",c.pkUsername, c.fldProfileImage, c.fldEmail";
            $taskQuery = "INNER JOIN tblTaskerTask b ON a.pkTaskId = b.fkTaskId INNER JOIN tblTasker c ON b.fkUsername = c.pkUsername";
        }

        $queryString = "SELECT DISTINCT a.pkTaskId, a.fldName, a.fldStatus, a.fldNotes, a.fldDateDue $listQueryParams $taskQueryParams
			FROM tblTask a
			$taskQuery
			$listQuery
			WHERE a.pkTaskId=$taskId";
        $query = $this->db->query($queryString);

        foreach ($query->result() as $item) {
            $task = new Task();
            $task->id = $item->pkTaskId;
            $task->name = $item->fldName;
            $task->status = $item->fldStatus;
            $task->assignedTo = $item->pkUsername;
            $task->listId = $item->pkListId;
            $task->notes = $item->fldNotes;
            $task->dateDue = $item->fldDateDue;
            $task->dateCompleted = $item->fldDateCompleted;
        }
        return $task;
    }

    function task_create($task) {
        $tblTask = array('fldName' => $task->name, 'fldStatus' => $task->status, 'fldNotes' => $task->notes, 'fldDateDue' => $task->dateDue);


        $this->db->insert('tblTask', $tblTask);
        $task->id = $this->db->insert_id();

        if ($task->assignedTo !== '') {
            $tblTaskerTask = array('fkUsername' => $task->assignedTo, 'fkTaskId' => $task->id);
            $this->db->insert('tblTaskerTask', $tblTaskerTask);
        }

        return $task;
    }

    function task_delete($taskId) {
        $query = $this->db->query("UPDATE tblTask SET fldStatus='Deleted' WHERE pkTaskId='$taskId'");
        $isDeleted = false;
        if ($this->db->affected_rows() == 1) {
            $isDeleted = true;
        }
        return $isDeleted;
    }

    function task_update($task) {
        $this->load->helper('date');

        $this->pkTaskId = $task->id;
        $this->fldName = $task->name;
        $this->fldAssignedTo = $task->assignedTo;
        $this->fldStatus = $task->status;
        $this->fldNotes = $task->notes;
        $this->fldDateDue = $task->dateDue;
        $this->fldDateCompleted;
        
        $queryExists = $this->db->query("SELECT pkTaskId FROM tblTask WHERE pkTaskId = '$this->pkTaskId'");
        //if taskId doesnt exist
        if($this->db->affected_rows() === 0){
            return 404;
        }
        //code that checks if updating for an unassigned task
        $query = $this->db->query("SELECT COUNT(*) AS total FROM tblTaskerTask WHERE fkTaskId = '$this->pkTaskId'");
        foreach ($query->result() as $row) {
            $hasTasker = $row->total;
        }
        
        
        /**********************************tblTaskerTask modification *********************************/
        switch ($hasTasker) {

            default :
                return 400;
                break;
            case 0 :
                if ($this->fldAssignedTo == '') {//task stays unassigned
                    
                } else {
                    $this->db->query("INSERT INTO tblTaskerTask (fkUsername, fkTaskId ) VALUES ('$this->fldAssignedTo', '$this->pkTaskId')");
                    $this->fldStatus = 'Assigned';
                }
                break;
            case 1 :
                if ($this->fldAssignedTo != '') {//task changes assigned
                    $this->db->query("UPDATE tblTaskerTask SET fkUsername='$this->fldAssignedTo' WHERE fkTaskId = '$this->pkTaskId'");
                } else { //task becomes unassigned
                    $this->db->query("DELETE FROM tblTaskerTask WHERE fkTaskId = '$this->pkTaskId'");
                    $this->fldStatus = 'Available';
                }
                break;
        }


        if ($this->fldStatus == 'Completed') {//update task to completed
            $this->fldDateCompleted = date('Y-m-d H:i:s', time());
        }
        //updates task
        if($this->fldName==''){
            return 406;
        }
        $tblTask = array('fldName' => $this->fldName, 'fldStatus' => $this->fldStatus, 'fldNotes' => $this->fldNotes, 'fldDateDue' => $this->fldDateDue, 'fldDateCompleted' => $this->fldDateCompleted);

        $where = "pkTaskId = $this->pkTaskId";
        $update[] = $this->db->update_string('tblTask', $tblTask, $where);
        $this->db->query($update[0]);
        //doesnt actually use the returned value...
        return 200;
    }

    function tasks_get() {
        $this->load->library('Task');
        $tasks = array();
        $taskQuery = "LEFT JOIN tblTaskerTask b ON a.pkTaskId = b.fkTaskId";
        $listQuery = "LEFT JOIN tblListTask e ON a.pkTaskId = e.fkTaskId LEFT JOIN tblList d ON e.fkListId = d.pkListId";
        
        $queryString = "SELECT DISTINCT a.pkTaskId, a.fldName, a.fldStatus, a.fldNotes, a.fldDateDue, a.fldDateCompleted, b.fkUsername ,d.fldListName, d.pkListId
                        FROM tblTask a
			$taskQuery
                        $listQuery
			WHERE a.fldStatus NOT LIKE 'Deleted'";
        $query = $this->db->query($queryString);
        foreach ($query->result() as $item) {
            $task = new Task();
            $task->id = $item->pkTaskId;
            $task->name = $item->fldName;
            $task->status = $item->fldStatus;
            $task->assignedTo = $item->fkUsername;
            $task->listId = $item->pkListId;
            $task->notes = $item->fldNotes;
            $task->dateDue = $item->fldDateDue;
            $task->dateCompleted = $item->fldDateCompleted;
            array_push($tasks, $task);
        }
        return $tasks;
    }

    function userTasks_get($username) {
        $this->load->library('Task');

        $listQueryParams = $listQuery = $taskQueryParams = $taskQuery = "";

        $taskQuery = "INNER JOIN tblTaskerTask b ON a.pkTaskId = b.fkTaskId";
        $listQueryParams = ",d.fldListName, d.pkListId";
        $listQuery = "LEFT JOIN tblListTask e ON a.pkTaskId = e.fkTaskId LEFT JOIN tblList d ON e.fkListId = d.pkListId";
        
        $queryString = "SELECT DISTINCT a.pkTaskId, a.fldName, a.fldStatus, a.fldNotes, a.fldDateDue, a.fldDateCompleted, b.fkUsername $listQueryParams
                        FROM tblTask a
			$taskQuery
                        $listQuery
			WHERE b.fkUsername = '$username' AND a.fldStatus NOT LIKE 'Deleted'";
        $query = $this->db->query($queryString);


        $tasks = array();
        foreach ($query->result() as $item) {
            $task = new Task();
            $task->id = $item->pkTaskId;
            $task->name = $item->fldName;
            $task->status = $item->fldStatus;
            $task->assignedTo = $item->fkUsername;
            $task->listId = $item->pkListId;
            $task->notes = $item->fldNotes;
            $task->dateDue = $item->fldDateDue;
            $task->dateCompleted = $item->fldDateCompleted;
            array_push($tasks, $task);
        }
        return $tasks;
    }

}