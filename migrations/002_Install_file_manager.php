<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_file_manager extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'file_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'description' => array(
				'type' => 'TEXT',
			),
			'tags' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'public' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
			),
			'extension' => array(
				'type' => 'VARCHAR',
				'constraint' => 20,
			),
			'sha1_checksum' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'owner_user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'created' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
			'modified' => array(
				'type' => 'datetime',
				'default' => '0000-00-00 00:00:00',
			),
		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('file_manager_files');
		
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE
			),
			'file_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
			'override_file_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'override_description' => array(
				'type' => 'TEXT'
			),
			'override_tags' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'override_public' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
			),
			'target_module' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'target_model' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'target_model_row_id' => array(
				'type' => 'INT',
				'constraint' => 11,
			),
		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('file_manager_alias');

		/* file_manager_settings, used for storing info about active tabs in efit and alias views */
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE
			),
			'setting' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'value' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'user_id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'default' => 0
			),
		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('file_manager_settings');
		
		// Insert module settings rows to settings table
		$this->db->query("INSERT INTO {$prefix}settings (`name`, `module`, `value`) VALUES 
			('upload_path', 'file_manager', 'files/'),
			('overwrite', 'file_manager', 'false');");
	}

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('file_manager_files');
		$this->dbforge->drop_table('file_manager_alias');
		$this->dbforge->drop_table('file_manager_settings');
		
		$this->db->query("DELETE FROM {$prefix}settings WHERE module='file_manager';");

	}

}