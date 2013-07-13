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
			'upload_path'		=> 'files',
			'overwrite'		=> '1',
			'file_import_path'	=> 'file-import',
			'icons'			=> '1',
			'file_import'		=> '1',
		);
		
		if (isset($_POST['save']))
		{
			// implement after migration support added: $this->auth->restrict('file_manager.Settings.Edit');
			$this->save_settings();
			
		}
		// Set $ini_get to get max filesize
		$ini_get['upload_max_filesize'] = ini_get('upload_max_filesize');
		$ini_get['post_max_size'] = ini_get('post_max_size');
		if($ini_get['upload_max_filesize']<$ini_get['post_max_size'])
		{
			$max_filesize = $ini_get['upload_max_filesize'];
		}
		else 
		{
			$max_filesize = $ini_get['post_max_size'];
		}
		$max_filesize = str_replace("M", "", $max_filesize);
		
		$inline  = "$('[rel=tooltip]').tooltip();";
 
		Assets::add_js( $inline, 'inline' );
    
                Template::set('max_filesize', $max_filesize);
		Template::set('ini_get', $ini_get);
                Template::set('settings_record', $settingsData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_settings'));
		Template::render();
	}
	
	
	private function save_settings()
	{

		// Form validation
		$this->form_validation->set_rules('upload_path','Upload path','required|max_length[255]');
		$this->form_validation->set_rules('overwrite','Overwrite','');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}
		$data = array(
                  array('name' => 'upload_path', 'value' => $this->input->post('upload_path') ),
                  array('name' => 'overwrite', 'value' => $this->input->post('overwrite') )
                 );

		//destroy the saved update message in case they changed update preferences.
		if ($this->cache->get('update_message'))
		{
		  $this->cache->delete('update_message');
		}

		// Log the activity
		$this->load->model('activities/activity_model');
		$this->activity_model->log_activity($this->auth->user_id(), lang('file_manager_settings_saved').': ' . $this->input->ip_address(), 'file_manager');

		// save the settings to the DB
		$this->load->model('settings_model', null, true);
		$updated = $this->settings_model->update_batch($data, 'name');

		return $updated;
	}

	
}