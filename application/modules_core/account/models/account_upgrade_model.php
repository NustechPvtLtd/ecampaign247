<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Account_upgrade_model extends CI_Model
{
    function __construct()
    {
            // Call the Model constructor
            parent::__construct();
    }

    function get_upgrade_details(){
//        $this->db->group_by("user_id");
        $query = $this->db->query('SELECT * FROM account_upgrade;');
//        $this->db->_reset_select();
        if($query->result()){
            return $query->result();
        }else{
           return FALSE; 
        }
    }
    
    function get_upgrade_by_id($user_id){
        $this->db->select();
        $this->db->where('user_id', $user_id);
        $this->db->order_by("date","desc");
        $query = $this->db->get('account_upgrade');
        if($query->result()){
            $return = $query->result();
            return $return[0];
        }else{
           return FALSE; 
        }
    }
    
    function account_upgrade($data)
    {
        if($this->db->insert('account_upgrade', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
} 