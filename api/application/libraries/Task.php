<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Task
 *
 * @author lpaulger
 */
class Task {
    //put your code here
    public $id = null;
    public $name = 'default';
    public $assignedTo = '';
    public $listId = null;
    public $status = 'Available';
    public $notes = '';
    public $dateDue = '';
    public $dateCompleted = '';
}