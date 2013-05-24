<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Install_upload extends Migration {

	public function up()
	{
		$prefix = $this->db->dbprefix;

		$fields = array(
			'id' => array(
				'type' => 'INT',
				'constraint' => 11,
				'auto_increment' => TRUE,
			),
			'upload_name' => array(
				'type' => 'VARCHAR',
				'constraint' => 200,
				
			),
			'upload_description' => array(
				'type' => 'TEXT',
				
			),
			'upload_tags' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'upload_public' => array(
				'type' => 'TINYINT',
				'constraint' => 1,
				
			),
			'upload_md5_checksum' => array(
				'type' => 'VARCHAR',
				'constraint' => 255,
				
			),
			'upload_owner_userid' => array(
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
		$this->dbforge->create_table('upload');

	}

	//--------------------------------------------------------------------

	public function down()
	{
		$prefix = $this->db->dbprefix;

		$this->dbforge->drop_table('upload');

	}

	//--------------------------------------------------------------------

}