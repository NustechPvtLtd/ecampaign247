<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of addon_domain_model
 *
 * @author NUSTECH
 */
class Users_domains_model extends CI_Model {
    
    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }
    
    public function create($site_id, $user_id, $domain, $url_option)
    {
        $data = array(
            'domain'=>$domain,
            'user_id'=>$user_id,
            'site_id'=>$site_id,
            'domain_publish'=>0,
            'url_option'=>$url_option
        );
        if ($this->exist($site_id)) {
            $this->db->update('users_domains', $data, array('site_id'=>$site_id));
            $query = $this->getDomain($site_id);
            $domainID = $query->id ;
        } else {
            $this->db->insert('users_domains', $data); 
            $domainID = $this->db->insert_id();
        }

        if($url_option=='freeUrl'){
            $remote_url = 'http://'.$_SERVER['HTTP_HOST'].'/'.$domain; 
        }else{
            $remote_url = 'http://'.$domain; 
        }
        $this->db->where('sites_id', $site_id)->update('sites', array('domain_ok'=>1,'remote_url'=>$remote_url));
    	return $domainID;
    }
    
    public function getDomain($siteId)
    {
        $query = $this->db->from('users_domains')->where('site_id', $siteId)->get();
        
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res[0];
        }else{
            return FALSE;
        }
        
    }
    
    public function exist($site_id)
    {
        $query = null;
        $query = $this->db->get_where('users_domains', array(//making selection
            'site_id'=>$site_id
        ));

        $count = $query->num_rows(); //counting result from query
        if ($count === 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function domain_publish($site_id)
    {
        if ( $this->db->where('site_id', $site_id)->update('users_domains', array('domain_publish'=>1))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
}
