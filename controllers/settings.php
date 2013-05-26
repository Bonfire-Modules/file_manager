<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();

		//$this->auth->restrict('Bonfire.Users.View');
		$this->load->model('file_manager_files_model');
		$this->load->model('file_manager_alias_model');
		$this->lang->load('file_manager');
		Template::set_block('sub_nav', 'content/_sub_nav');
                
       
        }

	public function index()
	{
                // TODO: add check for permission via bonfire
		//$this->auth->restrict('Bonfire.Users.Manage')

                Template::set('datatableOptions', array(
                    'headers' => 'ID, Name, Description, Tags, Public, sha1_checksum, Extension'));
                $datatableData = $this->file_manager_files_model->select('id, file_name, description, tags, public, sha1_checksum, extension')->find_all();
                
                // build in this to datatable git before first release of this
                // and improve it!
                foreach($datatableData as $temp_key => $temp_value)
                {
                        $datatableData[$temp_key]->sha1_checksum = '<a target="_blank" href="' . site_url(SITE_AREA .'/widget/file_manager/download/' . $temp_value->id) . '">' . $datatableData[$temp_key]->sha1_checksum . "</a>";
                        $datatableData[$temp_key]->file_name = '<a href="' . site_url(SITE_AREA .'/content/file_manager/edit/' . $temp_value->id) . '">' . $datatableData[$temp_key]->file_name . "</a>";
                }
                
                Template::set('datatableData', $datatableData);
                Template::set('toolbar_title', 'Settings - File Manager');
		Template::render();
	}
	

	
}