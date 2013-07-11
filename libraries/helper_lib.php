<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

// file_manager specific miscellaneous helper functions
class helper_lib
{
	private $ci;
	
	public function __construct()
	{
		// Assign a private reference to the ci object ($this only works in models, controllers and views)
		$this->ci =& get_instance();
	}

	// Returns the db table column names of the targeted row id from the upload config item
	public function get_target_model_row_table_fields($module=null, $model=null)
	{
		$error = false;
		$table_fields = array('id', 'name');
		
		$this->ci->load->config('config');
		$alias_config = $this->ci->config->item('alias_config');

		$this->ci->load->model($module . '/' . $model);
		
		if($this->ci->db->field_exists('id', $this->ci->$model->get_table()))
		{
			if($this->ci->db->field_exists('name', $this->ci->$model->get_table()))
			{
				$table_fields = array($table_fields[0], $table_fields[1]);
			}
			else
			{
				if($alias_config !== false)
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
			if($alias_config !== false)
			{
				if(array_key_exists($model, $alias_config['target_model_field_config']))
				{
					$table_fields = $alias_config['target_model_field_config'][$model];
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
}