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
/*
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
		
 * 
 */
//		$file= "file";
//var_dump (read_config($file, TRUE));
//die();
		$settingsData = array(
			'id'			=> NULL,
			'files_path'		=> 'files',
			'file_import'		=> '1',
			'file_import_path'	=> 'file-import',
			'icons'			=> '1',
			'file_import'		=> '1',
		);
		
		if (isset($_POST['save']))
		{
			// implement after migration support added: $this->auth->restrict('file_manager.Settings.Edit');
			//$this->save_file_manager_settings($type='insert', $id=0);
			
		}
		
                Template::set('settings_record', $settingsData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_settings'));
		Template::render();
	}
	
	
	private function save_file_manager_settings($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		// Form validation
		$this->form_validation->set_rules('file_name','File name','required|max_length[255]');
		$this->form_validation->set_rules('description','Description','');
		$this->form_validation->set_rules('tags','Tags','max_length[255]');
		$this->form_validation->set_rules('public','Public','max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		
		// Inser to DB
		$data = array();
		$data['file_name']      = $this->input->post('file_name');
		$data['description']    = ($this->input->post('description')) ? $this->input->post('description') : '';
		$data['tags']           = ($this->input->post('tags')) ? $this->input->post('tags') : '';
		$data['public']         = $this->input->post('public');

		if ($type == 'update')
		{
			$return = $this->file_manager_files_model->update($id, $data);
		}

		return $return;
	}

	
}