<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config['module_config'] = array(
	'description'	=> 'File manager with CI-based upload functionality for Bonfire',
	'name'		=> 'File manager',
	'version'	=> '0.0.1',
	'author'	=> 'aennaj@gmail.com'
);

/* CI Upload library
 * Preferences
 * 
 *	PREFERENCE	DEFAULT   OPTIONS			DESCRIPTION
 *			VALUE	
 *	upload_path	None	  None				The path to the folder where the upload should be placed. The folder must be writable and the path can be absolute or relative.
 *	allowed_types	None	  None				The mime types corresponding to the types of files you allow to be uploaded. Usually the file extension can be used as the mime type. Separate multiple types with a pipe.
 *	file_name	None	  Desired file name		If set CodeIgniter will rename the uploaded file to this name. The extension provided in the file name must also be an allowed file type.
 *	overwrite	FALSE	  TRUE/FALSE (boolean)		If set to true, if a file with the same name as the one you are uploading exists, it will be overwritten. If set to false, a number will be appended to the filename if another with the same name exists.
 *	max_size	0	  None				The maximum size (in kilobytes) that the file can be. Set to zero for no limit. Note: Most PHP installations have their own limit, as specified in the php.ini file. Usually 2 MB (or 2048 KB) by default.
 *	max_width	0	  None				The maximum width (in pixels) that the file can be. Set to zero for no limit.
 *	max_height	0	  None				The maximum height (in pixels) that the file can be. Set to zero for no limit.
 *	max_filename	0	  None				The maximum length that a file name can be. Set to zero for no limit.
 *	encrypt_name	FALSE	  TRUE/FALSE (boolean)		If set to TRUE the file name will be converted to a random encrypted string. This can be useful if you would like the file saved with a name that can not be discerned by the person uploading it.
 *	remove_spaces	TRUE	  TRUE/FALSE (boolean)		If set to TRUE, any spaces in the file name will be converted to underscores. This is recommended.
 */

$config['upload_config'] = array(
	'upload_path'		=> realpath(FCPATH) . '\bonfire\modules\upload\files\\',
	'allowed_types'		=> 'gif|jpg|jpeg|png|bmp|pdf|doc|docx|xls|xlsx',
	'file_name'		=> '',
	'overwrite'		=> false,
	'max_size'		=> 0,
	'max_width'		=> 0,
	'max_height'		=> 0,
	'max_filename'		=> 0,
	'encrypt_name'		=> false,
	'remove_spaces'		=> true
);