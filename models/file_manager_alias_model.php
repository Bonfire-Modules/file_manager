<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_manager_alias_model extends BF_Model {

	protected $table		= "file_manager_alias";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;
}
