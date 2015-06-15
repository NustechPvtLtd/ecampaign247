<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Domainmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }
    
    /*
    	
    	creates a new domain
    
    */
    
    public function create($siteId, $domainname, $domainData) {
    	$data = array(
    		'domainname' => $domainname,
    		'orderid' => (isset($domainData->entityid))?$domainData->entityid:'',
    	   	'actiontype' =>  (isset($domainData->actiontype))?$domainData->actiontype:'',
    	   	'actiontypedesc' => (isset($domainData->actiontypedesc))?$domainData->actiontypedesc:'',
    	   	'actionid' => (isset($domainData->eaqid))?$domainData->eaqid:'',
    	   	'actionstatus' => (isset($domainData->actionstatus))?$domainData->actionstatus:'',
    	   	'actionstatusdesc' => (isset($domainData->actionstatusdesc))?$domainData->actionstatusdesc:'',
    	   	'invoiceid' => (isset($domainData->invoiceid))?$domainData->invoiceid:'',
    	   	'sellingcurrencysymbol' => (isset($domainData->sellingcurrencysymbol))?$domainData->sellingcurrencysymbol:'',
    	   	'sellingamount' => (isset($domainData->sellingamount))?strip_tags($domainData->sellingamount):'',
    	   	'unutilisedsellingamount' => (isset($domainData->unutilisedsellingamount))?strip_tags($domainData->unutilisedsellingamount):'',
    	   	'customerid' => (isset($domainData->customerid))?$domainData->customerid:'',
    	   	'siteid' => $siteId
    	);
    	
    	$this->db->insert('premium_domain', $data); 
    	
    	$domainID = $this->db->insert_id();

    	return $domainID;
    
    }
    
    public function getDomain($siteId)
    {
        $query = $this->db->from('premium_domain')->where('siteid', $siteId)->get();
        
        if($query->num_rows() > 0){
            $res = $query->result();
            return $res[0];
        }else{
            return FALSE;
        }
        
    }
    
    public function publishDomain($siteId)
    {
        $data = array(
   			'domain_publish' => 1
   		);
        $this->db->where('siteid', $siteId);
    	$this->db->update('premium_domain', $data);
    }
    
}