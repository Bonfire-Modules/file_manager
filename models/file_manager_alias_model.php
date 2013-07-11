<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_manager_alias_model extends BF_Model {
	protected $table		= "file_manager_alias";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;
	
	public function get_aliases()
	{
		$this->select('
			file_manager_alias.id,
			file_manager_files.file_name,
			file_manager_alias.override_file_name,
			file_manager_files.tags,
			file_manager_alias.override_tags,
			file_manager_files.public,
			file_manager_alias.override_public,
			file_manager_alias.target_module,
			file_manager_alias.target_model,
			file_manager_alias.target_model_row_id');

		$this->db->join('file_manager_files', 'file_manager_files.id = file_manager_alias.file_id', 'inner');

		$alias_records = $this->find_all();

		if($alias_records)
		{
			foreach($alias_records as $alias_key => $alias_record)
			{
				if(!empty($alias_record->override_file_name))
				{
					$alias_record->file_name = $alias_record->override_file_name;
					$alias_records[$alias_key]->override_file_name = 'Yes';
				}

				if(!empty($alias_record->override_tags))
				{
					$alias_record->tags = $alias_record->override_tags;
					$alias_records[$alias_key]->override_tags = 'Yes';
				}

				if($alias_record->override_public != '')
				{
					$alias_record->public = ($alias_record->override_public == 1 ? 'Yes' : 'No');
					$alias_records[$alias_key]->override_public = 'Yes';
				}
				else
				{
					$alias_record->public  = ($alias_record->public == 1 ? 'Yes' : 'No');
					$alias_records[$alias_key]->override_public = '';
				}

				if($alias_record->target_model_row_id == 0) $alias_records[$alias_key]->target_model_row_id = '';

				if($alias_record->target_module != '' && $alias_record->target_model != '')
				{
					$table_fields = $this->helper_lib->get_target_model_row_table_fields($alias_record->target_module, $alias_record->target_model);
					
					$target_model = $alias_record->target_model;
					$this->load->model($alias_record->target_module . '/' . $target_model);

					$alias_id_name = $this->$target_model->select($table_fields['table_fields'][1])->find_by($table_fields['table_fields'][0], $alias_record->target_model_row_id);

					$alias_records[$alias_key]->target_model_row_id = $alias_id_name->$table_fields['table_fields'][1];
				}

				$alias_records[$alias_key]->file_name = anchor(SITE_AREA . '/content/file_manager/alias_edit/' . $alias_record->id, $alias_record->file_name);
			}
		}

		return $alias_records;
	}

	
	
	
        /* Code for creation of slug string and convertion of chars to URI friendly, look in to useing bonfires bultin validation (for creating public links to files) */
        
        /*
        function create_slug ($str) {
            $slug = $this->toAscii($str);
            if(!$this->slug_exists($str)) {
		// return slug
            } else {
		// append incremental number to slug
                // while loop to check if exists
            }
        }
        
        function toAscii($str, $replace=array(), $delimiter='-') {
            $invalid = array('Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z',
                'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A',
                'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E',
                'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
                'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y',
                'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a',
                'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e',  'ë'=>'e', 'ì'=>'i', 'í'=>'i',
                'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
                'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y',  'ý'=>'y', 'þ'=>'b',
                'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r', "`" => "'", "´" => "'", "„" => ",", "`" => "'",
                "´" => "'", "“" => "\"", "”" => "\"", "´" => "'", "&acirc;€™" => "'", "{" => "",
                "~" => "", "–" => "-", "’" => "'");
            $str = str_replace(array_keys($invalid), array_values($invalid), $str);
            if( !empty($replace) ) {
                    $str = str_replace((array)$replace, ' ', $str);
            }
            $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
            $clean = strtolower(trim($clean, '-'));
            $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
            return $clean;
	}
	
	function slug_exists($slug) {
            // check if slug exists
            //$result = mysql_query("SELECT `id` FROM `files` WHERE `slug` = '".$slug."'");
            //if(mysql_num_rows($result)>0) {
            //        return 1;
            //}
            return 0;
	}
        */
}
