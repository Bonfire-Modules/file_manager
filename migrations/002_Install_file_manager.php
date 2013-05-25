<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_file_manager extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		/*
		 * File Manager settings table
		 */
		
		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'property' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'module_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'value' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'extra' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
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
		$this->dbforge->create_table('file_manager');
		
		/*
		 * File Manager files table
		 */
		
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
			'sha1_checksum' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
			),
			'owner_userid' => array(
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
		
		
		/*
		 * File Manager alias table
		 */
		
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
			'target_module_id' => array(
				'type' => 'INT',
				'constraint' => 11,

			),
			'target_table_row_id' => array(
				'type' => 'INT',
				'constraint' => 11,

			),

		);
		
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', true);
		$this->dbforge->create_table('file_manager_alias');

	}

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('file_manager');
		$this->dbforge->drop_table('file_manager_files');
		$this->dbforge->drop_table('file_manager_alias');

	}

}