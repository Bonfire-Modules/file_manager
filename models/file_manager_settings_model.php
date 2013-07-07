<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_manager_settings_model extends BF_Model {

	protected $table		= "file_manager_settings";
	protected $key			= "id";
	protected $soft_deletes		= false;
	protected $date_format		= "datetime";
	protected $set_created		= false;
	protected $set_modified		= false;
 
	
	public function get_active_tab($set_tab=false)
	{
		// Get the active tab per user from settings
		$active_tab = $this->find_by(array('setting' => 'active_tab', 'user_id' => $this->auth->user_id()));
		
		// Sets the default return value
		$return_tab = '#edit_file';

		// If an active_tab setting exists, it returns the value
		if($active_tab)
		{
			$return_tab = $active_tab->value;

			if($set_tab)
			{
				// get_active_tab is also used to update the current active tab
				$this->update($active_tab->id, array('value' => $set_tab));
			}
		}
		else
		{
			// Sets the active_tab settings to either set_tab if set, else return_tab as default
			$this->insert(array('setting' => 'active_tab', 'value' => (($set_tab) ? $set_tab : $return_tab), 'user_id' => $this->auth->user_id()));
		}
		
		return $return_tab;
	}
}