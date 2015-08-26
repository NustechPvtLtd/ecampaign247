<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plans_transaction_model extends CI_Model
{
    function __construct()
    {
            // Call the Model constructor
            parent::__construct();
    }

    function get_plans_transaction(){
        $query = $this->db->query('SELECT * FROM price_plan_order_transaction;');
        if($query->result()){
            return $query->result();
        }else{
           return FALSE; 
        }
    }
    
    
    function get_plans_transaction_by_id($order_id){
        $this->db->select();
        $this->db->where('order_id', $order_id);
        $query = $this->db->get('price_plan_order_transaction');
        if($query->result()){
            $return = $query->result();
            return $return[0];
        }else{
           return FALSE; 
        }
    }
    
    function create_plan_transaction($data)
    {
        if($this->db->insert('price_plan_order_transaction', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }

} 