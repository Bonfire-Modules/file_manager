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
                    'headers' => 'ID, Thumbnail, Name, Description, Tags, Public, sha1_checksum, Extension'));
                $datatableData = $this->file_manager_files_model->select('id, id as thumbnail, file_name, description, tags, public, sha1_checksum, extension')->find_all();
		
                // build in this to datatable git before first release of this
                // and improve it!

		if(is_array($datatableData))
		{
			foreach($datatableData as $temp_key => $temp_value)
			{
				$datatableData[$temp_key]->sha1_checksum = '<a target="_blank" href="' . site_url(SITE_AREA .'/widget/file_manager/download/' . $temp_value->id) . '">' . $datatableData[$temp_key]->sha1_checksum . "</a>";
				$datatableData[$temp_key]->file_name = '<a href="' . site_url(SITE_AREA .'/content/file_manager/edit/' . $temp_value->id) . '">' . $datatableData[$temp_key]->file_name . "</a>";
				$datatableData[$temp_key]->thumbnail = '<img src="' . site_url(SITE_AREA .'/content/file_manager/thumbnail/' . $temp_value->id) . '" />';
				//die($this->icon_exists($temp_value->extension));
				//$tmp_file_path  = $this->icon_exists($temp_value->extension);
				//$tmp_file_path= "";
				//if($tmp_file_path) {
					$datatableData[$temp_key]->extension = '<img src="' . site_url(SITE_AREA .'/content/file_manager/icon/' . $temp_value->extension) . '.png" />';					
				//}
			}
		}

		Template::set('datatableData', $datatableData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_index'));
		Template::render();
	}
	
	public function list_aliases()
	{
		
		// Continue here:
		// when outputing existing_alias, parameters should define how to handle override values
		// also, what is sent to output regarding caller module, model and row id
		// think about common functions, both widget and content context uses existing_alias
		
		Template::set('toolbar_title', lang('file_manager_manage_aliases'));
		Template::Set('datatableOptions', array('headers' => 'id, file id'));
		Template::set('datatableData', $this->file_manager_alias_model->select('file_id, override_file_name, ')->find_all());
		Template::render();
	}
	
	public function import()
	{
		//$this->auth->restrict('Bonfire.Users.Manage')

                Template::set('datatableOptions', array(
                    'headers' => 'Mapp, Namn, Storlek, Datum, '));

		$datatableData = array(); 
		$this->load->helper('file');

		$import_dir = get_dir_file_info(realpath(FCPATH).'/../application/modules/file_manager/file-import/', $top_level_only = FALSE);
		if(is_array($import_dir))
		{
			foreach ($import_dir as $row)
			{
				$datatableData[] = array($rowObj->column = str_replace('file-import','-',basename ( $row['relative_path'] )), $row['name'], round(($row['size']/1024)).' kB', date('Y-m-d H:i:s', $row['date']), '<a href="?" class="btn btn-mini"><i class="icon-ok">&nbsp;</i> Importera</a> <a href="?" class="btn btn-mini"><i class="icon-ok">&nbsp;</i> Ladda ner</a> <a href="?" class="btn btn-mini"><i class="icon-ok">&nbsp;</i> Visa</a>');	
			}
		}
		Template::set('datatableData', $datatableData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_import'));
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
				Template::set_message(lang('file_manager_edit_failure') . $this->file_manager_files_model->error, 'error');
			}
		}
		else if(isset($_POST['save_alias']))
		{
			$this->auth->restrict('file_manager.Content.Create');

			if ($this->save_file_manager_alias('insert', $id))
			{
				// Log the activity
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');

				Template::set_message(lang('file_manager_alias_create_success'), 'success');
			}
			else
			{
				Template::set_message(lang('file_manager_alias_create_failure') . $this->file_manager_alias_model->error, 'error');
			}
		}
		else if(isset($_POST['delete']))
		{
			$this->auth->restrict('file_manager.Content.Delete');

			if ($this->file_manager_files_model->delete($id))
			{
				// Log the activity
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');

				// add issue about warning if the file has aliases
				if($this->file_manager_alias_model->delete_where(array('file_id' => $id)))
				{
					Template::set_message(lang('file_manager_delete_success'), 'success');
					redirect(SITE_AREA .'/content/file_manager');
				} else
				{
					Template::set_message(lang('file_manager_delete_alias_failure') . $this->file_manager_alias_model->error, 'error');
				}

			} else
			{
				Template::set_message(lang('file_manager_delete_failure') . $this->file_manager_files_model->error, 'error');
			}
		}
		else if(isset($_POST['delete_alias']))
		{			
//			$this->auth->restrict('file_manager.Content.Delete');

			$checked = $this->input->post('checked');

			if (is_array($checked) && count($checked))
			{
				foreach ($checked as $alias_id)
				{
					if($this->file_manager_alias_model->delete_where(array('id' => $alias_id)))
					{
						$template_message = lang('file_manager_alias_delete_success');
						$template_message_type = 'success';
					} else
					{
						$template_message = lang('file_manager_alias_delete_failure') . $this->file_manager_alias_model->error;
						$template_message_type = 'error';
						break;
					}

					// for later use, adjust so that it queries the database once with IN-statement
					//if(!empty($in_values)) $in_values .= ', ';//$in_values .= $alias_id;
				}
				
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');

				Template::set_message($template_message, $template_message_type);
			}
		}

		$this->file_manager_alias_model->
			select('file_manager_alias.id, file_manager_files.file_name, file_manager_files.extension, file_manager_alias.override_file_name, file_manager_alias.target_module, file_manager_alias.target_model, file_manager_alias.target_model_row_id')->
			where('file_id', $id);
		
		$this->db->join('file_manager_files', 'file_manager_alias.file_id = file_manager_files.id', 'inner');
		Template::set('alias_records', $this->file_manager_alias_model->find_all());

		Template::set('file_record', $this->file_manager_files_model->find($id));
		Template::set('id', $id);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_edit'));

		
		Assets::add_js($this->load->view('content/init_chained_alias_select', null, true), 'inline');
		
		$available_module_models = $this->get_available_module_models();
		Template::set('module_models', $available_module_models);
		
		Template::render();
		
        }

	public function edit_alias()
	{
		$file_id = $this->uri->segment(5);
		$id = $this->uri->segment(6);

		if (empty($id))
		{
			Template::set_message(lang('file_manager_alias_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/file_manager/edit' . $file_id);
		}

		if (isset($_POST['save_alias']))
		{
			//$this->auth->restrict('file_manager_alias.Content.Edit');

			if ($this->save_file_manager_alias('update', $id))
			{
				// Log the activity
//				$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');

				Template::set_message(lang('file_manager_alias_edit_success'), 'success');
			}
			else
			{
				Template::set_message(lang('file_manager_alias_edit_failure') . $this->file_manager_files_model->error, 'error');
			}
		}
		

		Assets::add_js($this->load->view('content/init_chained_alias_select', null, true), 'inline');

		$available_module_models = $this->get_available_module_models();
		Template::set('module_models', $available_module_models);

		Template::set('toolbar_title', lang('file_manager_alias_edit_heading'));
		
		Template::set('alias_record', $this->file_manager_alias_model->find_by('id', $id));
		Template::set('file_id', $file_id);
		Template::set('id', $id);
		Template::render();
	}
        
	public function do_upload()
	{
		// restrict upload functionality
		//$this->auth->restrict('Bonfire.Users.Create');
		
		$this->config->load('config');

		$upload_config = $this->config->item('upload_config');

		foreach($upload_config as $setting => $value)
		{
			$config[$setting] = $value;
		}
		
		// SECURITY FEATURE: create temp. filename for uploaded file to prevent encoding errors and invalid filename
      		$config['file_name'] = md5(rand(20000, 90000));
		
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
			$file_info = array();
			
			if(!$file_exists) {
                        // (if file with checksum dosent exist) Rename file from temp. generated md5 value to sha1 checksum
				rename($upload_data['full_path'], $upload_data['file_path']."/".$sha1_checksum);
				//$tmp_client_name =     $this->convert_client_filename($upload_data['client_name'], $upload_data['file_ext']);

				$file_info = array(
				    'id'                => NULL,
				    'file_name'         => $this->security->sanitize_filename(basename($this->convert_client_filename($upload_data['client_name'], $upload_data['file_ext']))),
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
                        Template::set('file_info', $file_info);
			
                        ($file_exists) ? Template::set_message(lang('file_manager_message_file_exists')) : Template::set_message(lang('file_manager_message_upload_successful'), 'success');

                        if($file_exists) Template::set_block('file_exists', 'content/file_exists', null);
			
                        Template::set_view('content/add_upload_information');
		}
		
		Template::render();
	}

	        public function thumbnail()
        {
                // is there more ways to add file validation rules except for the ones in the view
                // for instance something to reject certain files and so on?
                // also, add support for view files inline, could be available to settings
                
                $this->output->enable_profiler(false);

                $this->load->config('config');
                $module_config = $this->config->item('upload_config');
		
                $this->load->model('file_manager_files_model');

                $file_id = $this->uri->segment(5);

                $record = $this->file_manager_files_model->select('sha1_checksum, file_name, extension')->find_by('id', $file_id);

                $file_path = null;
                if($record)
                {
                        $path_parts = pathinfo($record->sha1_checksum);
                        $file_name  = $path_parts['basename'];
                        $file_path  = $module_config['upload_path'].$file_name;
                }

                if(file_exists($file_path))
                {

                        // move to config file, combine with upload_config item and allowed_types index
                        $content_types = array(
                                'gif'   => "image/gif",
                                'jpg'   => "image/jpeg",
                                'jpeg'  => "image/jpeg",
                                'png'   => "image/png",
                                'pdf'   => "application/pdf",
                                'doc'   => "application/msword",
                                'docx'  => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                                'xls'   => "application/vnd.ms-excel",
                                'xlsx'  => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                                'ppt'   => "application/vnd.ms-powerpoint",
                                'pptx'  => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
                                'odt'   => "application/vnd.openxmlformats-officedocument.presentationml.presentation",
                                'zip'   => "application/zip",
                                'gzip'  => "application/gzip"
                        );
                    
                        $attachment_name = preg_replace('/[^a-z0-9]/i', '_', substr($record->file_name, 0, 20)) . '.' . $record->extension;
                        
                        
                        $this->load->vars(array(
                                'file_path'         => $file_path,
                                'content_type'      => $content_types[$record->extension],
                                'attachment_name'   => $attachment_name
                        ));

                        $this->load->view('content/thumbnail');
                }
                else
                {
                        $this->load->view('widget/thumbnail_failed');
                }
        }
		
	public function icon()
	{
		$image = $this->uri->segment(5);
		$file_path  = $this->icon_exists($image, "");
		if(file_exists($file_path)) {
			$this->load->vars(array(
				'file_path'         => $file_path,
				'content_type'      => "image/png",
				'attachment_name'   => $image
			));
			$this->load->view('content/display_icon');
		}
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
	
	private function generate_thumbnail($path, $size = "small") 
	{
		$this->load->config('config');
                $module_config_thumb = $this->config->item('upload_config');
		
		$config['image_library']	= 'gd2';
		$config['source_image']		= $path;
		$config['create_thumb']		= TRUE;
		$config['maintain_ratio']	= TRUE;
		$config['width']		= $module_config_thumb['thumb_small_width'];
		$config['height']		= $module_config_thumb['thumb_small_height'];
		$this->load->library('image_lib', $config); 
		$this->image_lib->resize();
	}
	
	private function get_available_module_models()
	{
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
		$available_module_models = $custom_module_models;
		ksort($available_module_models);
		return $available_module_models;
		// end: appropriate lib.func.
	}
	
	private function convert_client_filename ($filename, $extension) 
	{
		$client_filename = 0;
		// Remove extension from filename
		$client_filename = preg_replace('/'.$extension.'$/', '', $filename);
		$client_filename = str_replace('_', ' ', $client_filename);
		$client_filename = str_replace('+', ' ', $client_filename);
		$client_filename = str_replace('  ', ' ', $client_filename);
		$client_filename = ucfirst($client_filename);
		return $client_filename;
	}
	
	private function icon_exists($extension, $add = ".png") {
		
		$this->load->config('config');
		$module_config2 = $this->config->item('upload_config');

		$file_path  = $module_config2['module_path']."assets/images/Free-file-icons/32px/".$extension.$add;
		if(file_exists($file_path)) {
			return $file_path;
		}
		return 0;
	
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

	private function save_file_manager_alias($type='insert', $id=0)
	{
		if($type == 'update') {
			$_POST['id'] = $id;
		}
		
		if($type == 'insert')
		{
			$file_id = $id;
		}
		
		$this->form_validation->set_rules('alias_override_file_name','Override file name','max_length[255]');
		$this->form_validation->set_rules('alias_override_description','Description','');
		$this->form_validation->set_rules('alias_override_tags','Tags','max_length[255]');
		$this->form_validation->set_rules('alias_override_public','Public','max_length[255]');
		$this->form_validation->set_rules('alias_target_module','Target module','required|max_length[255]');
		$this->form_validation->set_rules('alias_target_model','Target model','max_length[255]');
		$this->form_validation->set_rules('alias_target_model_row_id','Target model row id','max_length[11]');

		if($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		$data = array();
		if($type == 'insert') $data['file_id'] = $file_id;
		$data['override_file_name']	= $this->input->post('alias_override_file_name');
		$data['override_description']	= ($this->input->post('alias_override_description')) ? $this->input->post('alias_override_description') : '';
		$data['override_tags']		= ($this->input->post('alias_override_tags')) ? $this->input->post('alias_override_tags') : '';
		$data['override_public']	= $this->input->post('alias_override_public');
		$data['target_module']		= $this->input->post('alias_target_module');
		$data['target_model']		= ($this->input->post('alias_target_model')) ? $this->input->post('alias_target_model') : '';
		$data['target_model_row_id']	= ($this->input->post('alias_target_model_row_id') ? $this->input->post('alias_target_model_row_id') : 0);

		if($type == 'insert')
		{
			$id = $this->file_manager_alias_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if($type == 'update')
		{
			$return = $this->file_manager_alias_model->update($id, $data);
		}

		return $return;
	}

}
