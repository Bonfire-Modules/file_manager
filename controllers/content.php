<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		//$this->auth->restrict('Bonfire.Users.View');
		$this->load->model('file_manager_files_model');
		$this->load->model('file_manager_alias_model');
		//$this->lang->load('users');
		//Template::set_block('sub_nav', 'settings/_sub_nav');
	}

	public function index()
	{
		//$this->auth->restrict('Bonfire.Users.Manage')

                Template::set('datatableOptions', array('headers' => 'ID, File name, File path'));
                Template::set('datatableData', $this->file_manager_files_model->find_all());
                
                Template::set('toolbar_title', 'File manager');
		Template::render();
	}
	
	public function create()
	{
		//$this->auth->restrict('Bonfire.Users.Create');
		
		Template::set('toolbar_title', 'Upload form');
		Template::render();
	}
        
        public function view_alias_widget()
        {
                // widget method for in a modules view get the modules file alias and view them in a table
                // also include functionality to remove alias from view and link to upload with that modules id
            
                Template::set('available_modules', $this->get_module_unique_id());

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
			Template::set('toolbar_title', 'Upload failed');
                        Template::set_message($this->upload->display_errors(), 'error');
			Template::set_view('content/create');
		}
		else
		{
			$upload_data = $this->upload->data();

                        // database support, send uploaded file(s) database row ids to view for data entry
			$upload_data['database_row_id'] = 'file1';

                        Template::set('toolbar_title', 'Upload completed');
                        Template::set('upload_data', $upload_data);
			Template::set_message('File uploaded successfully', 'success');
			Template::set_view('content/upload_success');
		}
		
		Template::render();
	}


}