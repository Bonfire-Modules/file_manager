<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
                
	}

        public function alias($caller_module=null, $table_row_id=null)
        {
		// think about how to adjust automatically to if it should get files for the whole module or for a single row in the table
		// what about multiple tables per module?

                $this->load->config('config');
                $module_config = $this->config->item('upload_config');
                
                $this->load->model('file_manager_alias_model');

		// return false if caller_module is not set, or display error message

                if(($caller_module)) $this->load->config($caller_module . '/config');

                $module_name = null; // error message, template::set_messsage might not work
                if($module_config = $this->config->item('module_config')) if(isset($module_config['name'])) $module_name = $module_config['name'];

                $is_table_row = !is_null($table_row_id) ? true : false;
		
		$this->file_manager_alias_model->select('file_manager_files.id, file_manager_alias.override_file_name, file_manager_files.file_name, file_manager_files.description, file_manager_files.tags, file_manager_alias.target_table, file_manager_alias.target_table_row_id');
		$this->db->join('file_manager_files', 'file_manager_files.id = file_manager_alias.file_id', 'inner');
		if($is_table_row) $this->file_manager_alias_model->where('file_manager_alias.target_table_row_id', $table_row_id);

		$alias_records = $this->file_manager_alias_model->find_all();
		
		//$alias_records = $this->bundle_up_table_rows($alias_records);
		
                $this->load->view('file_manager/widget/alias', array(
			//'alias_records' => $alias_records,
			'alias_records' => $alias_records,
                        'is_table_row'  => $is_table_row,
                        'table_row_id'  => $table_row_id,
                        'module_name'   => $module_name
                ));
        }
        
        public function download()
        {
                // is there more ways to add file validation rules except for the ones in the view
                // for instance something to reject certain files and so on?
                // also, add support for view files inline, could be available to settings
                
                $this->output->enable_profiler(false);

                $this->load->model('file_manager_files_model');

                $file_id = $this->uri->segment(5);

                $record = $this->file_manager_files_model->select('sha1_checksum, file_name, extension')->find_by('id', $file_id);

                $file_path = null;
                if($record)
                {
                        $path_parts = pathinfo($record->sha1_checksum);
                        $file_name  = $path_parts['basename'];
                        $file_path  = '/www/ci_bf_git/bonfire/modules/file_manager/files/'.$file_name;
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