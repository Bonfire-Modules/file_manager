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
                // !if module return, display error message
                
                if(($caller_module)) $this->load->config($caller_module . '/config');

                $module_name = null; // error message
                if($module_config = $this->config->item('module_config')) if(isset($module_config['name'])) $module_name = $module_config['name']; 
                
                // NOT WORKING! since template class is not used
                //if(is_null($module_name)) Template::set_message('"(An error occured while retrieving module configuration)"', 'error');
                
                $this->load->view('file_manager/widget/alias', array(
                        'test' => $module_id,
                        'test2' => $this->file_manager_alias_model->where('target_module_id', $module_id)->find_all(),
                        'test3' => null,
                        'module_name' => $module_name));
        }
        
        private function get_module_unique_id($caller_module=null)
        {
                $this->load->model('settings/settings_model');
                if($caller_module)
                {
                        $module_id_setting = $this->settings_model->select('name')->where(array('value' => 'file_manager_alias_eligible_module_unique_id', 'module' => $caller_module))->find_all();
                        return ($module_id_setting) ? $module_id_setting[0]->name : null;
                }
                else
                {
                        return $this->settings_model->select('name, module')->where('value', 'file_manager_alias_eligible_module_unique_id')->find_all();
                }
        }


}