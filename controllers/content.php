<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		//$this->auth->restrict('Bonfire.Users.View');
		$this->load->model('file_manager_files_model');
		$this->load->model('file_manager_alias_model');
		$this->lang->load('file_manager');
		Template::set_block('sub_nav', 'content/_sub_nav');

                
         // change these vice versa, index value
                $this->display_values = array(
                    //'File name'     => 'file_name', 
                    lang('file_manager_display_values_file_type')       => 'file_type',
                    lang('file_manager_display_values_client_name')     => 'client_name',
                    lang('file_manager_display_values_file_ext')        => 'file_ext',
                    lang('file_manager_display_values_file_size')       => 'file_size',
                    lang('file_manager_display_values_image_width')     => 'image_width',
                    lang('file_manager_display_values_image_height')    => 'image_height',
                    lang('file_manager_display_values_database_row_id') => 'database_row_id'
                );
       
        }

	public function index()
	{
		//$this->auth->restrict('Bonfire.Users.Manage')

                Template::set('datatableOptions', array(
                    'headers' => 'ID, Name, Description, Tags, Public, sha1_checksum, Extension'));
                $datatableData = $this->file_manager_files_model->select('id, file_name, description, tags, public, sha1_checksum, extension')->find_all();
		
                // build in this to datatable git before first release of this
                // and improve it!

		if(is_array($datatableData))
		{
			foreach($datatableData as $temp_key => $temp_value)
			{
				$datatableData[$temp_key]->sha1_checksum = '<a target="_blank" href="' . site_url(SITE_AREA .'/widget/file_manager/download/' . $temp_value->id) . '">' . $datatableData[$temp_key]->sha1_checksum . "</a>";
				$datatableData[$temp_key]->file_name = '<a href="' . site_url(SITE_AREA .'/content/file_manager/edit/' . $temp_value->id) . '">' . $datatableData[$temp_key]->file_name . "</a>";
			}
		}

		Template::set('datatableData', $datatableData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_index'));
		Template::render();
	}
	
		public function ftp_upload()
	{
		//$this->auth->restrict('Bonfire.Users.Manage')

                Template::set('datatableOptions', array(
                    'headers' => 'ID, Name, Description, Tags, Public, sha1_checksum, Extension'));
                $datatableData = $this->file_manager_files_model->select('id, file_name, description, tags, public, sha1_checksum, extension')->find_all();
                
                // build in this to datatable git before first release of this
                // and improve it!

		if(is_array($datatableData))
		{
			foreach($datatableData as $temp_key => $temp_value)
			{
				$datatableData[$temp_key]->sha1_checksum = '<a target="_blank" href="' . site_url(SITE_AREA .'/widget/file_manager/download/' . $temp_value->id) . '">' . $datatableData[$temp_key]->sha1_checksum . "</a>";
				$datatableData[$temp_key]->file_name = '<a href="' . site_url(SITE_AREA .'/content/file_manager/edit/' . $temp_value->id) . '">' . $datatableData[$temp_key]->file_name . "</a>";
			}
		}

		Template::set('datatableData', $datatableData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_index'));
		Template::render();
	}
	
	public function create()
	{
		//$this->auth->restrict('Bonfire.Users.Create');
		
		Template::set('toolbar_title', lang('file_manager_toolbar_title_create'));
		Template::render();
	}
        
        public function edit()
        {
		$id = $this->uri->segment(5);

		if (empty($id))
		{
			Template::set_message(lang('file_manager_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/file_manager');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('file_manager.Content.Edit');

			if ($this->save_file_manager_files('update', $id))
			{
				// Log the activity
//				$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');

				Template::set_message(lang('file_manager_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('file_manager_edit_failure') . $this->file_manager_model->error, 'error');
			}
		}
		else if (isset($_POST['delete']))
		{
			$this->auth->restrict('file_manager.Content.Delete');

			if ($this->file_manager_files_model->delete($id))
			{
				// Log the activity
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');

				Template::set_message(lang('file_manager_delete_success'), 'success');

				redirect(SITE_AREA .'/content/file_manager');
			} else
			{
				Template::set_message(lang('file_manager_delete_failure') . $this->file_manager_model->error, 'error');
			}
		}

		$this->file_manager_alias_model->
			select('file_manager_alias.id, file_manager_files.file_name, file_manager_alias.override_file_name, file_manager_alias.target_module, file_manager_alias.target_table, file_manager_alias.target_table_row_id')->
			where('file_id', $id);
		
		$this->db->join('file_manager_files', 'file_manager_alias.file_id = file_manager_files.id', 'inner');
		Template::set('alias_records', $this->file_manager_alias_model->find_all());

		Template::set('file_record', $this->file_manager_files_model->find($id));
		Template::set('id', $id);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_edit'));

		// appropriate as library function (private function get_available_module_models())
		$this->load->config('config');
		$alias_config = $this->config->item('alias_config');
		array_push($alias_config['exclude_target_modules'], 'file_manager');
		$unfiltered_custom_module_models = module_files(null, 'models', true);
		foreach($alias_config['include_core_modules'] as $core_module_name => $core_module_data)
		{
			$unfiltered_custom_module_models[$core_module_name] = $core_module_data;
		}
		foreach($unfiltered_custom_module_models as $module_name => $unfiltered_custom_module_models_data)
		{
			if(in_array($module_name, $alias_config['exclude_target_modules'])) continue;
			$custom_module_models[$module_name] = $unfiltered_custom_module_models_data;
		}
		$available_models = $custom_module_models;
		ksort($available_models);
		// end: appropriate lib.func.
		
		Template::set('modules', $available_models);
		
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
		
                $this->load->library('upload', $config);

		if (!$this->upload->do_upload())
		{
			Template::set('toolbar_title', lang('file_manager_toolbar_title_failed'));
                        Template::set_message($this->upload->display_errors(), 'error');
			Template::set_view('content/create');
		}
		else
		{
			$upload_data = $this->upload->data();
                        
                        // Get sha1 checksum
                        $sha1_checksum = sha1_file($upload_data['full_path']);

                        // Add case to see if file exists, destroy file and send to create file alias form with pre-set
                        $file_exists = $this->file_manager_files_model->select('id, file_name, description, tags, public')->find_by('sha1_checksum', $sha1_checksum);

			if(!$file_exists) {
                        // (if file with checksum dosent exist) Rename file from temp. generated md5 value to sha1 checksum
				rename($upload_data['full_path'], $upload_data['file_path']."/".$sha1_checksum);

				$file_info = array(
				    'id'                => NULL,
				    'file_name'         => $this->security->sanitize_filename(basename($upload_data['client_name'])),
				    'description'       => '',
				    'tags'              => '',
				    'owner_user_id'      => $this->current_user->id,
				    'public'            => 0,
				    'sha1_checksum'     => $sha1_checksum,
				    'extension'         => substr($upload_data['file_ext'], 1),
				    'created'           => date("Y-m-d H:i:s")
				);
			} else {
				unlink($upload_data['full_path']);
			}
                        // write uploaded file to db (first check existence)                        
                        $mysql_insert_id = ($file_exists) ? $file_exists->id : $this->file_manager_files_model->insert($file_info);

                        // database support, send uploaded file(s) database row ids to view for data entry
                        $upload_data['database_row_id'] = $mysql_insert_id;
                        $upload_data['file_database_row'] = $file_exists;
                        
			// Log the activity, add if(file exists or not)
			$log_tmp_str = ($file_exists) ? 'Upload failed: File exists ( file id: ' . $mysql_insert_id . ' file name: '.$file_exists->file_name.' sha1 checksum: '.$sha1_checksum.' )' : 'File uploaded ( file id: ' . $mysql_insert_id . ' file name: '.$file_info['file_name'].' sha1 checksum: '.$sha1_checksum.' )';
			$this->activity_model->log_activity($this->current_user->id, $log_tmp_str.' : ' . $this->input->ip_address(), 'file_manager');

                        Template::set('toolbar_title', lang('file_manager_toolbar_title_upload_success'));
                        Template::set('display_values', $this->display_values);
                        Template::set('upload_data', $upload_data);

                        ($file_exists) ? Template::set_message(lang('file_manager_message_file_exists')) : Template::set_message(lang('file_manager_message_upload_successful'), 'success');

                        if($file_exists) Template::set_block('file_exists', 'content/file_exists', null);
			
                        Template::set_view('content/add_upload_information');
		}
		
		Template::render();
	}
        

        public function add_upload_information()
	{
		$id = $this->uri->segment(5);
                

                if (empty($id))
		{
			Template::set_message(lang('file_manager_invalid_id'), 'error');
                        die("file_manager_invalid id");
			//redirect(SITE_AREA .'/content/file_manager');
		}

		if (isset($_POST['save']) && !empty($id))
		{
			$this->auth->restrict('file_manager.Content.Edit');

			if ($this->save_file_manager_files('update', $id))
			{
				// Log the activity
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');

				Template::set_message(lang('file_manager_edit_uploading_success'), 'success');
			}
			else
			{
				Template::set_message(lang('file_manager_edit_failure') . $this->file_manager_model->error, 'error');
			}
		}
                
                Template::set('display_values', $this->display_values);
                
                Template::set('toolbar_title', lang('file_manager_toolbar_title_add_info'));
                Template::render();
                
	}

	private function save_file_manager_files($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}
		
		$this->form_validation->set_rules('file_name','File name','required|max_length[255]');
		$this->form_validation->set_rules('description','Description','');
		$this->form_validation->set_rules('tags','Tags','max_length[255]');
		$this->form_validation->set_rules('public','Public','max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['file_name']      = $this->input->post('file_name');
		$data['description']    = ($this->input->post('description')) ? $this->input->post('description') : '';
		$data['tags']           = ($this->input->post('tags')) ? $this->input->post('tags') : '';
		$data['public']         = $this->input->post('public');

		if ($type == 'update')
		{
			$return = $this->file_manager_files_model->update($id, $data);
		}

		return $return;
	}

/*
	private function save_file_manager($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		// make sure we only pass in the fields we want
		
		$data = array();
		$data['file_manager_file_name']		= $this->input->post('file_manager_file_name');
		$data['file_manager_description']	= $this->input->post('file_manager_description');
		$data['file_manager_tags']		= $this->input->post('file_manager_tags');
		$data['file_manager_public']		= $this->input->post('file_manager_public');

		if ($type == 'insert')
		{
			$id = $this->file_manager_files_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if ($type == 'update')
		{
			$return = $this->file_manager_files_model->update($id, $data);
		}

		return $return;
	}
*/
	
}
