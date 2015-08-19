<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Plans_model extends CI_Model
{
    function __construct()
    {
            // Call the Model constructor
            parent::__construct();
    }

    function get_plans(){
        $this->db->order_by('name', 'asc');
        $query = $this->db->query('SELECT * FROM price_plan where deleted=0;');
        if($query->result()){
            return $query->result();
        }else{
           return FALSE; 
        }
    }
    
    public function get_plan_name($id)
    {
        $this->db->select('name');
        $this->db->where('plan_id', $id);
        $query = $this->db->get('price_plan')->result();

        return $query[0]->name;
    }
    
    function get_plans_by_id($plan_id){
        $this->db->select();
        $this->db->where('plan_id', $plan_id);
//        $this->db->where('deleted', 0);
        $query = $this->db->get('price_plan');
        if($query->result()){
            $return = $query->result();
            return $return[0];
        }else{
           return FALSE; 
        }
    }
    
    function create_plan($data)
    {
        if($this->db->insert('price_plan', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function update_plan($data)
    {
        $this->db->where('plan_id', $data['plan_id']);
        if($this->db->update('price_plan', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function delete_plan($plan_id)
    {
        $this->db->where('plan_id', $plan_id);
        if($this->db->update('price_plan', array('deleted'=>1))){
            return TRUE;
        } else {
            return FALSE;
        }
    }
} 