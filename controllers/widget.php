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

                $module_name = null; // error message
                if($module_config = $this->config->item('module_config')) if(isset($module_config['name'])) $module_name = $module_config['name'];

                // NOT WORKING! since template class is not used
                //if(is_null($module_name)) Template::set_message('"(An error occured while retrieving module configuration)"', 'error');

                $is_table_row = !is_null($table_row_id) ? true : false;
                $alias_records = null;

                // make this according to BF_model
                $sql = "SELECT f.`id`, f.`file_name`, f.`description`, f.`tags`, a.`target_table_row_id` FROM `ci_bf_git`.`".$this->db->dbprefix."file_manager_files` f, `ci_bf_git`.`".$this->db->dbprefix."file_manager_alias` a
                        WHERE f.`id` = a.`file_id` AND a.`target_module` = '".$caller_module."'";
                if($is_table_row) $sql .= " AND a.`target_table_row_id` = '".$table_row_id."'";
                $mysql_resource = mysql_query($sql);
                
                $unsorted_alias_records = array();
                while($data = mysql_fetch_array($mysql_resource, MYSQL_ASSOC)) $unsorted_alias_records[] = (object) $data;

                $alias_records = array();
                foreach($unsorted_alias_records as $record_key => $record_object)
                {
                        if(array_key_exists($record_object->id, $alias_records))
                        {
                                $alias_records[$record_object->id]->target_table_row_id .= ", " . $record_object->target_table_row_id;
                        }
                        else
                        {
                                $alias_records[$record_object->id] = $unsorted_alias_records[$record_key];
                                $alias_records[$record_object->id]->target_table_row_id = ($record_object->target_table_row_id == 0) ? '' : $record_object->target_table_row_id;
                        }
                }
                
                $this->load->view('file_manager/widget/alias', array(
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

                $record = $this->file_manager_files_model->select('sha1_checksum, extension')->find_by('id', $file_id);

                $file_path = null;
                if($record)
                {
                        $path_parts = pathinfo($record->sha1_checksum . '.' . $record->extension);
                        $file_name  = $path_parts['basename'];
                        $file_path  = '/www/ci_bf_git/bonfire/modules/file_manager/files/'.$file_name;
                }

                if(file_exists($file_path))
                {
                        $this->load->vars(array('file_path' => $file_path));
                        $this->load->view('widget/download');
                }
                else
                {
                        $this->load->view('widget/download_failed');
                }
        }
}