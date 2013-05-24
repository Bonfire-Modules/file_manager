<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Widget extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

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

                $this->load->model('file_manager_alias_model');

		// return false if caller_module is not set, or display error message

                $module_id = $this->get_module_unique_id($caller_module);
                // if !module_id return, display error message

                if(($caller_module)) $this->load->config($caller_module . '/config');

                $module_name = null; // error message
                if($module_config = $this->config->item('module_config')) if(isset($module_config['name'])) $module_name = $module_config['name']; 

                // NOT WORKING! since template class is not used
                //if(is_null($module_name)) Template::set_message('"(An error occured while retrieving module configuration)"', 'error');

                $this->load->view('file_manager/widget/alias', array(
                        'test' => null,
                        'test2' => null,
                        'test3' => null,
			'alias_records' => $this->file_manager_alias_model->where('target_module_id', $module_id)->find_all(),
                        'module_name' => $module_name));
        }

        private function get_module_unique_id($caller_module=null)
        {
                $this->load->model('file_manager_model');
                if($caller_module)
                {
			// return caller modules unique module id from settings model
                        $module_id_setting = $this->file_manager_model->select('value')->where(array('property' => 'eligible_module_unique_id', 'module_name' => $caller_module))->find_all();
                        return ($module_id_setting) ? $module_id_setting[0]->value : null;
                }
                else
                {
			// If not caller is specified, return all available module id's from settings model
                        return $this->settings_model->select('name, module')->where('value', 'eligible_module_unique_id')->find_all();
                }
        }

}