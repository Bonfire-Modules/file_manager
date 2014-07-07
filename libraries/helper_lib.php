<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// file_manager specific miscellaneous helper functions
class helper_lib
{
	private $ci;
	private $alias_config;
	
	public function __construct()
	{
		// Assign a private reference to the ci object ($this only works in models, controllers and views)
		$this->ci =& get_instance();
		
		$this->ci->load->config('config');
		$this->alias_config = $this->ci->config->item('alias_config');
		$this->upload_config = $this->ci->config->item('upload_config');
	}

	// Returns the db table column names of the targeted row id from the upload config item
	public function get_target_model_row_table_fields($module=null, $model=null)
	{
		$error = false;
		$table_fields = array('id', 'name');
		
		$this->ci->load->model($module . '/' . $model);
		
		if($this->ci->db->field_exists('id', $this->ci->$model->get_table()))
		{
			if($this->ci->db->field_exists('name', $this->ci->$model->get_table()))
			{
				$table_fields = array($table_fields[0], $table_fields[1]);
			}
			else
			{
				if($this->alias_config !== false)
				{
					if(array_key_exists($model, $alias_config['target_model_field_config']))
					{
						$table_fields = $alias_config['target_model_field_config'][$model];
					}
					else
					{
						$table_fields = array($table_fields[0], $table_fields[0]);
					}
				}
			}
		}
		else
		{
			if($this->alias_config !== false)
			{
				if(array_key_exists($model, $this->alias_config['target_model_field_config']))
				{
					$table_fields = $this->alias_config['target_model_field_config'][$model];
				}
				else
				{
					$error = "Can't find table unique ID field, set custom fields in config file";
				}
			}
			else
			{
				$error = "Can't find table unique ID field, set custom fields in config file";
			}
		}
		
		$return_data = array('table_fields' => $table_fields, 'error' => $error);
		return $return_data;
	}
	
	public function get_available_module_models()
	{
		$private_alias_config = $this->alias_config;
		
		array_push($private_alias_config['exclude_target_modules'], 'file_manager');
		
		$unfiltered_custom_module_models = module_files(null, 'models', true);
		
		foreach($private_alias_config['include_core_modules'] as $core_module_name => $core_module_data)
		{
			$unfiltered_custom_module_models[$core_module_name] = $core_module_data;
		}
		
		foreach($unfiltered_custom_module_models as $module_name => $unfiltered_custom_module_models_data)
		{
			if(in_array($module_name, $private_alias_config ['exclude_target_modules'])) continue;

			$custom_module_models[$module_name] = $unfiltered_custom_module_models_data;

			foreach($custom_module_models[$module_name]['models'] as $model_key => $model_value)
			{
				$custom_module_models[$module_name]['models'][$model_key] = substr($model_value, 0, -4);
			}
		}

		$available_module_models = $custom_module_models;
		ksort($available_module_models);
		
		return $available_module_models;
	}
	
	// Get allowed image file by extension name
	public function get_allowed_image_extensions()
	{
		$content_types = $this->upload_config['content_types'];

		$allowed_image_extensions = array();
		foreach($content_types as $extension => $content_type)
		{
			if(substr($content_type, 0, 5) == 'image')
			{
				$allowed_image_extensions[] = $extension;
			}
		}
		
		return $allowed_image_extensions;
	}

}