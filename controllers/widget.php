<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
                
                $this->load->config('config');
		
		$this->load->model('file_manager_files_model');
		$this->load->model('file_manager_alias_model');
		$this->load->model('file_manager_settings_model');
		
		$this->file_manager_files_model->set_table('file_manager_files');
		$this->file_manager_alias_model->set_table('file_manager_alias');
		$this->file_manager_settings_model->set_table('file_manager_settings');
	}

        public function alias($params=null)
        {
		$display_header = true;
		$target_module = null;
		$target_model = null;
		$target_model_row_id = null;
		
		// Try to autorun the alias widget
		if(isset($params['autorun']))
		{
			$target_module = in_array('module', $params['autorun']) ? $this->auto_get_module() : null;
			$target_model = in_array('model', $params['autorun']) ? $this->auto_get_model() : null;
			$target_model_row_id = in_array('model_row_id', $params['autorun']) ? $this->auto_get_model_row_id() : null;
		}
		
		// Override autorun targets if manual targets is set, regardless of whether autorun is set or not
		if(isset($params['target_module']))
		{
			$target_module = $params['target_module'];
		}

		if(isset($params['target_model']))
		{
			$target_model = $params['target_model'];
		}

		if(isset($params['target_model_row_id']))
		{
			$target_model_row_id = $params['target_model_row_id'];
		}

		$alias_records = $this->file_manager_alias_model->get_aliases($target_module, $target_model, $target_model_row_id);
		
		if($alias_records)
		{
			foreach($alias_records as $alias_key =>$alias_record)
			{
				if(has_permission('file_manager.Widget.Download'))
				{
					// Create download link if user has permission to download files
					$alias_records[$alias_key]->file_name = anchor(SITE_AREA . '/widget/file_manager/download/' . $alias_record->id, $alias_record->file_name);
				}
			}
		}

                $this->load->view('file_manager/widget/alias', array(
			'alias_records'		=> $alias_records,
			'display_header'	=> $display_header,
			'target_module'		=> $target_module,
			'target_model'		=> $target_model,
			'target_model_row_id'	=> $target_model_row_id
                ));
        }
        
	public function download()
	{
		// is there more ways to add file validation rules except for the ones in the view
		// for instance something to reject certain files and so on?
		// also, add support for view files inline, could be available to settings

		$this->output->enable_profiler(false);

		$this->load->config('config');
		$upload_config = $this->config->item('upload_config');

		$this->load->model('file_manager_files_model');

		$file_id = $this->uri->segment(5);

		$record = $this->file_manager_files_model->select('sha1_checksum, file_name, extension')->find_by('id', $file_id);

		$file_path = null;
		if($record)
		{
			$path_parts = pathinfo($record->sha1_checksum);
			$file_name  = $path_parts['basename'];
			$file_path  = $upload_config['upload_path'].$file_name;
		}

		if(file_exists($file_path))
		{

			$content_types = $upload_config['allowed_types'];
			
			if($content_types == 'content_types') $content_types = $upload_config['content_types'];

			if(!is_array($content_types)) die('No content_types defined in the config file');

			$attachment_name = preg_replace('/[^a-z0-9]/i', '_', substr($record->file_name, 0, 20)) . '.' . $record->extension;


			$this->load->vars(array(
				'file_path'         => $file_path,
				'content_type'      => $content_types[$record->extension],
				'attachment_name'   => $attachment_name
			));

			$this->load->view('widget/download');
		}
		else
		{
			$this->load->view('widget/download_failed');
		}
	}
	
	// Get module name from uri (might be version compatibility issues), at failure an error array is thrown
	private function auto_get_module()
	{
		$module = $this->uri->segment(3);

		$return = false;
		$error = array();

		// Check if the name exists available modules, else throw error
		if(in_array($module, module_list()))
		{
			$return = $module;
		}
		else
		{
			$error[] = 'Can\'t auto-get module, please set target_module parameter in the alias widget call';
		}

		return ($return) ? $return : $error;
	}

	// Get the model name from application helper function module_files using auto_get_module as identifier and auto_get_model_row_id as false check, at failure an error array is thrown
	private function auto_get_model()
	{
		$module = $this->auto_get_module();
			
		$module_files = module_files($module);
		$module_models = $module_files[$module]['models'];

		$loaded_models = array();
		$return = false;
		$error = array();

		// Check if the any of the module models is loaded
		foreach($module_models as $model_name)
		{
			// Shave extension off model_name
			$model_name = substr($model_name, 0, -4);

			if(class_exists($model_name, false))
			{
				$loaded_models[] = $model_name;
			}
		}

		// Check to see that only one model is loaded, else throw error
		if(count($loaded_models) == 1)
		{
			$return = $loaded_models[0];
		}
		elseif(count($loaded_models) > 1)
		{
			$error[] = 'Can\'t auto-get model, there are more then one model loaded from the targeted module, please set the target_model parameter in the alias widget call';
		}
		else
		{
			$error[] = 'Can\'t auto-get model, there are no loaded models from the targeted module, please set the target_model parameter in the alias widget call';
		}

		return ($return) ? $return : $error;
	}

	// Get the model row id from _ci_cached_vars using auto_get_model as identifier, at first fail a search for a configured id field is made, at second fail an error array is thrown
	private function auto_get_model_row_id($id_field=false, $module=false)
	{
		$module = $this->auto_get_module();
		$model = $this->auto_get_model();
		
		$return = false;
		$error = array();

		if(key_exists($module, $this->load->_ci_cached_vars))
		{
			if($id_field == false)
			{
				$id_field = 'id';
			}

			// Check to see if an edit view is open and return the id variable, if exists and named id
			if(property_exists($this->load->_ci_cached_vars[$module], $id_field))
			{
				$return = $this->load->_ci_cached_vars[$module]->$id_field;

			}
			else
			{
				$upload_config = $this->config->item('alias_config');

				// Check if there is an alternative id field set in the config file, FYI: $model[1] is name field.
				if(key_exists($upload_config['target_model_field_config'][$model][0]))
				{
					if($id_field)
					{
						$target_model_row_id_field = $upload_config['target_model_field_config'][$model][0];

						// If there is an id field name set, start over
						auto_get_model_row_id($target_model_row_id_field);
					}
					else
					{
						// If tried to start over after finding config results and still can't get an id from _ci_cached_vars, throw an error
						$error[] = 'Can\'t auto-get model row id, the alias_config item target_model_row_field seems to be incorrect. Please correct the ID field';
					}
				}
				else
				{
					// If there is no config id field value set that matches the call, throw an error
					$error[] = 'Can\'t auto-get model row id, please set the target_model_row_field_config in the config file';
				}
			}
		}
		else
		{
			// If no error is thrown and return still is false, return false (the user must be in module view)
			$error = false;
		}

		return ($return) ? $return : $error;
	}
}
