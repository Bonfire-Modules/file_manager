<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
                
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
		foreach($default_params as $default_param_key => $default_param_value) $params[$default_param_key] = (isset($params[$default_param_key])) ? $params[$default_param_key] : $default_param_value;
		
                $this->load->config('config');
                $module_config = $this->config->item('upload_config');
                
                $this->load->model('file_manager_alias_model');

		// return false if params['target_module'] is not set, or display error message

		// overkill?
		//if(($params['target_module'])) $this->load->config($params['target_module'] . '/config');
		//$module_name = null; // error message, template::set_messsage might not work
		//if($module_config = $this->config->item('module_config')) if(isset($module_config['name'])) $module_name = $module_config['name'];

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

		foreach($alias_records as $rowObj)
		{
			if(!empty($rowObj->override_file_name)) $rowObj->file_name = $rowObj->override_file_name;
			if(!empty($rowObj->override_description)) $rowObj->description = $rowObj->override_description;
			if(!empty($rowObj->override_tags)) $rowObj->tags = $rowObj->override_tags;
			if(!empty($rowObj->override_public)) $rowObj->public = $rowObj->override_public;
			
			unset($rowObj->override_file_name, $rowObj->override_description, $rowObj->override_tags, $rowObj->override_public);
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
        
	public function download()
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

			$content_types = $module_config['allowed_types'];
			
			if($content_types == 'content_types') $content_types = $module_config['content_types'];

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

	private function bundle_up_table_rows ($unsorted_records=null)
	{

		$sorted_records = array();
		foreach($unsorted_records as $record_key => $record_object)
		{
			if(array_key_exists($record_object->id, $sorted_records))
			{
				if(array_key_exists($record_object->target_table, $sorted_records[$record_object->id]))
				{
//                                $sorted_records[$record_object->id]->target_table_row_id .= ", " . $record_object->target_table_row_id;
					$sorted_records[$record_object->id]->target_table_row_id .= ", " . $record_object->target_table_row_id;
				}
				else
				{
					//$sorted_records[$record_object->id]->target_table_row_id = ($record_object->target_table_row_id == 0) ? '' : $record_object->target_table_row_id;
					$sorted_records[$record_object->id]->target_table_row_id .= ", " . $record_object->target_table_row_id;
				}

			}
			else
			{
				//$sorted_records[$record_object->id] = $unsorted_records[$record_key];
				//$sorted_records[$record_object->id]->target_table_row_id = ($record_object->target_table_row_id == 0) ? '' : $record_object->target_table_row_id;

				$sorted_records[$record_object->id] = $unsorted_records[$record_key];
			}

//			$sorted_records[] = $record_object;
		}

		return $unsorted_records;
	}
}