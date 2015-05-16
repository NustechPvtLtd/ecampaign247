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
    
    public function get_by_site($site_id)
    {
        $this->db->select('page_id AS id , page_url , sum(hitcount) AS total_hit, COUNT( `visitor_ip` ) AS unique_hit');
        $this->db->group_by('page_id'); 
        $this->db->from('visitor_basic');
    	$this->db->where('site_id', $site_id);
    	
    	$query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            $res = $query->result_array();
            return $res;
        } else {
            return 0;
        }
    }
    
    public function get_by_page($page_id)
    {
        $this->db->select('visitor_ip AS ip, isp, city, region, country, longitude AS lng, latitude AS lat, hitcount, timestamp' );
        $this->db->from('visitor_basic');
    	$this->db->where('page_id', $page_id);
    	
    	$query = $this->db->get();

        if( $query->num_rows() > 0 ) {
            $res = $query->result_array();
            return $res;
        } else {
            return 0;
        }
    }
}
