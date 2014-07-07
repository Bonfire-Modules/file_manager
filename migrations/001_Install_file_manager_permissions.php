<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_file_manager_permissions extends Migration {

	private $permission_values = array(
		array('name' => 'file_manager.Content.View', 'description' => 'Allows user to access File manager', 'status' => 'active',),
		array('name' => 'file_manager.Content.Create', 'description' => 'Allows user to upload files and create aliases', 'status' => 'active',),
		array('name' => 'file_manager.Content.Edit', 'description' => 'Allows user to edit files and aliases', 'status' => 'active',),
		array('name' => 'file_manager.Content.Delete', 'description' => 'Allows user to delete files and aliases', 'status' => 'active',),
		array('name' => 'file_manager.Content.Import', 'description' => 'Allows user to import files', 'status' => 'active',),
		array('name' => 'file_manager.Widget.Download', 'description' => 'Allows user to download files', 'status' => 'active',),
		array('name' => 'file_manager.Settings.View', 'description' => 'Allows user to access File manager settings', 'status' => 'active',),
		array('name' => 'file_manager.Settings.Create', 'description' => 'Allows user to create settings', 'status' => 'active',),
		array('name' => 'file_manager.Settings.Edit', 'description' => 'Allows user to edit settings', 'status' => 'active',),
		array('name' => 'file_manager.Settings.Delete', 'description' => 'Allows user to delete settings', 'status' => 'active',),
	);

	public function up()
	{
		$prefix = $this->db->dbprefix;

		// permissions
		foreach ($this->permission_values as $permission_value)
		{
			$permissions_data = $permission_value;
			$this->db->insert("permissions", $permissions_data);
			$role_permissions_data = array('role_id' => '1', 'permission_id' => $this->db->insert_id(),);
			$this->db->insert("role_permissions", $role_permissions_data);
		}
	}

	public function down()
	{
		$prefix = $this->db->dbprefix;

		foreach ($this->permission_values as $permission_value)
		{
			$query = $this->db->select('permission_id')->get_where("permissions", array('name' => $permission_value['name'],));
			foreach ($query->result_array() as $row)
			{
				$permission_id = $row['permission_id'];
				$this->db->delete("role_permissions", array('permission_id' => $permission_id));
			}
			$this->db->delete("permissions", array('name' => $permission_value['name']));

		}
	}
}