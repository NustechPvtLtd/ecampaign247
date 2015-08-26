<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plans_orders_model extends CI_Model
{
    function __construct()
    {
            // Call the Model constructor
            parent::__construct();
    }

    /*
     * Get all plans orders
     */
    function get_orders(){
        $query = $this->db->query('SELECT * FROM price_plan_order;');
        if($query->result()){
           return $query->result();
        }else{
           return FALSE; 
        }
    }
    
    /*
     * Get plans orders by id
     */
    function get_orders_by_id($orders_id){
        $this->db->select();
        $this->db->where('order_id', $orders_id);
        $query = $this->db->get('price_plan_order');
        if($query->result()){
            $return = $query->result();
            return $return[0];
        }else{
            return FALSE; 
        }
    }
    
    /*
     * Insert plans orders
     */
    function create_plan_orders($data)
    {
        if($this->db->insert('price_plan_order', $data)){
            $insert_id = $this->db->insert_id();
            return $insert_id;
        } else {
            return FALSE;
        }
    }
    
    /*
     * Update plans orders
     */
    function update_plan($data)
    {
        $this->db->where('order_id', $data['order_id']);
        if($this->db->update('price_plan_order', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
} 