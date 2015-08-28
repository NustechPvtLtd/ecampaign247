<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Addon_domain_order_model extends CI_Model
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
        $query = $this->db->query('SELECT * FROM addon_domain_order;');
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
        $query = $this->db->get('addon_domain_order');
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
    function create_domain_orders($data)
    {
        if($this->db->insert('addon_domain_order', $data)){
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
        if($this->db->update('addon_domain_order', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
} 