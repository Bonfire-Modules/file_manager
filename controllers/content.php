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
                        
                        // Get sha1 checksum
                        $sha1_checksum = sha1_file($upload_data['full_path']);
                        
                        // Add case to see if file exists, destroy file and send to create file alias form with pre-set
                        
                        // (if file with checksum dosent exist) Rename file from temp. generated md5 value to sha1 checksum
                        rename($upload_data['full_path'], $upload_data['file_path']."/".$sha1_checksum);

                        $file_info = array(
                            'id'                => NULL,
                            'file_name'         => $upload_data['client_name'],
                            'description'       => '',
                            'tags'              => '',
                            'owner_userid'      => $this->current_user->id,
                            'public'            => '1',
                            'sha1_checksum'     => $sha1_checksum,
                            'created'           => date("Y-m-d H:i:s")
                        );
                        
                        // write uploaded file to db (first check existence)                        
                        $mysql_insert_id = $this->file_manager_files_model->insert($file_info);
                        
                        // database support, send uploaded file(s) database row ids to view for data entry
			$upload_data['database_row_id'] = $mysql_insert_id;
 
			// Log the activity
                        $this->activity_model->log_activity($this->current_user->id, 'File uploaded'.'(file id: ' . $insert_id . ' ) : ' . $this->input->ip_address(), 'file_manager');
                        
                        Template::set('toolbar_title', 'Upload completed');
                        Template::set('upload_data', $upload_data);
			Template::set_message('File uploaded successfully', 'success');
			Template::set_view('content/upload_success');
		}
		
		Template::render();
	}


}