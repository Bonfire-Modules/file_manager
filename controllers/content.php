<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		//$this->auth->restrict('Bonfire.Users.View');
		//$this->load->model('roles/role_model');
		//$this->lang->load('users');
		//Template::set_block('sub_nav', 'settings/_sub_nav');
	}

	public function index()
	{
		//$this->auth->restrict('Bonfire.Users.Manage');
		
		Template::set('toolbar_title', 'File manager');
		Template::render();
	}
	
	public function create()
	{
		//$this->auth->restrict('Bonfire.Users.Create');
		
		Template::set('toolbar_title', 'Upload form');
		Template::render();
	}

	function do_upload()
	{
		// restrict upload functionality
		//$this->auth->restrict('Bonfire.Users.Create');
		
		$this->config->load('config');

		$upload_config = $this->config->item('upload_config');

		foreach($upload_config as $setting => $value)
		{
			$config[$setting] = $value;
		}
		
		// new file name support, rename file(s) according to md5 checksums
		$config['file_name'] = md5(rand(20000, 90000));

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload())
		{
			Template::set('data', array('toolbar_title' => 'Upload failed'));
			Template::set_message($this->upload->display_errors(), 'error');
			Template::set_view('content/create');
		}
		else
		{
			$upload_data = $this->upload->data();

			// database support, send uploaded file(s) database row ids to view for data entry
			$upload_data['database_row_id'] = 'file1';
				
			Template::set('data', array(
				'upload_data' => $upload_data,
				'toolbar_title' => 'Upload completed'));
			    
			Template::set_message('File uploaded successfully', 'success');
			Template::set_view('content/upload_success');
		}
		
		Template::render();
	}
}