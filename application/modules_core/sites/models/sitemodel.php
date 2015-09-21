<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sitemodel extends CI_Model {

    function __construct()
    {
        parent::__construct();

        $this->load->database();
        $this->load->helper('file');
    }

    /*

      returns all available sites

     */

    public function all($forUserID = '')
    {

        //if $forUserID is set, this means we're looking for the sites belonging to a specific user

        if ($forUserID == '') {

            $user = $this->ion_auth->user()->row();
            $userID = $user->id;

            if (!$this->ion_auth->is_admin()) {
                $this->db->where('users_id', $userID);
            }
        } else {

            $this->db->where('users_id', $forUserID);
        }

        $this->db->from('sites');
        $this->db->where('sites_trashed', 0);
        $this->db->join('users', 'sites.users_id = users.id');

        $query = $this->db->get();

        $res = $query->result();

        $allSites = array(); //array holding all sites and associated data

        foreach ($res as $site) {

            $temp = array();

            $temp['siteData'] = $site;

            //get the number of pages
            $this->db->from('pages');
            $this->db->where('sites_id', $site->sites_id);
            $this->db->where('pages_trashed', 0);
            $query = $this->db->get();

            $res = $query->result();

            $temp['nrOfPages'] = $query->num_rows();

            $this->db->flush_cache();

            //grab the first frame for each site, if any

            $q = $this->db->from('pages')->where('pages_name', 'index')->where('sites_id', $site->sites_id)->where('pages_trashed', 0)->get();

            if ($q->num_rows() > 0) {

                $res = $q->result();

                $indexPage = $res[0];

                $q = $this->db->from('frames')->where('pages_id', $indexPage->pages_id)->order_by('frames_id', 'asc')->limit(1)->get();

                if ($q->num_rows() > 0) {

                    $res = $q->result();

                    $temp['lastFrame'] = $res[0];
                } else {

                    $temp['lastFrame'] = '';
                }
            } else {

                $temp['lastFrame'] = '';
            }


            $allSites[] = $temp;
        }

        return $allSites;
    }

    /*


      checks to see if a site belongs to this user

     */

    public function isMine($siteID)
    {

        $user = $this->ion_auth->user()->row();

        $userID = $user->id;


        $q = $this->db->from('sites')->where('sites_id', $siteID)->get();

        if ($q->num_rows() > 0) {

            $res = $q->result();

            if ($res[0]->users_id != $userID) {

                return false;
            } else {

                return true;
            }
        } else {

            return false;
        }
    }

    /*

      creates a new, empty shell site

     */

    public function createNew()
    {

        $user = $this->ion_auth->user()->row();

        $userID = $user->id;

        //create site
        $data = array(
            'sites_name' => 'My New Site',
            'users_id' => $userID,
            'sites_created_on' => time()
        );

        $this->db->insert('sites', $data);

        $newSiteID = $this->db->insert_id();


        //create empty index page

        return $newSiteID;
    }

    /*

      creates a new site item, including pages and frames

     */

    public function create($siteName, $siteData)
    {

        $user = $this->ion_auth->user()->row();

        $userID = $user->id;

        //create the site item first

        $data = array(
            'users_id' => $userID,
            'sites_name' => $siteName,
            'sites_created_on' => time()
        );

        $this->db->insert('sites', $data);

        $siteID = $this->db->insert_id();

        //die( "ID: ".$this->db->insert_id() );
        //next we create the pages and frames
        $this->createPages($siteID, $siteData);
        return $siteID;
    }

    /*

      updates an existing site item, including pages and frames

     */

    public function update($siteID, $siteData, $pagesData = '')
    {

        //update the site details first

        $data = array(
            'sites_lastupdate_on' => time()
        );

        $this->db->where('sites_id', $siteID);
        $this->db->update('sites', $data);

        //delete all pages and frames and re-save

        $query = $this->db->from('pages')->where('sites_id', $siteID)->get();

        $pages = $query->result();
        if (!empty($pages)) {
            $this->updatePages($siteID, $pages, $siteData, $pagesData);
        } else {
            $this->createPages($siteID, $siteData);
        }
    }

    /*

      updates a site's meta data (name, ftp details, etc)

     */

//    public function updateSiteData($siteData)
//    {
//        $domainOk = 0;
//        $siteDetails = $this->db->select('domain')->from('sites')->where('sites_id', $siteData['siteID'])->get();
//        $result = $siteDetails->result();
//        if (empty($result[0]->domain) && ($siteData['siteSettings_domain'] != '') && $this->checkDomainAvailability($siteData['siteSettings_domain'])) {
//            $domainOk = 1;
//            $data = array(
////                'sites_name' => $siteData['siteSettings_siteName'],
//                'domain' => $siteData['siteSettings_domain'],
//                'domain_ok' => $domainOk,
//            );
//            
//            $this->db->where('sites_id', $siteData['siteID']);
//            if ($this->db->update('sites', $data)) {
//                return true;
//            } else {
//                return false;
//            }
//        }else{
//            return false;
//        }
//    }

    /*

      takes a site ID and returns all the site data, or false is the site doesn't exist

     */

    public function getSite($siteID)
    {

        $this->db->from('sites');
        $this->db->where('sites_id', $siteID);
        $this->db->join('premium_domain', 'sites.sites_id = premium_domain.siteid', 'left');
        $this->db->join('users_domains', 'sites.sites_id = users_domains.site_id', 'left');
        $query = $this->db->get();

        if ($query->num_rows() == 0) {

            return false;
        }

        $res = $query->result();

        $site = $res[0];

        $siteArray = array();
        $siteArray['site'] = $site;


        //get the pages + frames

        $query = $this->db->from('pages')->where('sites_id', $site->sites_id)->where('pages_trashed', 0)->get();

        $res = $query->result();


        $pageFrames = array();

        foreach ($res as $page) {

            //get the frames for each page

            $query = $this->db->from('frames')->where('pages_id', $page->pages_id)->get();

            $pageFrames[$page->pages_name] = $query->result();
        }

        $siteArray['pages'] = $pageFrames;


        //grab the assets folders as well
        $this->load->helper('directory');

        $folderContent = directory_map($this->config->item('elements_dir'), 2);

        $assetFolders = array();

        foreach ($folderContent as $key => $item) {

            if (is_array($item)) {

                array_push($assetFolders, $key);
            }
        }


        $siteArray['assetFolders'] = $assetFolders;

        return $siteArray;
    }

    public function getSiteId($user_id)
    {
        $this->db->select('sites_id');
        $this->db->from('sites');
        $this->db->where('sites_trashed', 0);
        $this->db->where('users_id', $user_id);
        $query = $this->db->get();

        if ($query->num_rows() == 0) {

            return false;
        }

        $res = $query->result();

        $site = $res[0];
        return $site->sites_id;
    }

    /*

      grabs a single frame and returns it

     */

    public function getSingleFrame($frameID)
    {

        $query = $this->db->from('frames')->where('frames_id', $frameID)->get();
        if ($query->num_rows() == 0) {
            return false;
        }
        $res = $query->result();

        return $res[0];
    }

    /*

      gets the assets and pages of a site

     */

    public function getAssetsAndPages($siteID)
    {

        //get the asset folders first, we only grab the first level folders inside $this->config->item('elements_dir')

        $this->load->helper('directory');

        $folderContent = directory_map($this->config->item('elements_dir'), 2);

        $assetFolders = array();

        foreach ($folderContent as $key => $item) {

            if (is_array($item)) {

                array_push($assetFolders, $key);
            }
        }



        //now we get the pages

        $query = $this->db->from('pages')->where('sites_id', $siteID)->get();

        $pages = $query->result();

        $return = array();

        $return['assetFolders'] = $assetFolders;
        $return['pages'] = $pages;

        return $return;
    }

    /*

      moves a site to the trash

     */

    public function trash($siteID)
    {

        $data = array(
            'sites_trashed' => 1
        );

        $this->db->where('sites_id', $siteID);
        if ($this->db->update('sites', $data)) {
            $this->db->where('sites_id', $siteID);
            $this->db->update('pages', array('pages_trashed' => 1));
        }
    }

    /*

      publish a site

     */

    public function publish($siteID, $remote_url)
    {

        $data = array(
            'published' => 1
        );

        $this->db->where('sites_id', $siteID);
        $this->db->update('sites', $data);
    }

    /*

      returns all admin images

     */

    public function adminImages()
    {

        $folderContent = directory_map($this->config->item('images_dir'), 2);

        if ($folderContent) {

            //print_r( $folderContent );

            $adminImages = array();

            foreach ($folderContent as $key => $item) {

                if (!is_array($item)) {

                    //check the file extension

                    $tmp = explode(".", $item);


                    //prep allowed extensions array

                    $temp = explode("|", $this->config->item('images_allowedExtensions'));


                    if (in_array($tmp[1], $temp)) {

                        array_push($adminImages, $item);
                    }
                }
            }

            return $adminImages;
        } else {

            return false;
        }
    }

    private function createPages($siteID, $siteData)
    {
        foreach ($siteData as $pageName => $frames) {

            $data = array(
                'sites_id' => $siteID,
                'pages_name' => $pageName,
                'pages_timestamp' => time()
            );

            $this->db->insert('pages', $data);

            $pageID = $this->db->insert_id();

            //page is done, now all the frames for this page

            foreach ($frames as $frameData) {

                $frameContent = $frameData['frameContent'];
                if (stristr($frameContent, '<link href="' . base_url('elements'))) {
                    $frameContent = str_replace('<link href="' . base_url('elements') . '/', '<link href="', $frameContent);
                }
                if (stristr($frameContent, '<script src="' . base_url('elements'))) {
                    $frameContent = str_replace('<script src="' . base_url('elements') . '/', '<script src="', $frameContent);
                }
                if (stristr($frameContent, 'src="' . base_url('elements') . '/images')) {
                    $frameContent = str_replace('src="' . base_url('elements') . '/images', 'src="images', $frameContent);
                }
                $data = array(
                    'pages_id' => $pageID,
                    'sites_id' => $siteID,
                    'frames_content' => $frameContent,
                    'frames_height' => $frameData['frameHeight'],
                    'frames_original_url' => $frameData['originalUrl'],
                    'frames_timestamp' => time()
                );

                $this->db->insert('frames', $data);
            }
        }
    }

    private function updatePages($siteID, $pages, $siteData, $pagesData)
    {
        foreach ($pages as $page) {
            //delete all frames 
            $this->db->where('pages_id', $page->pages_id);
            $this->db->delete('frames');
            $pagesData[$page->pages_name]['pages_id'] = $page->pages_id;
        }

        //all gone, re-save

        foreach ($siteData as $pageName => $frames) {

            $data = array(
                'sites_id' => $siteID,
                'pages_name' => $pageName,
                'pages_timestamp' => time()
            );

            if (isset($pagesData[$pageName]['pages_title'])) {

                $data['pages_title'] = $pagesData[$pageName]['pages_title'];
                $data['pages_meta_keywords'] = $pagesData[$pageName]['pages_meta_keywords'];
                $data['pages_meta_description'] = $pagesData[$pageName]['pages_meta_description'];
                $data['pages_header_includes'] = $pagesData[$pageName]['pages_header_includes'];
            }

            if (empty($pagesData[$pageName]['pages_id'])) {
                $this->db->insert('pages', $data);
                $pageID = $this->db->insert_id();
                $pagesData[$pageName]['pages_id'] = $pageID;
            } else {
                $this->db->where('pages_id', $pagesData[$pageName]['pages_id']);
                $this->db->update('pages', $data);
            }

            //page is done, now all the frames for this page

            if (is_array($frames)) {

                foreach ($frames as $frameData) {
                    $frameContent = $frameData['frameContent'];
                    if (stristr($frameContent, '<link href="' . base_url('elements'))) {
                        $frameContent = str_replace('<link href="' . base_url('elements') . '/', '<link href="', $frameContent);
                    }
                    if (stristr($frameContent, '<script src="' . base_url('elements'))) {
                        $frameContent = str_replace('<script src="' . base_url('elements') . '/', '<script src="', $frameContent);
                    }
                    if (stristr($frameContent, 'src="' . base_url('elements') . '/images')) {
                        $frameContent = str_replace('src="' . base_url('elements') . '/images', 'src="images', $frameContent);
                    }
                    $data = array(
                        'pages_id' => $pagesData[$pageName]['pages_id'],
                        'sites_id' => $siteID,
                        'frames_content' => $frameContent,
                        'frames_height' => $frameData['frameHeight'],
                        'frames_original_url' => $frameData['originalUrl'],
                        'frames_timestamp' => time()
                    );

                    $this->db->insert('frames', $data);
                }
            }
        }
    }

    /*
      trashes a users' sites
     */

    public function deleteAllFor($userID)
    {

        $data = array(
            'sites_trashed' => 1
        );

        $this->db->where('users_id', $userID);
        $this->db->update('sites', $data);
    }

    public function checkDomainAvailability($domain)
    {
        $query = $this->db->from('users_domains')->where('domain', $domain)->get();
        if ($query->num_rows() > 0) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function delete_pages($site_id, $page_name)
    {
        $this->db->where('sites_id', $site_id);
        $this->db->where('pages_name', $page_name);
        if ($this->db->update('pages', array('pages_trashed' => 1))) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    //function to create users products......shubhangee

    public function createuserproducts($site_id, $productid, $pname, $pprice, $pdescription, $img1)
    {
        $uid = $this->ion_auth->get_user_id();

        $fullui = "";
        if (strpos($img1, "/images/") == true) {
            $fullui = $img1;
        } else {
            $url = site_url();
            $newsite = explode('index.php', $url);

            $fullui = $newsite[0] . "elements/" . $img1;
        }
	
        $query = $this->db->query("select * from users_products where product_id='" . $productid . "' ") or die(mysql_error());
        $res = $query->result();
        if (!empty($res)) {
            $query = $this->db->query("update users_products set name='" . $pname . "',description='" . $pdescription . "',price='" . $pprice . "',site_id='" . $site_id . "',image1='" . $fullui . "' where product_id='" . $productid . "' ");
        } else {
            $query = $this->db->query("insert into users_products(user_id,product_id,name,description,price,site_id,image1)values('" . $uid . "','" . $productid . "','" . $pname . "','" . $pdescription . "','" . $pprice . "','" . $site_id . "','" . $fullui . "')");
        }
    }

}
