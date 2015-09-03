<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Addressmodel extends CI_Model
{
    function __construct()
    {
            // Call the Model constructor
            parent::__construct();
    }

    function get_country(){
        $return[''] = 'please select';
        $this->db->order_by('name', 'asc'); 
        $query = $this->db->query('SELECT country_id, name FROM country');
        foreach($query->result_array() as $row){
            $return[$row['country_id']] = $row['name'];
        }
        return $return;
    }


    function get_state_by_country ($country){
        $this->db->select('zone_id, name');
        
        $this->db->where('country_id', $country);
        
        $query = $this->db->get('zone');
        $states = array();

        if($query->result()){
            foreach ($query->result() as $state) {
                $states[$state->zone_id] = $state->name;
            }
            return $states;
        } else {
            return FALSE;
        }
    } 
    
    function get_address($user)
    {
        $this->db->select();
        $this->db->where('user_id', $user);
        $query = $this->db->get('users_address');
        $address = array();
        if($query->result()){
            foreach ($query->result() as $addr) {
                if ($addr->type=='billing') {
                    $address['blng_id']=$addr->id;
                    $address['blng_street']=$addr->street;
                    $address['blng_city']=$addr->city;
                    $address['blng_state']=$addr->state;
                    $address['blng_zipcode']=$addr->zipcode;
                    $address['blng_country']=$addr->country;
                    $address['blng_phone']=$addr->phone;
                }else{
                    $address['spng_id']=$addr->id;
                    $address['spng_street']=$addr->street;
                    $address['spng_city']=$addr->city;
                    $address['spng_state']=$addr->state;
                    $address['spng_zipcode']=$addr->zipcode;
                    $address['spng_country']=$addr->country;
                    $address['spng_phone']=$addr->phone;
                }
            }
            return $address;
        } else {
            return FALSE;
        }
    }
    
    function set_address($data)
    {
        if($this->db->insert_batch('users_address', $data)){
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    function update_address($data)
    {
        $this->db->update_batch('users_address', $data, 'id');
        return ($this->db->affected_rows() > 0) ? TRUE : FALSE; 
    }

} 