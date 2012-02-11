<?php

class UserModel extends CI_Model {

    function __construct() {
        // Call the Model constructor
        parent::__construct();
    }

    function users_get() {
        $this->load->library('User');
        $users = array();
        $query = $this->db->query('SELECT pkUsername, fldFirstname, fldLastname, fldLastLoggedIn, fldEmail, fldStatus 
                                FROM  `tblTasker` 
                                ORDER BY  `fldLastLoggedIn` DESC ');
        
        foreach($query->result() as $item){
            $user = new User();
            $user->username = $item->pkUsername;
            $user->firstname = $item->fldFirstname;
            $user->lastname = $item->fldLastname;
            $user->email = $item->fldEmail;
            $user->lastLoggedIn = $item->fldLastLoggedIn;
            $user->status = $item->fldStatus;
            array_push($users,$user);
        }
        return $users;
    }

    function user_get($username) {
        $this->load->library('User');
        $query = $this->db->query("SELECT pkUsername, fldFirstname, fldLastname, fldLastLoggedIn, fldEmail, fldStatus 
                FROM  `tblTasker`
                WHERE pkUsername = '$username' ");
        
        foreach($query->result() as $item){
            $user = new User();
            $user->username = $item->pkUsername;
            $user->firstname = $item->fldFirstname;
            $user->lastname = $item->fldLastname;
            $user->email = $item->fldEmail;
            $user->lastLoggedIn = $item->fldLastLoggedIn;
            $user->status = $item->fldStatus;
        }
        return $user;
    }

    function user_insert() {
        $this->load->helper('security');

        $date = getdate();
        $datetime = $date['year'] . "-" . $date['mon'] . "-" . $date['mday'] . " " . $date['hours'] . ':' . $date['minutes'] . ':' . $date['seconds'];

        $this->firstname = $this->input->post('fldFirstname');
        $this->lastname = $this->input->post('fldLastname');
        $this->email = $this->input->post('fldEmail');
        $this->username = $this->input->post('fldUsername');
        $this->password = $this->input->post('fldPassword1');
        $this->authKey = do_hash(time(), 'md5'); // MD5 resetKey
        $this->lastLoggedIn = $datetime;

        $data = array('pkUsername' => $this->username, 'fldPassword' => $this->password, 'fldFirstname' => $this->firstname, 'fldLastname' => $this->lastname, 'fldLastLoggedIn' => $this->lastLoggedIn, 'fldEmail' => $this->email, 'fldAuthKey' => $this->authKey);

        $queryString = $this->db->insert_string('tblTasker', $data);
        $this->db->query($queryString);
        return $this;
    }

}