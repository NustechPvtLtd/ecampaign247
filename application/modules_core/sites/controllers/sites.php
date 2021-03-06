<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sites extends MY_Controller {

    public $data = array();
    public $pages = array();
    private $_hostName = 'www.webzero.in';
    private $_userName = 'webzero';
    private $_password = 'kharadi123!@#';

    function __construct()
    {
        parent::__construct();

        $this->load->model('sites/sitemodel');
        $this->load->model('sites/usermodel');
        $this->load->model('sites/pagemodel');
        $this->load->model('domain/domainmodel');
        $this->load->model('domain/users_domains_model');

        $this->data['pageTitle'] = $this->lang->line('sites_page_title');

        if (!$this->ion_auth->logged_in()) {

            redirect('/login');
        }
    }

    /*

      lists all sites

     */

    public function index()
    {

        //grab us some sites
        $this->data['sites'] = $this->sitemodel->all();
        $sites_id = $this->sitemodel->getSiteId($this->ion_auth->get_user_id());
        //get all users
        $this->data['users'] = $this->usermodel->getAll();
        if (!$this->ion_auth->is_admin()) {
            if (count($this->data['sites']) <= 0) {
                redirect(site_url('sites/create'), 'location');
            } else {
                redirect(site_url('sites/' . $sites_id));
            }
        } else {
            $this->data['page'] = "sites";
            $this->data['pageHeading'] = $this->lang->line('sites_header');
            $this->data['css'] = array(
                '<link href="' . base_url() . 'assets/sites/less/flat-ui.css" rel="stylesheet">'
            );
            $this->data['js'] = array(
                '<script type="text/javascript" src="' . base_url() . 'assets/sites/js/sites.js"></script>'
            );
            $this->template->load('sites', 'sites', 'sites/sites', $this->data);
        }
    }

    /*

      load page builder

     */

    public function create()
    {

        //create a  new, empty site

        $newSiteID = $this->sitemodel->createNew();

        redirect('sites/' . $newSiteID);

        //$this->data['builder'] = true;
        //$this->data['page'] = "newPage";
        //$this->load->view('sites/create', $this->data);
    }

    /*

      Used to create new sites AND save existing ones

     */

    public function save($forPublish = 0)
    {

        //do we have a site name?

        /* if( !isset($_POST['siteName']) || $_POST['siteName'] == '' ) {

          $return = array();

          $temp = array();
          $temp['header'] = $this->lang->line('sites_save_error1_heading');
          $temp['content'] = $this->lang->line('sites_save_error1_message');

          $return['responseCode'] = 0;
          $return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);

          die( json_encode($return) );

          } */


        //do we have some frames to save?

        if (!isset($_POST['pageData']) || $_POST['pageData'] == '') {

            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_save_error2_heading');
            $temp['content'] = $this->lang->line('sites_save_error2_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }


        //should we save an existing site or create a new one?

        if ($_POST['siteID'] == 0) {//no siteID provided, creste a new site
            //create the new site
            $siteID = $this->sitemodel->create($_POST['siteName'], $_POST['pageData']);


            //all went well
            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_save_success1_heading');
            $temp['content'] = $this->lang->line('sites_save_success1_message');

            $return['responseCode'] = 1;
            $return['siteID'] = $siteID;
            $return['responseHTML'] = $this->load->view('partials/success', array('data' => $temp), true);

            die(json_encode($return));
        } else {//we have a site ID, update existing site
            $siteID = $_POST['siteID'];

            if (isset($_POST['pagesData'])) {

                $this->sitemodel->update($siteID, $_POST['pageData'], $_POST['pagesData']);
            } else {

                $this->sitemodel->update($siteID, $_POST['pageData']);
            }

            $return = array();

            if ($forPublish == 0) {//regular site save
                $temp = array();
                $temp['header'] = $this->lang->line('sites_save_success2_heading');
                $temp['content'] = $this->lang->line('sites_save_success2_message');
            } elseif ($forPublish == 1) {//saving before publishing, requires different message
                $temp = array();
                $temp['header'] = $this->lang->line('sites_save_success3_heading');
                $temp['content'] = $this->lang->line('sites_save_success3_message');
            }

            $return['responseCode'] = 1;
            $return['siteID'] = $siteID;
            $return['responseHTML'] = $this->load->view('partials/success', array('data' => $temp), true);

            die(json_encode($return));
        }
    }

    /*

      get and retrieve single site data

     */

    public function site($siteID)
    {
        //if user is not an admin, we'll need to check of this site belongs to this user

        if (!$this->ion_auth->is_admin()) {

            if (!$this->sitemodel->isMine($siteID)) {

                redirect('/sites');
            }
        }


        $siteData = $this->sitemodel->getSite($siteID);

        if ($siteData == false) {

            //site could not be loaded, redirect to /sites, with error message

            $this->session->set_flashdata('error', $this->lang->line('sites_site_error1'));

            redirect('/sites/', 'refresh');
        } else {

            $this->data['siteData'] = $siteData;

            //get page data
            $pagesData = $this->pagemodel->getPageData($siteID);

            if ($pagesData) {

                $this->data['pagesData'] = $pagesData;
            }

            //collect data for the image library

            $userID = userdata('user_id');

            $userImages = $this->usermodel->getUserImages($userID);

            if ($userImages) {
                $this->data['userImages'] = $userImages;
            }


            $adminImages = $this->sitemodel->adminImages();

            if ($adminImages) {
                $this->data['adminImages'] = $adminImages;
            }


            $this->data['builder'] = true;
            $this->data['page'] = "site";
            $this->data['js'] = array(
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/sites/js/spectrum.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/sites/js/chosen.jquery.min.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/sites/js/redactor/redactor.min.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/sites/js/redactor/table.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/sites/js/redactor/bufferButtons.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/sites/js/src-min-noconflict/ace.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . site_url('sites/getelements') . '"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/js/jquery.blockUI.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url() . 'assets/sites/js/builder.js"></script>',
                '<script type="text/javascript" defer="defer" src="' . base_url('assets/sites/js/bootstrap-switch.min.js') . '"></script>',
                '<script type="text/javascript" defer="defer" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>',
                '<script type="text/javascript" defer="defer" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>'
            );
            $this->template->load('builder', 'sites', 'sites/create', $this->data);
            //$this->load->view('', $this->data);
        }
    }

    /*

      get and retrieve single site data with ajax

     */

    public function siteAjax($siteID = '')
    {

        if ($siteID == '' || $siteID == 'undefined') {

            //siteID is missing

            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_siteAjax_error1_heading');
            $temp['content'] = $this->lang->line('sites_siteAjax_error1_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }

        $siteData = $this->sitemodel->getSite($siteID);

        if ($siteData == false) {

            //all did not go well
            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_siteAjax_error2_heading');
            $temp['content'] = $this->lang->line('sites_siteAjax_error2_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            echo json_encode($return);
        } else {

            //all went well
            $return = array();

            $return['responseCode'] = 1;
            $return['responseHTML'] = $this->load->view('partials/sitedata', array('data' => $siteData), true);

            echo json_encode($return);
        }
    }

    /*

      updates site details, submitting through ajax

     */

    public function siteAjaxUpdate()
    {

        $this->form_validation->set_rules('siteID', 'Site ID', 'required');
//		$this->form_validation->set_rules('siteSettings_siteName', 'Site name', 'required');
        $this->form_validation->set_rules('siteSettings_domain', 'Domain', 'required');

        if ($this->form_validation->run() == FALSE) {

            //all did not go well
            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_siteAjaxUpdate_error1_heading');
            $temp['content'] = $this->lang->line('sites_siteAjaxUpdate_error1_message1') . validation_errors();

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            echo json_encode($return);
        } else {//all good with the data, let's update
            $user_id = userdata('user_id');
            $domainOk = $this->users_domains_model->create($_POST['siteID'], $user_id, $_POST['siteSettings_domain'], 'freeUrl');

            //all did went well
            $return = array();

            $temp = array();

            if ($domainOk) {
                $temp['header'] = $this->lang->line('sites_siteAjaxUpdate_success_heading');
                $temp['content'] = $this->lang->line('sites_siteAjaxUpdate_success_message');
                $return['responseCode'] = 1;
                $return['responseHTML'] = $this->load->view('partials/success', array('data' => $temp), true);
            } else {
                $temp['header'] = $this->lang->line('sites_siteAjaxUpdate_error1_heading');
                $temp['content'] = $this->lang->line('sites_siteAjaxUpdate_error1_message2');
                $return['responseCode'] = 0;
                $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);
            }

            if ($domainOk) {
                $return['domainOk'] = 1;
            } else {
                $return['domainOk'] = 0;
            }


            //we'll send back the updated site data as well
            $siteData = $this->sitemodel->getSite($_POST['siteID']);

            $return['responseHTML2'] = $this->load->view('partials/sitedata', array('data' => $siteData), true);

//			$return['siteName'] = $siteData['site']->sites_name;
            $return['siteID'] = $siteData['site']->sites_id;

            echo json_encode($return);
        }
    }

    /*

      gets the content of a saved frame and sends it back to the browser

     */

    public function getframe($frameID)
    {

        $frame = $this->sitemodel->getSingleFrame($frameID);
        if (!$frame) {
            return FALSE;
        }
        $frameContent = $frame->frames_content;
        if (!stristr($frameContent, '<link href="' . base_url('elements'))) {
            $frameContent = str_replace('<link href="', '<link href="' . base_url('elements') . '/', $frameContent);
        }
        if (stristr($frameContent, '<link href="' . base_url('elements') . '/https://')) {
            $frameContent = str_replace('<link href="' . base_url('elements') . '/https://', '<link href="https://', $frameContent);
        }
        if (!stristr($frameContent, '<script src="js' . base_url('elements'))) {
            $frameContent = str_replace('<script src="js', '<script src="' . base_url('elements') . '/js', $frameContent);
        }
        if (!stristr($frameContent, 'src="' . base_url('elements') . '/images')) {
            $frameContent = str_replace('src="images', 'src="' . base_url('elements') . '/images', $frameContent);
        }
        echo $frameContent;
    }

    /*
      publishes a site
     */

    public function publish()
    {

        $this->load->helper('file');
        $this->load->helper('directory');
        $params = array('hostname' => $this->_hostName, 'username' => $this->_userName, 'password' => $this->_password);
        $this->load->library('CPanelAddons', $params, 'CPanelAddons');
        $remote_url = '';
//        $this->load->library('CPanelAddons');
        if (!isset($_POST['siteID'])) {

            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_publish_error1_heading');
            $temp['content'] = $this->lang->line('sites_publish_error1_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }

        //some error prevention first
        //siteID ok?
        $siteDetails = $this->sitemodel->getSite($_POST['siteID']);

        if ($siteDetails == false) {

            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_publish_error1_heading');
            $temp['content'] = $this->lang->line('sites_publish_error1_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }
        $userID = $siteDetails['site']->users_id;

        if ($siteDetails['site']->domain_ok != 1 || !isset($siteDetails['site']->domain)) {
            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_publish_error3_heading');
            $temp['content'] = $this->lang->line('sites_publish_error3_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }
        $path = 'public_html/' . $siteDetails['site']->domain;
        $absPath = './' . $siteDetails['site']->domain;
        if (!is_dir($absPath) && $siteDetails['site']->domain != '') {
            mkdir($absPath, 0777);
        }
        //do we have anythin to publish at all?
//		if( !isset( $_POST['xpages'] ) || $_POST['xpages'] == '' ) {
        if (!isset($_POST['item']) || $_POST['item'] == '') {
            //nothing to upload

            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_publish_error2_heading');
            $temp['content'] = $this->lang->line('sites_publish_error2_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }


        /* if(!$siteDetails['site']->published){//Check wheather subdomain is register or not
          $result = $this->CPanelAddons->addSub($siteDetails['site']->domain, $path, "webzero.in");
          if ( isset( $result['cpanelresult']['data'][0]['result'] ) && trim( $result['cpanelresult']['data'][0]['result'] ) == '0'
          ) {
          $return = array();

          $temp = array();
          $temp['header'] = $this->lang->line('sites_publish_error2_heading');
          $temp['content'] = "cPanel: " . $result['cpanelresult']['data'][0]['reason'];

          $return['responseCode'] = 0;
          $return['responseHTML'] = $this->load->view('partials/error', array('data'=>$temp), true);
          die( json_encode( $return ) );
          }
          } */

        if (isset($siteDetails['site']->url_option) && $siteDetails['site']->url_option != 'freeUrl' && $siteDetails['site']->domain_publish == 0) {
            $result = $this->CPanelAddons->add($siteDetails['site']->domain, $path);
            if (isset($result['cpanelresult']['data'][0]['result']) && trim($result['cpanelresult']['data'][0]['result']) == '0'
            ) {
                $return = array();

                $temp = array();
                $temp['header'] = $this->lang->line('sites_publish_error2_heading');
                $temp['content'] = "cPanel: " . $result['cpanelresult']['data'][0]['reason'];

                $return['responseCode'] = 0;
                $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);
                die(json_encode($return));
            } else {
                $this->users_domains_model->domain_publish($_POST['siteID']);
            }
        }
        if ($siteDetails['site']->url_option == 'freeUrl') {
            $remote_url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $siteDetails['site']->domain;
        } else {
            $remote_url = 'http://' . $siteDetails['site']->domain;
        }
//		foreach( $_POST['xpages'] as $page=>$content ) {
        $page = $_POST['item'];
        $content = $_POST['pageContent'];
        //get page meta
        $pageMeta = $this->pagemodel->getSinglePage($_POST['siteID'], $page);

        if (!empty($pageMeta->pages_title)) {
            //insert title, meta keywords and meta description
            $meta = '<title>' . $siteDetails['site']->sites_name . '</title>' . "\r\n";
            $meta .= '<meta name="description" content="' . $pageMeta->pages_meta_description . '">' . "\r\n";
            $meta .= '<meta name="keywords" content="' . $pageMeta->pages_meta_keywords . '">';
            $header_includes = '<script src="https://maps.googleapis.com/maps/api/js?signed_in=false&callback=initMap" async defer></script>';
            $header_includes .= $pageMeta->pages_header_includes;

            $pageContent = str_replace('<!--pageMeta-->', $meta, $content);

            //insert header includes;
            $pageContent = str_replace("<!--headerIncludes-->", $header_includes, $pageContent);
        } else {
            //insert title
            $meta = '<title>' . $siteDetails['site']->sites_name . '</title>';
            $header_includes = '<script src="https://maps.googleapis.com/maps/api/js?signed_in=false&callback=initMap" async defer></script>';

            $pageContent = str_replace('<!--pageMeta-->', $meta, $content);
            $pageContent = str_replace("<!--headerIncludes-->", $header_includes, $pageContent);
        }

        //remove video cover
        $pageContent = str_replace('<div style="" data-selector=".frameCover" class="frameCover" data-type="video"></div>', "", $pageContent);
        $pageContent = str_replace('<div style="margin: 0px;" data-selector=".frameCover" class="frameCover" data-type="video"></div>', "", $pageContent);
        $pageContent = str_replace('<div data-selector=".frameCover" class="frameCover" data-type="video"></div>', "", $pageContent);
        $pageContent = str_replace('<div data-type="video" class="frameCover" data-selector=".frameCover"></div>', "", $pageContent);
        $pageContent = str_replace('class="frameCover"', "", $pageContent);

        $pageContent = str_replace("<!-- site contact url div -->", '<div id="contact-url" data-content="' . site_url('login/site_contact/' . $this->encrypt->encode($_POST['siteID'])) . '"></div>', $pageContent);

        $pageContent = str_replace("<!-- site counter url div -->", '<div id="counter-url" data-content="' . site_url('login/visitor_counter/' . $this->encrypt->encode($_POST['siteID'])) . '"></div>', $pageContent);

        $pageContent = str_replace("<!-- site url div -->", '<div id="site-url" data-content="' . base_url('elements') . '"></div>', $pageContent);

        $pageContent = str_replace("<!-- page id div -->", '<div id="page-id" data-content="' . $pageMeta->pages_id . '"></div>', $pageContent);

        $pageContent = str_replace("<!-- page url div -->", '<div id="page-url" data-content="' . $remote_url . '/' . $page . '.html"></div>', $pageContent);

        if (!stristr($pageContent, '<link href="' . base_url('elements'))) {
            $pageContent = str_replace('<link href="', '<link href="' . base_url('elements') . '/', $pageContent);
        }
        if (stristr($pageContent, '<link href="' . base_url('elements') . '/https://')) {
            $pageContent = str_replace('<link href="' . base_url('elements') . '/https://', '<link href="https://', $pageContent);
        }
        if (!stristr($pageContent, '<script src="' . base_url('elements') . '/js')) {
            $pageContent = str_replace('<script src="js', '<script src="' . base_url('elements') . '/js', $pageContent);
        }
        if (stristr($pageContent, 'src="' . base_url('elements') . '/https://')) {
            $pageContent = str_replace('src="' . base_url('elements') . '/https://', 'src="https://', $pageContent);
        }
        if (stristr($pageContent, '<script src="' . base_url('elements') . '/http://')) {
            $pageContent = str_replace('<script src="' . base_url('elements') . '/http://', '<script src="http://', $pageContent);
        }
        if (strstr($pageContent, 'src="/elements/images')) {
            $pageContent = str_replace('src="/elements/images', 'src="' . base_url('elements') . '/images', $pageContent);
        }
        write_file($absPath . '/' . $page . ".html", $pageContent);
//		}
        (isset($userID) && $userID != '') ? remove_directory('./temp/' . $userID) : '';

        $this->sitemodel->publish($_POST['siteID'], base_url() . $siteDetails['site']->domain);

        if ($siteDetails['site']->url_option == 'freeUrl') {
            $this->users_domains_model->domain_publish($_POST['siteID']);
        }

        //all went well
        $return = array();

        $return['responseCode'] = 1;

        die(json_encode($return));
    }

    /*
      preview a site
     */

    public function preview($pageName = '')
    {
        $this->load->helper('file');
        $this->load->helper('directory');
        $user = $this->ion_auth->user()->row();
        $userID = $user->id;

        (isset($userID) && $userID != '') ? remove_directory('./temp/' . $userID) : '';
        //some error prevention first
        $siteDetails = $this->sitemodel->getSite($_POST['siteID']);

        if ($siteDetails == false) {
            die("No details found");
        }

        //do we have anythin to preview at all?
        if (!isset($_POST['pages']) || $_POST['pages'] == '') {
            die("No page found");
        }
        if (!is_writable('./temp/')) {
            chmod('./temp/', 0777);
        }
        if (!is_dir('./temp/' . $userID)) {
            if (!mkdir('./temp/' . $userID, 0777)) {
                die('Directory not created');
            }
        } else {
            remove_directory('./temp/' . $userID);
            if (!mkdir('./temp/' . $userID, 0777)) {
                die('Directory not created');
            }
        }
        /* if(recurse_copy('./elements/images/', './tmp/'.$userID.'/images/')){

          } */
        foreach ($_POST['pages'] as $page => $content) {
            //get page meta
            $pageMeta = $this->pagemodel->getSinglePage($_POST['siteID'], $page);

            if (!empty($pageMeta->pages_title)) {
                //insert title, meta keywords and meta description
                $meta = '<title>' . $siteDetails['site']->sites_name . '</title>' . "\r\n";
                $meta .= '<meta name="description" content="' . $pageMeta->pages_meta_description . '">' . "\r\n";
                $meta .= '<meta name="keywords" content="' . $pageMeta->pages_meta_keywords . '">';
                $header_includes = '<script src="https://maps.googleapis.com/maps/api/js?signed_in=false&callback=initMap" async defer></script>';
                $header_includes .= $pageMeta->pages_header_includes;

                $pageContent = str_replace('<!--pageMeta-->', $meta, $content);

                //insert header includes;
                $pageContent = str_replace("<!--headerIncludes-->", $header_includes, $pageContent);
            } else {
                //insert title
                $meta = '<title>' . $siteDetails['site']->sites_name . '</title>';
                $header_includes = '<script src="https://maps.googleapis.com/maps/api/js?signed_in=false&callback=initMap" async defer></script>';

                $pageContent = str_replace('<!--pageMeta-->', $meta, $content);

                $pageContent = str_replace("<!--headerIncludes-->", $header_includes, $pageContent);
            }

            //remove viedo cover
            $pageContent = str_replace('<div style="" data-selector=".frameCover" class="frameCover" data-type="video"></div>', "", $pageContent);
            $pageContent = str_replace('<div style="margin: 0px;" data-selector=".frameCover" class="frameCover" data-type="video"></div>', "", $pageContent);
            $pageContent = str_replace('<div data-selector=".frameCover" class="frameCover" data-type="video"></div>', "", $pageContent);
            $pageContent = str_replace('<div data-type="video" class="frameCover" data-selector=".frameCover"></div>', "", $pageContent);
            $pageContent = str_replace('class="frameCover"', "", $pageContent);

            $pageContent = str_replace("<!-- site contact url div -->", '<div id="contact-url" data-content="' . site_url('login/site_contact/' . $this->encrypt->encode($_POST['siteID'])) . '"></div>', $pageContent);

            $pageContent = str_replace("<!-- site url div -->", '<div id="site-url" data-content="' . base_url('elements') . '"></div>', $pageContent);

            if (!stristr($pageContent, '<link href="' . base_url('elements'))) {
                $pageContent = str_replace('<link href="', '<link href="' . base_url('elements') . '/', $pageContent);
            }
            if (stristr($pageContent, '<link href="' . base_url('elements') . '/https://')) {
                $pageContent = str_replace('<link href="' . base_url('elements') . '/https://', '<link href="https://', $pageContent);
            }
            if (!stristr($pageContent, '<script src="' . base_url('elements'))) {
                $pageContent = str_replace('<script src="', '<script src="' . base_url('elements') . '/', $pageContent);
            }
            if (stristr($pageContent, 'src="' . base_url('elements') . '/https://')) {
                $pageContent = str_replace('src="' . base_url('elements') . '/https://', 'src="https://', $pageContent);
            }
            if (stristr($pageContent, '<script src="' . base_url('elements') . '/http://')) {
                $pageContent = str_replace('<script src="' . base_url('elements') . '/http://', '<script src="http://', $pageContent);
            }
            if (strstr($pageContent, 'src="/elements/images')) {
                $pageContent = str_replace('src="/elements/images', 'src="' . base_url('elements') . '/images', $pageContent);
            }
            if (!write_file('./temp/' . $userID . '/' . $page . ".html", '<html>' . $pageContent . '</html>')) {
                die("Page not created!");
            }
        }
        redirect(base_url() . 'temp/' . $userID);
    }

    /*

      moves a single site to the trash bin

     */

    public function trash($siteID = '')
    {

        $this->load->helper('file');
        if ($siteID == '' || $siteID == 'undefined') {

            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_trash_error1_heading');
            $temp['content'] = $this->lang->line('sites_trash_error1_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }

        $params = array('hostname' => $this->_hostName, 'username' => $this->_userName, 'password' => $this->_password);
        $this->load->library('CPanelAddons', $params, 'CPanelAddons');

        $siteData = $this->sitemodel->getSite($siteID);

        if (isset($siteData['site']->domain) && $siteData['site']->published) {
            $result = $this->CPanelAddons->delSub($siteData['site']->domain, "webzero.in");
            if (isset($result['cpanelresult']['data'][0]['result']) && trim($result['cpanelresult']['data'][0]['result']) == '0') {
                $return = array();

                $temp = array();
                $temp['header'] = $this->lang->line('sites_trash_error1_heading');
                $temp['content'] = "cPanel: " . $result['cpanelresult']['data'][0]['reason'];

                $return['responseCode'] = 0;
                $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);
                die(json_encode($return));
            }
            $absPath = './' . $siteData['site']->domain;
            remove_directory($absPath);
        }
        //all good, move to trash

        $this->sitemodel->trash($siteID);

        $return = array();

        $temp = array();
        $temp['header'] = $this->lang->line('sites_trash_success_heading');
        $temp['content'] = $this->lang->line('sites_trash_success_message');

        $return['responseCode'] = 1;
        $return['responseHTML'] = $this->load->view('partials/success', array('data' => $temp), true);

        die(json_encode($return));
    }

    /*

      updates page meta data via ajax

     */

    public function updatePageData()
    {

        if ($_POST['siteID'] == '' || $_POST['siteID'] == 'undefined' || !isset($_POST)) {

            $return = array();

            $temp = array();
            $temp['header'] = $this->lang->line('sites_updatePageData_error1_heading');
            $temp['content'] = $this->lang->line('sites_updatePageData_error1_message');

            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('partials/error', array('data' => $temp), true);

            die(json_encode($return));
        }

        //update page data
        $this->pagemodel->updatePageData($_POST);

        $return = array();

        //return page data as well
        $pagesData = $this->pagemodel->getPageData($_POST['siteID']);

        if ($pagesData) {
            $return['pagesData'] = $pagesData;
        }

        $temp = array();
        $temp['header'] = $this->lang->line('sites_updatePageData_success_heading');
        $temp['content'] = $this->lang->line('sites_updatePageData_success_message');

        $return['responseCode'] = 1;
        $return['responseHTML'] = $this->load->view('partials/success', array('data' => $temp), true);
        $siteData = $this->sitemodel->getSite($_POST['siteID']);
        $return['siteName'] = $siteData['site']->sites_name;
        $return['siteID'] = $siteData['site']->sites_id;
        die(json_encode($return));
    }

    public function checkDomain()
    {
        if (isset($_POST['domain']) && $_POST['domain'] != '') {
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $_POST['domain'];
            if ($this->sitemodel->checkDomainAvailability($_POST['domain'])) {
                $return['error'] = 0;
                $return['errorMessage'] = $url . ' is available.';
                echo json_encode($return);
            } else {
                $return['error'] = 1;
                $return['errorMessage'] = $url . ' is not available.';
                die(json_encode($return));
            }
        }
    }

    /*
     * Page Delete function to delete sites pages
     * 
     */

    public function page_delete()
    {
        if (isset($_POST['site_id']) && $_POST['page_name'] != '') {
            if ($this->sitemodel->delete_pages($_POST['site_id'], $_POST['page_name'])) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    //function to create users products......shubhangee
    public function createuserproducts()
    {
        $site_id = $_POST['site_id'];
        $productid = $_POST['productid'];
        $pname = $_POST['pname'];
        $pprice = $_POST['pprice'];
        $pdescription = $_POST['pdescription'];
        $img1 = $_POST['img1'];

        $this->sitemodel->createuserproducts($site_id, $productid, $pname, $pprice, $pdescription, $img1);
    }

}

/* End of file sites.php */
/* Location: ./application/controllers/sites.php */