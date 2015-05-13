<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Description of Visitor Count Model
 *
 * @author NUSTECH
 */
class Visitor_count_model extends CI_Model {
    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function find($ip, $site_id, $page_id)
    {
        $this->db->from('visitor_basic');
    	$this->db->where('visitor_ip', $ip);
    	$this->db->where('site_id', $site_id);
    	$this->db->where('page_id', $page_id);
    	
    	$query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            $res = $query->result();
            return $res[0];
        } else {
            return FALSE;
        }
    }
    
    public function create_visitor($data)
    {
        if($this->db->insert('visitor_basic', $data)){
            return $this->db->insert_id();
        } else {
            return FALSE;
        }
    }
    
    public function update($ip, $site_id, $page_id, $hitcount)
    {
        $data = array(
            'hitcount'=>$hitcount
        );
        $this->db->where('visitor_ip', $ip);
    	$this->db->where('site_id', $site_id);
    	$this->db->where('page_id', $page_id);
        $this->db->update('visitor_basic', $data);
    }
}
