<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
                
                $this->output->set_header("test", "test");
		//$this->auth->restrict('Bonfire.Users.View');
		//$this->load->model('file_manager_files_model');
		//$this->load->model('file_manager_alias_model');
		//$this->lang->load('users');
		//Template::set_block('sub_nav', 'settings/_sub_nav');
	}

        public function alias($caller_module=null)
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

//                $alias_records = $this->file_manager_alias_model->where('target_module', $caller_module)->find_all();
                
                // make this according to BF_model
                $mysql_resource = mysql_query("
                    SELECT f.`id`, f.`file_name`, f.`description`, f.`tags`, a.`target_table_row_id` FROM `ci_bf_git`.`".$this->db->dbprefix."file_manager_files` f, `ci_bf_git`.`".$this->db->dbprefix."file_manager_alias` a
                    WHERE f.`id` = a.`file_id` AND a.`target_module` = '".$caller_module."'");

                $alias_records = null;
                while($data = mysql_fetch_array($mysql_resource, MYSQL_ASSOC)) $alias_records[] = (object) $data;

                
                $this->load->view('file_manager/widget/alias', array(
                        'test' => null,
                        'test2' => null,
                        'test3' => null,
			'alias_records' => $alias_records,
                        'module_name' => $module_name));
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