<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class File_manager_alias_model extends BF_Model {

	protected $table		= "file_manager_alias";
	protected $key			= "id";
	protected $soft_deletes	= false;
	protected $date_format	= "datetime";
	protected $set_created	= false;
	protected $set_modified = false;
        
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
