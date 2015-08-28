<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Addon_domain_transaction_model extends CI_Model
{
    function __construct()
    {
            // Call the Model constructor
            parent::__construct();
    }

    function get_domain_transaction(){
        $query = $this->db->query('SELECT * FROM addon_domain_transaction;');
        if($query->result()){
            return $query->result();
        }else{
           return FALSE; 
        }
    }
    
    
    function get_domain_transaction_by_id($order_id){
        $this->db->select();
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('addon_domain_transaction');
        if($query->result()){
            $return = $query->result();
            return $return[0];
        }else{
           return FALSE; 
        }
    }
    
    function create_domain_transaction($data)
    {
        if($this->db->insert('addon_domain_transaction', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

} 