<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// Toolbar titles
$lang['file_manager_toolbar_title_index']		= 'File manager';
$lang['file_manager_toolbar_title_alias']		= 'Manager aliases';
$lang['file_manager_toolbar_title_upload']		= 'Upload';
$lang['file_manager_toolbar_title_import']		= 'Import';

// Admin box titles
$lang['file_manager_admin_box_title_index']		= 'Browse your files';
$lang['file_manager_admin_box_title_alias']		= 'Browse your aliases';
$lang['file_manager_admin_box_title_upload']		= 'Upload a file';
$lang['file_manager_admin_box_title_import']		= 'Import files';

// Tabs titles
$lang['file_manager_tabs_title_edit_file']		= 'Edit file';
$lang['file_manager_tabs_title_view_aliases']		= 'View aliases';
$lang['file_manager_tabs_title_create_alias']		= 'Create alias';

$lang['file_manager_edit']				= 'Edit';
$lang['file_manager_true']				= 'True';
$lang['file_manager_false']				= 'False';
$lang['file_manager_create']                            = 'Create';
$lang['file_manager_import_file']			= 'Import file';
$lang['file_manager_show']				= 'Show';
$lang['file_manager_list_files']			= 'List files';
$lang['file_manager_list_alias']			= 'List aliases';
$lang['file_manager_new']				= 'New';
$lang['file_manager_folder']				= 'Folder';
$lang['file_manager_size']				= 'Size';
$lang['file_manager_date']				= 'Date';

$lang['file_manager_edit_text']                         = 'Edit this to suit your needs';
$lang['file_manager_no_records']			= 'There aren\'t any file_manager in the system.';
$lang['file_manager_create_new']			= 'Create a new File Manager.';
$lang['file_manager_create_success']			= 'File Manager successfully created.';
$lang['file_manager_alias_create_success']		= 'File alias successfully created.';
$lang['file_manager_create_failure']			= 'There was a problem creating the file_manager: ';
$lang['file_manager_alias_create_failure']		= 'There was a problem creating the file alias: ';
$lang['file_manager_create_new_button']			= 'Create New File Manager';
$lang['file_manager_invalid_id']			= 'Invalid File Manager ID.';

$lang['file_manager_alias_invalid_id']			= 'Invalid alias ID.';

$lang['file_manager_edit_uploading_success']		= 'The information was added to the uploaded file successfully.';
$lang['file_manager_edit_success']			= 'File Manager successfully saved.';
$lang['file_manager_alias_edit_success']		= 'Alias successfully saved.';
$lang['file_manager_alias_edit_failure']		= 'There was a problem saving the alias: ';
$lang['file_manager_edit_failure']			= 'There was a problem saving the file_manager: ';
$lang['file_manager_delete_success']			= 'record(s) successfully deleted.';
$lang['file_manager_alias_delete_success']		= 'Alias(es) successfully deleted.';
$lang['file_manager_alias_delete_failure']		= 'We could not delete the alias(es): ';
$lang['file_manager_delete_failure']			= 'We could not delete the record: ';
$lang['file_manager_delete_error']			= 'You have not selected any records to delete.';
$lang['file_manager_actions']                           = 'Actions';
$lang['file_manager_cancel']                            = 'Cancel';
$lang['file_manager_select_file']                       = 'Select a file';
$lang['file_manager_selected_file']			= 'Selected file';
$lang['file_manager_import']				= 'Import';
$lang['file_manager_please_fix_errors']			= 'Please fix the following errors:';
$lang['file_manager_drag_and_drop']			= 'Drag and drop';

$lang['file_manager_alias_please_fix_errors']		= 'Please fix the following errors:';

$lang['file_manager_property']				= 'Property';
$lang['file_manager_value']				= 'Value';
$lang['file_manager_file_information']			= 'File information';
$lang['file_manager_add_information_to_file']		= 'Add information to file';
$lang['file_manager_save_information']			= 'Save information';
$lang['file_manager_save']				= 'Save';
$lang['file_manager_close']				= 'Close';
$lang['file_manager_or']				= 'or';
$lang['file_manager_show_large_image']			= 'Show large image';
$lang['file_manager_show_image_in_original_size']	= 'Show image in original size (New window)';
$lang['file_manager_aliases_title']			= 'Alias';
$lang['file_manager_alias']				= 'Current alias(es)';

$lang['file_manager_create_alias']			= 'Create alias';
$lang['file_manager_alias_override_file_name']		= 'Override file name';
$lang['file_manager_alias_override_description']	= 'Override description';
$lang['file_manager_alias_override_tags']		= 'Override tags';
$lang['file_manager_alias_override_public']		= 'Override public';
$lang['file_manager_alias_alias_no_records']		= 'No alias found that match your selection.';
$lang['file_manager_edit_header']			= 'Edit file';
$lang['file_manager_alias_edit_header']			= 'Edit alias';
$lang['file_manager_none_selected']			= 'None selected';
$lang['file_manager_file_already_exists']		= 'File already exists';
$lang['file_manager_file_already_exists_action']	= 'Make actions for what to do when file already exists...';
$lang['file_manager_import_delete_after_upload']	= 'Delete from import after upload';
$lang['file_manager_settings_title']			= 'File Manager Settings';
$lang['file_manager_settings_thumbnails']		= 'Display file thumbnails<br>(in List files tab)';
$lang['file_manager_settings_icons']			= 'Display file-extention icons<br>(in List files tab)';
$lang['file_manager_settings_files_path']		= 'Name of files folder<br>(relative path to module)';
$lang['file_manager_settings_file_import']		= 'Show file import tab';
$lang['file_manager_settings_file_import_path']		= 'Name of file import folder<br>(relative path to module)';


// Table field names (files_model)
$lang['file_manager_table_field_file_name']		= 'File name';
$lang['file_manager_table_field_thumbnail']		= 'Thumbnail';
$lang['file_manager_table_field_description']		= 'Description';
$lang['file_manager_table_field_tags']			= 'Tags';
$lang['file_manager_table_field_public']		= 'Public';
$lang['file_manager_table_field_extension']		= 'Extension';
$lang['file_manager_table_field_sha1_checksum']		= 'Download';

// Table field names (alias_model)
$lang['file_manager_table_field_alias_target_module']		= 'Target module';
$lang['file_manager_table_field_alias_target_model']		= 'Target model';
$lang['file_manager_table_field_alias_target_model_id']	= 'Target model id';
$lang['file_manager_table_field_alias_override_file_name']	= 'Override file name';







$lang['file_manager_file_delete_record']		= 'Delete this file';
$lang['file_manager_file_delete_confirm']		= 'Are you sure you want to delete this file?';

$lang['file_manager_alias_delete_confirm']		= 'Are you sure you want to delete this alias(es)?';

$lang['file_manager_delete_record']			= 'Delete this File Manager';
$lang['file_manager_delete_confirm']			= 'Are you sure you want to delete this file_manager?';
$lang['file_manager_import_empty_folder']		= 'Empty import folder';
$lang['file_manager_edit_heading']			= 'Edit File Manager';
$lang['file_manager_alias_edit_heading']		= 'Edit Alias';

$lang['file_manager_yes']                               = 'Yes';
$lang['file_manager_no']                                = 'No';
$lang['file_manager_add_upload_information']            = 'Add upload information';

$lang['file_manager_display_values_file_type']          = 'Type';
$lang['file_manager_display_values_client_name']        = 'Original name';

$lang['file_manager']                                   = 'File Manager';
$lang['file_manager_file_browser']			= 'File browser';
$lang['file_manager_import_files']                      = 'Import files';
$lang['file_manager_manage']                            = 'Manage File Manager';
$lang['file_manager_edit']				= 'Edit';
$lang['file_manager_true']				= 'True';
$lang['file_manager_false']				= 'False';
$lang['file_manager_create']                            = 'Create';
$lang['file_manager_import_file']			= 'Import file';
$lang['file_manager_download']				= 'Download';
$lang['file_manager_upload']				= 'Upload';
$lang['file_manager_show']				= 'Show';
$lang['file_manager_list_files']			= 'List files';
$lang['file_manager_list_alias']			= 'List aliases';
$lang['file_manager_new']				= 'New';
$lang['file_manager_upload_file']			= 'Upload file';
$lang['file_manager_upload_files']			= 'Upload files';
$lang['file_manager_folder']				= 'Folder';
$lang['file_manager_size']				= 'Size';
$lang['file_manager_date']				= 'Date';

$lang['file_manager_edit_text']                         = 'Edit this to suit your needs';
$lang['file_manager_no_records']			= 'There aren\'t any file_manager in the system.';
$lang['file_manager_create_new']			= 'Create a new File Manager.';
$lang['file_manager_create_success']			= 'File Manager successfully created.';
$lang['file_manager_alias_create_success']		= 'File alias successfully created.';
$lang['file_manager_create_failure']			= 'There was a problem creating the file_manager: ';
$lang['file_manager_alias_create_failure']		= 'There was a problem creating the file alias: ';
$lang['file_manager_create_new_button']			= 'Create New File Manager';
$lang['file_manager_invalid_id']			= 'Invalid File Manager ID.';

$lang['file_manager_alias_invalid_id']			= 'Invalid alias ID.';

$lang['file_manager_edit_uploading_success']		= 'The information was added to the uploaded file successfully.';
$lang['file_manager_edit_success']			= 'File Manager successfully saved.';
$lang['file_manager_alias_edit_success']		= 'Alias successfully saved.';
$lang['file_manager_alias_edit_failure']		= 'There was a problem saving the alias: ';
$lang['file_manager_edit_failure']			= 'There was a problem saving the file_manager: ';
$lang['file_manager_delete_success']			= 'record(s) successfully deleted.';
$lang['file_manager_alias_delete_success']		= 'Alias(es) successfully deleted.';
$lang['file_manager_alias_delete_failure']		= 'We could not delete the alias(es): ';
$lang['file_manager_delete_failure']			= 'We could not delete the record: ';
$lang['file_manager_delete_error']			= 'You have not selected any records to delete.';
$lang['file_manager_actions']                           = 'Actions';
$lang['file_manager_cancel']                            = 'Cancel';
$lang['file_manager_select_file']                       = 'Select a file';
$lang['file_manager_selected_file']			= 'Selected file';
$lang['file_manager_import']				= 'Import';
$lang['file_manager_please_fix_errors']			= 'Please fix the following errors:';
$lang['file_manager_drag_and_drop']			= 'Drag and drop';

$lang['file_manager_alias_please_fix_errors']		= 'Please fix the following errors:';

$lang['file_manager_property']				= 'Property';
$lang['file_manager_value']				= 'Value';
$lang['file_manager_file_information']			= 'File information';
$lang['file_manager_add_information_to_file']		= 'Add information to file';
$lang['file_manager_save_information']			= 'Save information';
$lang['file_manager_save']				= 'Save';
$lang['file_manager_close']				= 'Close';
$lang['file_manager_or']				= 'or';
$lang['file_manager_show_large_image']			= 'Show large image';
$lang['file_manager_show_image_in_original_size']	= 'Show image in original size (New window)';
$lang['file_manager_showing_large_thumbnail']		= 'Showing large thumbnail';
$lang['file_manager_aliases_title']			= 'Alias';
$lang['file_manager_alias']				= 'Current alias(es)';

$lang['file_manager_create_alias']			= 'Create alias';
$lang['file_manager_file_name']				= 'File name';
$lang['file_manager_alias_override_file_name']		= 'Override file name';
$lang['file_manager_description']			= 'Description';
$lang['file_manager_alias_override_description']	= 'Override description';
$lang['file_manager_tags']				= 'Tags';
$lang['file_manager_alias_override_tags']		= 'Override tags';
$lang['file_manager_public']				= 'Public';
$lang['file_manager_alias_override_public']		= 'Override public';
$lang['file_manager_alias_target_module']		= 'Target module';
$lang['file_manager_alias_target_model']		= 'Target model';
$lang['file_manager_alias_target_model_row_id']		= 'Target model row id';
$lang['file_manager_alias_alias_no_records']		= 'No alias found that match your selection.';
$lang['file_manager_edit_header']			= 'Edit file';
$lang['file_manager_alias_edit_header']			= 'Edit alias';
$lang['file_manager_none_selected']			= 'None selected';
$lang['file_manager_file_already_exists']		= 'File already exists';
$lang['file_manager_file_already_exists_action']	= 'Make actions for what to do when file already exists...';
$lang['file_manager_import_delete_after_upload']	= 'Delete from import after upload';
$lang['file_manager_settings_title']			= 'File Manager Settings';
$lang['file_manager_settings_thumbnails']		= 'Display file thumbnails<br>(in List files tab)';
$lang['file_manager_settings_icons']			= 'Display file-extention icons<br>(in List files tab)';
$lang['file_manager_settings_files_path']		= 'Name of files folder<br>(relative path to module)';
$lang['file_manager_settings_file_import']		= 'Show file import tab';
$lang['file_manager_settings_file_import_path']		= 'Name of file import folder<br>(relative path to module)';

// Radera uppladdade filer från 'file-import'-katalog, efter att de lagts till
$lang['file_manager_import_selected_files']		= 'Import selected files';
// Importera markerade filer

$lang['file_manager_file_delete_record']		= 'Delete this file';
$lang['file_manager_file_delete_confirm']		= 'Are you sure you want to delete this file?';

$lang['file_manager_alias_delete_confirm']		= 'Are you sure you want to delete this alias(es)?';

$lang['file_manager_delete_record']			= 'Delete this File Manager';
$lang['file_manager_delete_confirm']			= 'Are you sure you want to delete this file_manager?';
$lang['file_manager_import_empty_folder']		= 'Empty import folder';
$lang['file_manager_edit_heading']			= 'Edit File Manager';
$lang['file_manager_alias_edit_heading']		= 'Edit Alias';

$lang['file_manager_yes']                               = 'Yes';
$lang['file_manager_no']                                = 'No';

$lang['file_manager_toolbar_delimiter']                 = ' - ';
$lang['file_manager_toolbar_title_index']               = 'File browser' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_create']              = 'Upload files' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_edit']                = 'Edit file' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_upload']              = 'Processing upload' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_failed']              = 'Upload failed' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_upload_success']      = 'Upload success' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_file_exists']         = 'File exists' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_add_info']            = 'Add information to file' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_settings']            = 'Settings' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_import']		= 'Import files' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_toolbar_title_manage_aliases']	= 'Manage Aliases' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_manage_aliases']	= 'Manage Aliases' . $lang['file_manager_toolbar_delimiter'] . $lang['file_manager'];
$lang['file_manager_add_upload_information']            = 'Add upload information';

$lang['file_manager_display_values_file_type']          = 'Type';
$lang['file_manager_display_values_client_name']        = 'Original name';
$lang['file_manager_display_values_file_ext']           = 'Extension';

$lang['file_manager_display_values_file_size']          = 'Size';
$lang['file_manager_display_values_image_width']        = 'Image width';
$lang['file_manager_display_values_image_height']       = 'Image height';
$lang['file_manager_display_values_database_row_id']    = 'Database id';
$lang['file_manager_display_values_file_exists']        = 'File exists?';

$lang['file_manager_message_upload_successful']         = 'File uploaded successfully';
$lang['file_manager_message_file_exists']               = 'File selected for upload already exists';


// Activities
$lang['file_manager_act_create_record']			= 'Created record with ID';
$lang['file_manager_act_edit_record']			= 'Updated record with ID';
$lang['file_manager_act_delete_record']			= 'Deleted record with ID';
