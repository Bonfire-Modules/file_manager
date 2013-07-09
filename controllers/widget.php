<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
                
                $this->load->config('config');
	}

        public function alias($params=null)
        {
		// set all default parameters
		$default_params = array(
			//'display_above_targets' => false, (later improvement)
			'display_header' => true,
			'target_module' => null,
			'target_model' => null,
			'target_model_row_id' => null
		);

		// set params with values from either default params or input params if is set
		foreach($default_params as $default_param_key => $default_param_value)
		{
			$params[$default_param_key] = (isset($params[$default_param_key])) ? $params[$default_param_key] : $default_param_value;
		}
		
                //$upload_config = $this->config->item('upload_config');
                
                $this->load->model('file_manager_alias_model');

		// return false if params['target_module'] is not set, or display error message

		// overkill?
		//if(($params['target_module'])) $this->load->config($params['target_module'] . '/config');
		//$module_name = null; // error message, template::set_messsage might not work
		//if($upload_config = $this->config->item('module_config')) if(isset($upload_config['name'])) $module_name = $upload_config['name'];

		$this->file_manager_alias_model->
			select('
				file_manager_files.id, 
				file_manager_files.file_name,
				file_manager_alias.override_file_name,
				file_manager_files.description,
				file_manager_alias.override_description,
				file_manager_files.tags,
				file_manager_alias.override_tags,
				file_manager_files.public,
				file_manager_alias.override_public,
				file_manager_alias.target_model,
				file_manager_alias.target_model_row_id');
		
		$this->db->join('file_manager_files', 'file_manager_files.id = file_manager_alias.file_id', 'inner');

		$this->file_manager_alias_model->where('file_manager_alias.target_module', $params['target_module']);
		
		if(is_null($params['target_model']))
		{
			$this->file_manager_alias_model->where('file_manager_alias.target_model', '');
		}
		else {
			$this->file_manager_alias_model->where('file_manager_alias.target_model', $params['target_model']);
			
			if(is_null($params['target_model_row_id']))
			{
				$this->file_manager_alias_model->where('file_manager_alias.target_model_row_id', 0);
			}
			else
			{
				//$this->file_manager_alias_model->where('file_manager_alias.target_model_row_id', $params['target_model_row_id']);
				$this->db->where("file_manager_alias.target_model_row_id = 0 OR `" . $this->db->dbprefix . "file_manager_alias`.`target_model_row_id` = " . $params['target_model_row_id']);
			}
		}
		
		$alias_records = $this->file_manager_alias_model->find_all();

		if($alias_records)
		{
			foreach($alias_records as $rowObj)
			{
				if(!empty($rowObj->override_file_name)) $rowObj->file_name = $rowObj->override_file_name;
				if(!empty($rowObj->override_description)) $rowObj->description = $rowObj->override_description;
				if(!empty($rowObj->override_tags)) $rowObj->tags = $rowObj->override_tags;
				if(!empty($rowObj->override_public)) $rowObj->public = $rowObj->override_public;

				unset($rowObj->override_file_name, $rowObj->override_description, $rowObj->override_tags, $rowObj->override_public);
			}
		}
		
		// perform user-friendly adjustment: $alias_records = $this->bundle_up_table_rows($alias_records);
		
                $this->load->view('file_manager/widget/alias', array(
			'alias_records'		=> $alias_records,
			'display_header'	=> $params['display_header'],
			'target_module'		=> $params['target_module'],
			'target_model'		=> $params['target_model'],
			'target_model_row_id'	=> $params['target_model_row_id']
                ));
        }
        
	// Tries to run alias() with automatically fetched parameters
	public function alias_autorun($autorun=null)
	{
		$error = array();

		if(is_null($autorun))
		{
			$error[] = 'Missing views parameter';
		}
		
		$module = $this->auto_get_module();
		$model = $this->auto_get_model();
		$model_row_id = $this->auto_get_model_row_id();
		
		echo "<pre>";
			echo 'auto_get_module:	';
			var_dump($module);
			echo 'auto_get_model:		';
			var_dump($model);
			echo 'auto_get_model_row_id:	';
			var_dump($model_row_id);
			
		echo "</pre>";
//		die;
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
			// Shave extension of model_name
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