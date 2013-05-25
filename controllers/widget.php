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
                
                $mysql_resource = mysql_query("
                    SELECT f.`id`, f.`file_name`, f.`description`, f.`tags`, a.`target_table_row_id` FROM `ci_bf_git`.`".$this->db->dbprefix."file_manager_files` f, `ci_bf_git`.`".$this->db->dbprefix."file_manager_alias` a
                    WHERE f.`id` = a.`file_id` AND a.`target_module` = '".$caller_module."'");

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
            /*
header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="/license.txt"'); //<<< Note the " " surrounding the file name
header('Content-Transfer-Encoding: binary');
header('Connection: Keep-Alive');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header('Content-Length: ' . filesize($file));            
*/
//              echo "<pre>";
//              var_dump($this->output->headers);            
            //    $this->load->helper('download_helper');
              //  force_download('name', 'license.txt');
                Template::render();
        }
}