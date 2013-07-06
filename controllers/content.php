<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Content extends Admin_Controller
{
	public function __construct()
	{
		parent::__construct();
		//$this->auth->restrict('Bonfire.Users.View');
		$this->load->model('file_manager_files_model');
		$this->load->model('file_manager_alias_model');
		$this->lang->load('file_manager');
		$this->load->config('config');
		
		// ERROR
		$this->file_manager_files_model->set_table('file_manager_files');
		$this->file_manager_alias_model->set_table('file_manager_alias');
		
		Template::set_block('sub_nav', 'content/_sub_nav');
		
		$this->output->enable_profiler(false);
	}

	public function index()
	{
		$this->auth->restrict('file_manager.Content.View');

		
                Template::set('datatableOptions', array('headers' => 'Thumbnail, Name, Description, Tags, Public, Extension, Download'));
                $datatableData = $this->file_manager_files_model->select('id, id as thumbnail, file_name, description, tags, public, extension')->find_all();

		if(is_array($datatableData))
		{
			foreach($datatableData as $temp_key => $temp_value)
			{
				$datatableData[$temp_key]->sha1_checksum = '<a target="_blank" class="btn btn-mini" href="' . site_url(SITE_AREA .'/widget/file_manager/download/' . $temp_value->id) . '"><i class="icon-download-alt">&nbsp;</i> Download</a>';
				$datatableData[$temp_key]->file_name = '<a href="' . site_url(SITE_AREA .'/content/file_manager/edit/' . $temp_value->id) . '">' . $datatableData[$temp_key]->file_name . "</a>";

				// Only display thumbnail if record extension is of image type
				$allowed_image_extensions = $this->allowed_image_extensions();
				//die(var_dump($this->thumbnail_exist($datatableData[$temp_key]->id)));
				if(in_array($datatableData[$temp_key]->extension, $allowed_image_extensions) && $this->thumbnail_exist($datatableData[$temp_key]->id) !== false)
				{
					$datatableData[$temp_key]->thumbnail = '<img src="' . site_url(SITE_AREA .'/content/file_manager/view_image/thumbnail/' . $temp_value->id) . '" />';
				}
				else
				{
					$datatableData[$temp_key]->thumbnail = '';
				}
				
				$datatableData[$temp_key]->public = $datatableData[$temp_key]->public ? lang('file_manager_yes') : lang('file_manager_no');
				if($this->icon_exists($datatableData[$temp_key]->extension) !== false) {
					$datatableData[$temp_key]->extension = '<img src="' . site_url(SITE_AREA .'/content/file_manager/icon/' . $temp_value->extension) . '.png" />';
				}
			}
		}

		if (!extension_loaded('gd') || !function_exists('gd_info'))
		{
			$error_messages = (isset($error_messages)) ? $error_messages : $this->session->flashdata('error_messages');
			$error_messages[] = array('message_type' => 'info', 'message' => "PHP module <strong>GD</strong> is <strong>not installed</strong>, thumbnails will not be displayed as a result.<br /> To install GD on Ubuntu system run 'sudo apt-get install php5-gd' or see <a href=\"http://php.net/image\">http://php.net/image</a> for more info");
		}

		$error_messages = (isset($error_messages)) ? $error_messages : $this->session->flashdata('error_messages');
		Template::set('error_messages', $error_messages);
		Template::set('datatableData', $datatableData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_index'));
		Template::render();
	}

	public function list_aliases()
	{
		$this->auth->restrict('file_manager.Content.View');

//		$this->file_manager_alias_model->select('file_manager_alias.id, file_manager_files.file_name, file_manager_files.extension, file_manager_alias.override_file_name, file_manager_alias.override_description, file_manager_alias.target_module, file_manager_alias.target_model, file_manager_alias.target_model_row_id');
//		$this->db->join('file_manager_files', 'file_manager_alias.file_id = file_manager_files.id', 'inner');

		
		Template::Set('datatableOptions', array(
		    'headers' => 'File name, Override, Tags, Override, Public, Override, Target module, Target model, Target model row id'));

		// WARNING, duplicate code! do something about it, check in widget controller
		$this->file_manager_alias_model->
			select('
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

		$alias_records = $this->file_manager_alias_model->find_all();

		if($alias_records)
		{
			foreach($alias_records as $rowObj)
			{
				if(!empty($rowObj->override_file_name))
				{
					$rowObj->file_name = $rowObj->override_file_name;
					$rowObj->override_file_name = 'Yes';
				}
				
				if(!empty($rowObj->override_tags))
				{
					$rowObj->tags = $rowObj->override_tags;
					$rowObj->override_tags = 'Yes';
				}
				
				if($rowObj->override_public != '')
				{
					$rowObj->public = ($rowObj->override_public == 1 ? 'Yes' : 'No');
					$rowObj->override_public = 'Yes';
				}
				else
				{
					$rowObj->public  = ($rowObj->public == 1 ? 'Yes' : 'No');
					$rowObj->override_public = '';
				}
				
				$rowObj->file_name = anchor(SITE_AREA . '/content/file_manager/alias_edit/' . $rowObj->id, $rowObj->file_name);
//				unset($rowObj->alias_id);
			}
		}
		// end duplicate code warning

		Template::set('toolbar_title', lang('file_manager_manage_aliases'));
		Template::set('datatableData', $alias_records);
		Template::render();
	}

	public function import()
	{
		$this->auth->restrict('file_manager.Content.Create');

                Template::set('datatableOptions', array(
                    'headers' => ''.lang('file_manager_folder').', '.lang('file_manager_file_name').', '.lang('file_manager_size').', '.lang('file_manager_date').', '));

		$datatableData = array();
		$this->load->helper('file');

		$import_dir = get_dir_file_info(realpath(FCPATH).'/../application/modules/file_manager/file-import/', $top_level_only = FALSE);
		if(is_array($import_dir))
		{
			foreach ($import_dir as $row)
			{
				$datatableData[] = array($rowObj->column = str_replace('file-import','-',basename ( $row['relative_path'] )), $row['name'], round(($row['size']/1024)).' kB', date('Y-m-d H:i:s', $row['date']), '<a href="?" class="btn btn-mini"><i class="icon-ok">&nbsp;</i> '.lang('file_manager_import_file').'</a> <a href="?" class="btn btn-mini"><i class="icon-download-alt">&nbsp;</i> '.lang('file_manager_download').'</a> <a href="?" class="btn btn-mini"><i class="icon-search">&nbsp;</i> '.lang('file_manager_show').'</a>');
			}
		}

		Template::set('datatableData', $datatableData);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_import'));
		Template::render();
	}

	public function create()
	{
		$this->auth->restrict('file_manager.Content.Create');

		Template::set('toolbar_title', lang('file_manager_toolbar_title_create'));
		Template::render();
	}

	public function edit()
        {
		$id = $this->uri->segment(5);

		$active_tab = 'edit_file';

		if (empty($id))
		{
			Template::set_message(lang('file_manager_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/file_manager');
		}

		if (isset($_POST['save']))
		{
			$this->auth->restrict('file_manager.Content.Edit');

			if ($this->save_file_manager_files('update', $id))
			{
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');
				Template::set_message(lang('file_manager_edit_success'), 'success');
			} else
			{
				Template::set_message(lang('file_manager_edit_failure') . $this->file_manager_files_model->error, 'error');
			}
		}
		else if(isset($_POST['save_alias']))
		{
			$this->auth->restrict('file_manager.Content.Create');

			if ($this->save_file_manager_alias('insert', $id))
			{
				$active_tab = 'view_alias';
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');
				Template::set_message(lang('file_manager_alias_create_success'), 'success');
			} else
			{
				$active_tab = 'create_alias';
				Template::set_message(lang('file_manager_alias_create_failure') . $this->file_manager_alias_model->error, 'error');
			}
		}
		else if(isset($_POST['delete']))
		{
			$this->auth->restrict('file_manager.Content.Delete');

			
			$upload_config = $this->config->item('upload_config');
			$sha1_checksum = implode('', (array) $this->file_manager_files_model->select('sha1_checksum')->find($id));
			$delete_path = $upload_config['upload_path'] . $sha1_checksum;

			if ($this->file_manager_files_model->delete($id))
			{
				unlink($delete_path);
				// double code, exists in function callback_unlink_files
				unlink($delete_path . '_thumb');

				if($this->file_manager_alias_model->find_by('file_id', $id))
				{
					if($this->file_manager_alias_model->delete_where(array('file_id' => $id)))
					{
						Template::set_message(lang('file_manager_delete_success'), 'success');
						redirect(SITE_AREA .'/content/file_manager');
					} else
					{
						Template::set_message(lang('file_manager_delete_alias_failure') . $this->file_manager_alias_model->error, 'error');
					}
				} else
				{
					Template::set_message(lang('file_manager_delete_success'), 'success');
					redirect(SITE_AREA .'/content/file_manager');
				}
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');
			} else
			{
				Template::set_message(lang('file_manager_delete_failure') . $this->file_manager_files_model->error, 'error');
			}
		}
		else if(isset($_POST['delete_alias']))
		{
			$this->auth->restrict('file_manager.Content.Delete');

			$active_tab = 'view_alias';

			$checked = $this->input->post('checked');
			if (is_array($checked) && count($checked))
			{
				foreach ($checked as $alias_id)
				{
					if($this->file_manager_alias_model->delete_where(array('id' => $alias_id)))
					{
						$template_message = lang('file_manager_alias_delete_success');
						$template_message_type = 'success';
					} else
					{
						$template_message = lang('file_manager_alias_delete_failure') . $this->file_manager_alias_model->error;
						$template_message_type = 'error';
						break;
					}
				}

				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_delete_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');
				Template::set_message($template_message, $template_message_type);
			}
		}
		
		$flashdata_active_tab = $this->session->flashdata('flashdata_active_tab');
		if($flashdata_active_tab)
		{
			$active_tab = 'view_alias';
		}

		$this->file_manager_alias_model->
			select('file_manager_alias.id, file_manager_files.file_name, file_manager_files.extension, file_manager_alias.override_file_name, file_manager_alias.override_description, file_manager_alias.target_module, file_manager_alias.target_model, file_manager_alias.target_model_row_id')->
			where('file_id', $id);

		$this->db->join('file_manager_files', 'file_manager_alias.file_id = file_manager_files.id', 'inner');

		Assets::add_js($this->load->view('content/init_modal_events', null, true), 'inline');
		Assets::add_js($this->load->view('content/init_tabs', array('active_tab' => $active_tab), true), 'inline');
		Assets::add_js($this->load->view('content/init_chained_alias_select', null, true), 'inline');

		$available_module_models = $this->get_available_module_models();
		Template::set('module_models', $available_module_models);
		Template::set('alias_records', $this->file_manager_alias_model->find_all());
		Template::set('file_record', $this->file_manager_files_model->find($id));
		Template::set('id', $id);
                Template::set('toolbar_title', lang('file_manager_toolbar_title_edit'));

		Template::render();
        }

	public function alias_edit()
	{
		$file_id = $this->uri->segment(5);
		$id = $this->uri->segment(6);
		
		if (empty($file_id) && empty($id))
		{
			Template::set_message(lang('file_manager_alias_invalid_id'), 'error');
			redirect(SITE_AREA .'/content/file_manager/list_aliases');
		}
		
		if(!empty($file_id) && empty($id))
		{
			$id = $file_id;
			$file_id = false;
		}

		if($file_id)
		{
			$this->session->set_flashdata('flashdata_active_tab', 'view_alias');
		}
		
		if (isset($_POST['save_alias']))
		{
			$this->auth->restrict('file_manager.Content.Edit');

			if ($this->save_file_manager_alias('update', $id))
			{
				//$this->activity_model->log_activity($this->current_user->id, lang('file_manager_act_edit_record').': ' . $id . ' : ' . $this->input->ip_address(), 'file_manager');
				Template::set_message(lang('file_manager_alias_edit_success'), 'success');
			} else
			{
				Template::set_message(lang('file_manager_alias_edit_failure') . $this->file_manager_files_model->error, 'error');
			}
		}

		Assets::add_js($this->load->view('content/init_chained_alias_select', array('call_model_row_id_ajax' => true), true), 'inline');

		$available_module_models = $this->get_available_module_models();
		Template::set('module_models', $available_module_models);
		Template::set('toolbar_title', lang('file_manager_alias_edit_heading'));
		Template::set('alias_record', $this->file_manager_alias_model->find_by('id', $id));
		Template::set('file_id', $file_id);
		Template::set('id', $id);

		Template::render();
	}
	
	public function get_alias_target_model_row_id_data()
	{
		$error = false;
		$table_fields = array('id', 'name');
		$target_model_field_config = false;
		$output = '';
		
		$module = $_GET['module'];
		$model = $_GET['model'];
		
		$this->load->model($_GET['module'] . '/' . $_GET['model']);
		
		$alias_config = $this->config->item('alias_config');

		if($this->db->field_exists('id', $this->$model->get_table()))
		{
			if($this->db->field_exists('name', $this->$model->get_table()))
			{
				$table_fields = array($table_fields[0], $table_fields[1]);
			}
			else
			{
				if($alias_config !== false)
				{
					if(array_key_exists($model, $alias_config['target_model_field_config']))
					{
						$table_fields = $alias_config['target_model_field_config'][$model];
					}
					else
					{
						$table_fields = array($table_fields[0], $table_fields[0]);
					}
				}
			}
		}
		else
		{
			if($alias_config !== false)
			{
				if(array_key_exists($model, $alias_config['target_model_field_config']))
				{
					$table_fields = $alias_config['target_model_field_config'][$model];
				}
				else
				{
					$error = "Can't find table unique ID field, set custom fields in config file";
				}
			}
			else
			{
				$error = "Can't find table unique ID field, set custom fields in config file";
			}
		}
		
		if($error === false)
		{

		$model_row_id_data = $this->$model->select($table_fields[0] . ', ' . $table_fields[1])->find_all();

			$output = '{';
			foreach($model_row_id_data as $data)
			{
				$data = (array) $data;

				if($output != '{') $output .= ', ';
				$output .= '"' . $data[$table_fields[0]] . '": "' .$data[$table_fields[1]] . '"';
			}
			$output .= '}';

		}
		else
		{
			// handle output better! user can still submit value -1.
			$output = '{"-1": "ERROR:' .$error . '"}';
		}
		
		echo $output;
	}

	public function do_upload()
	{
		$files_array = array();

		// Notice: Can this function be restricted to calls from create controller
		$this->auth->restrict('file_manager.Content.Create');

		// Set files_array with name and path information from multiple file input element
		foreach($_FILES['userfile'] as $assoc_key => $array_value)
		{
			foreach($array_value as $num_key => $value)
			{
				$files_array[$num_key][$assoc_key] = $value;
			}
		}

		$this->config->load('config');

		// Get config item to use with CI upload library
		$upload_config = $this->config->item('upload_config');

		// Set allowed types in config item from content_types index, separated by pipes as requested CI upload library
		if(is_array($upload_config['content_types'])) $upload_config['allowed_types'] = implode('|', array_keys($upload_config['content_types']));

		// Convert config item to suitable config variable
		foreach($upload_config as $setting => $value)
		{
			$config[$setting] = $value;
		}

		$error_messages = null;
		$return_data_array = array();

		// Perform separate upload and db insert of each file from file input element
		for($i=0; $i<count($files_array); $i++)
		{
			// Set global variable to current upload
			$_FILES['userfile'] = $files_array[$i];

			// Collect return data from each upload
			$return_data_array[$i] = $this->perform_upload($config);

			if(isset($return_data_array[$i]['error']['file_exists'])) $error_messages[] = array('message_type' => '-info', 'message' => $return_data_array[$i]['error']['file_exists']);
			if(isset($return_data_array[$i]['error']['file_exists_both'])) $error_messages[] = array('message_type' => '', 'message' => $return_data_array[$i]['error']['file_exists_both']);
			if(isset($return_data_array[$i]['error']['upload'])) $error_messages[] = array('message_type' => '-error', 'message' => $return_data_array[$i]['error']['upload']);
		}
		
		// Check to see if there is only errors
		$message_types = array();
		$only_error = false;
		foreach($error_messages as $error_message) $message_types[] = $error_message['message_type'];
		if(in_array('-error', $message_types))
		{
			$only_error = true;
			foreach($message_types as $message_type_key => $message_type) if($message_type != '-error') $only_error = false;
		}

		if(!$only_error) Template::set_message('Upload complete', 'success');

		$this->session->set_flashdata('error_messages', $error_messages);
		
		redirect(SITE_AREA . '/content/file_manager');
	}
	public function thumbnail_exist($file_id)
	{
		$module_config = $this->config->item('upload_config');

		$this->load->model('file_manager_files_model');
		$record = $this->file_manager_files_model->select('sha1_checksum, file_name, extension')->find_by('id', $file_id);

		$file_path = null;
		if($record)
		{
			$path_parts = pathinfo($record->sha1_checksum);
			$file_name  = $path_parts['basename'];
			$file_path  = $module_config['upload_path'].$file_name;
			if(file_exists($file_path."_thumb"))
			{
				return $file_path;
			}
		}
		return false;
	}
	
	public function view_image($check_exist = 0)
	{
		// View images and thumbnails, create thumbnails on demand
		
		$file_id = $this->uri->segment(5);

		$thumbnail = $this->uri->segment(6);
		if(empty($thumbnail))
		{
			$thumbnail = false;
		}
		else
		{
			$file_id = $thumbnail;
			$thumbnail = true;
		}
		
		
		$module_config = $this->config->item('upload_config');

		$this->load->model('file_manager_files_model');
		$record = $this->file_manager_files_model->select('sha1_checksum, file_name, extension')->find_by('id', $file_id);

		$file_path = null;
		if($record)
		{
			// Try dis
			//$this->load->config('file_manager/config');
			//$upload_config = $this->config->item('upload_config');
			//$delete_path = $upload_config['upload_path'] . $deleted_data->sha1_checksum;

			$path_parts = pathinfo($record->sha1_checksum);
			$file_name  = $path_parts['basename'];
			$file_path  = $module_config['upload_path'].$file_name;
		}

		if(file_exists($file_path))
		{
			$content_types = $module_config['content_types'];

			// Restrict none image extensions
			$allowed_image_extensions = $this->allowed_image_extensions();
			if(!in_array($record->extension, $allowed_image_extensions)) $this->load->vars(array('error' => 'The file is not an image'));

			if($thumbnail)
			{
				if(!file_exists($file_path."_thumb"))
				{
					$generate_thumbnail = $this->generate_thumbnail($file_path, 'small', 'image');
					if(!$generate_thumbnail) $this->load->vars(array('error' => 'Thumbnail could not be generated'));
				}

				if(!file_exists($file_path."_thumb")) $this->load->vars(array('error' => 'Thumbnail is missing'));
				
				$file_path .= '_thumb';
			}
			
			$this->load->view('content/view_image', array('file_path' => $file_path, 'content_type' => $content_types[$record->extension]));
		}
	}

	public function icon()
	{
		$image = $this->uri->segment(5);
		$file_path  = $this->icon_exists($image, "");
		if(file_exists($file_path)) {
			$this->load->vars(array(
				'file_path'         => $file_path,
				'content_type'      => "image/png",
				'attachment_name'   => $image
			));
			$this->load->view('content/display_icon');
		}
	}

	public function callback_unlink_files($deleted_id, $deleted_data)
	{
		// Delete files and thumbnails when deleting files
		$this->load->config('file_manager/config');
		$upload_config = $this->config->item('upload_config');
		$delete_path = $upload_config['upload_path'] . $deleted_data->sha1_checksum;
		unlink($delete_path);
		unlink($delete_path . '_thumb');
	}

	private function allowed_image_extensions ()
	{
		
		$module_config = $this->config->item('upload_config');
		
		$content_types = $module_config['content_types'];

		$allowed_image_extensions = array();
		foreach($content_types as $extension => $content_type) if(substr($content_type, 0, 5) == 'image') $allowed_image_extensions[] = $extension;
		
		return $allowed_image_extensions;
	}
	
	private function generate_thumbnail ($path, $size = "small", $type = "image") {

		// Check that size is valid
		if( ! in_array ( $size, array ( "small", "medium", "large" ) ) ) { return false; }

		
                $module_config_thumb = $this->config->item('upload_config');

		// Get and set size in pixels from config
		$thumb_size_width	= "thumb_".$size."_width";
		$thumb_size_height	= "thumb_".$size."_height";
		$width			= $module_config_thumb[$thumb_size_width];
		$height			= $module_config_thumb[$thumb_size_height];

		if($type=="image")
		{
			return $this->generate_image_thumbnail($path, $width, $height);
		}
		else if($type=="pdf")
		{
			// Check if image magic is installed
			//if(!function_exists("NewMagickWand")) return "Error, image magick not installed or properly configured'";
			return $this->generate_pdf_thumbnail($path, $width, $height);
		}
	}

	private function generate_image_thumbnail($path, $width, $height)
	{
		$config['image_library']	= 'gd2';
		$config['source_image']		= $path;
		$config['create_thumb']		= TRUE;
		$config['maintain_ratio']	= TRUE;
		$config['width']		= $width;
		$config['height']		= $height;
		$this->load->library('image_lib', $config);
		$this->image_lib->resize();
		return $path.'_thumb';
	}

	private function generate_pdf_thumbnail($path, $width, $height)
	{

		//die("convert -thumbnail -density 300 ".$path."[1] ".$path."_thumb.jpg");
		exec("convert  -resize '20%' -density 150 ".$path."[0] ".$path."_thumb.jpg");
		exec("cp ".$path."_thumb.jpg ".$path."_thumb");
		return "".$path."_thumb";
		//return "convert -thumbnail x300 ".$path."_thumb ".$path;
		// Generate pdf thumbnail
		/*
		$im = new imagick();
		$im->setResolution($width,$height);
		$im->readimage($path);
		$im->setImageFormat('jpeg');
		$im->writeImage($path.'_thumb');
		$im->clear();
		$im->destroy();
		 *
		 */
		//return $path.'_thumb';
	}

	private function icon_exists($extension, $add = ".png")
	{
		
		$module_config2 = $this->config->item('upload_config');

		$file_path  = $module_config2['module_path']."assets/images/Free-file-icons/32px/".$extension.$add;
		if(file_exists($file_path))
		{
			return $file_path;
		}

		return 0;
	}

	private function convert_client_filename ($filename, $extension)
	{
		$client_filename = 0;
		// Remove extension from filename
		$client_filename = preg_replace('/'.$extension.'$/', '', $filename);
		$client_filename = str_replace('_', ' ', $client_filename);
		$client_filename = str_replace('+', ' ', $client_filename);
		$client_filename = str_replace('  ', ' ', $client_filename);
		$client_filename = ucfirst($client_filename);
		return $client_filename;
	}

	private function get_available_module_models()
	{
		// appropriate as library function (private function get_available_module_models())
		
		$alias_config = $this->config->item('alias_config');
		array_push($alias_config['exclude_target_modules'], 'file_manager');
		$unfiltered_custom_module_models = module_files(null, 'models', true);
		foreach($alias_config['include_core_modules'] as $core_module_name => $core_module_data)
		{
			$unfiltered_custom_module_models[$core_module_name] = $core_module_data;
		}
		foreach($unfiltered_custom_module_models as $module_name => $unfiltered_custom_module_models_data)
		{
			if(in_array($module_name, $alias_config['exclude_target_modules'])) continue;

			$custom_module_models[$module_name] = $unfiltered_custom_module_models_data;

			foreach($custom_module_models[$module_name]['models'] as $model_key => $model_value)
			{
				$custom_module_models[$module_name]['models'][$model_key] = substr($model_value, 0, -4);
			}
		}
		$available_module_models = $custom_module_models;
		ksort($available_module_models);
		return $available_module_models;
		// end: appropriate lib.func.
	}

	private function perform_upload($config)
	{
		// Declaring contents of return
		$return = array('error' => null, 'file_exists_db' => null, 'file_exists_hdd' => null, 'return_data' => null);

		// Preventing incorrect file names
		$config['file_name'] = md5(rand(20000, 90000));

		// Load CodeIgniter's upload library, config variable describes the upload environment
		$this->load->library('upload', $config);

		// Perform upload
		if (!$this->upload->do_upload())
		{
			// Notice: Check to see why these parameters can't be set with abstract call to Template class
			// Triggered by violation of configured limitations
			$return['error']['upload'] = $this->upload->display_errors();
			$this->upload->error_msg = '';
		}
		else
		{
			// Get information about the upload such as names, types, sizes and so on
			$upload_data = $this->upload->data();

			// Get checksum to check if file already exist and if not, as a file naming convention
                        $sha1_checksum = sha1_file($upload_data['full_path']);

			// Get data from database if the file already exists: the file has been renamed and moved and added to db
                        $db_data = $this->file_manager_files_model->select('id, file_name, description, tags, owner_user_id, public, sha1_checksum, extension, created')->find_by('sha1_checksum', $sha1_checksum);

			// Set whether file exists in db
			$file_exists_db = $db_data ? true : false;
			$return['file_exists_db'] = $file_exists_db;

			// Set whether the file exists in hdd
			$file_exists_hdd = file_exists($upload_data['file_path']."/".$sha1_checksum) ? true : false;
			$return['file_exists_hdd'] = $file_exists_hdd;

			$insert_data = array();

			if(!$file_exists_hdd)
			{
				// Rename file from temporarily md5 generated value to sha1 checksum
				rename($upload_data['full_path'], $upload_data['file_path']."/".$sha1_checksum);
			}

			if(!$file_exists_db)
			{
				// Set data to insert to db
				$insert_data = array(
					'id'		=> NULL,
					'file_name'	=> $this->security->sanitize_filename(basename($this->convert_client_filename($upload_data['client_name'], $upload_data['file_ext']))),
					'description'	=> '',
					'tags'		=> '',
					'owner_user_id'	=> $this->current_user->id,
					'public'	=> 0,
					'sha1_checksum'	=> $sha1_checksum,
					'extension'	=> substr($upload_data['file_ext'], 1),
					'created'	=> date("Y-m-d H:i:s")
				);
			}

			if($file_exists_db && $file_exists_hdd)
			{
				// If the file exists as sha1_checksum, the uploaded temporary file is deleted
				unlink($upload_data['full_path']);
			}

			// If the file doesn't exists, the file info is added to db
			// Set db ID with old db ID or mysql_insert_id from model->insert
                        $db_data_id = ($file_exists_db) ? $db_data->id : $this->file_manager_files_model->insert($insert_data);

			// Set the return_data
			$return_data = ($file_exists_db) ? (array) $db_data : $insert_data;

			// Set error messages if file exists in any or all storage types
			if($file_exists_db && $file_exists_hdd)
			{
				$return['error']['file_exists_both'] = 'The file exists in both database and on hdd';
			}
			elseif($file_exists_db || $file_exists_hdd) 
			{
				$return['error']['file_exists'] = 'The file exists in ' . ($file_exists_db ? 'db' : 'hdd') . ', created a new ' . ($file_exists_db ? 'file' : 'db record') . ' (' . ($file_exists_db ? $upload_data['client_name'] : $db_data_id) . ')';
			}
			
			// Add db row ID to the return_data // CHECK TO SEE IF THIS IS NECESSARY
			$return_data['database_row_id'] = $db_data_id;

			// Log the event
			$log_tmp_str = ($file_exists_db) ? 'Upload failed: File exists ( file id: ' . $db_data_id . ' file name: '.$db_data->file_name.' sha1 checksum: '.$sha1_checksum.' )' : 'File uploaded ( file id: ' . $db_data_id . ' file name: FEL sha1 checksum: '.$sha1_checksum.' )';
			$this->activity_model->log_activity($this->current_user->id, $log_tmp_str.' : ' . $this->input->ip_address(), 'file_manager');

			// Add return_data to return
			$return['return_data'] = $return_data;
		}

		return $return;
	}

	private function save_file_manager_files($type='insert', $id=0)
	{
		if ($type == 'update') {
			$_POST['id'] = $id;
		}

		$this->form_validation->set_rules('file_name','File name','required|max_length[255]');
		$this->form_validation->set_rules('description','Description','');
		$this->form_validation->set_rules('tags','Tags','max_length[255]');
		$this->form_validation->set_rules('public','Public','max_length[255]');

		if ($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		$data = array();
		$data['file_name']      = $this->input->post('file_name');
		$data['description']    = ($this->input->post('description')) ? $this->input->post('description') : '';
		$data['tags']           = ($this->input->post('tags')) ? $this->input->post('tags') : '';
		$data['public']         = $this->input->post('public');

		if ($type == 'update')
		{
			$return = $this->file_manager_files_model->update($id, $data);
		}

		return $return;
	}

	private function save_file_manager_alias($type='insert', $id=0)
	{
		if($type == 'update') {
			$_POST['id'] = $id;
		}

		if($type == 'insert')
		{
			$file_id = $id;
		}

		$this->form_validation->set_rules('alias_override_file_name','Override file name','max_length[255]');
		$this->form_validation->set_rules('alias_override_description','Description','');
		$this->form_validation->set_rules('alias_override_tags','Tags','max_length[255]');
		$this->form_validation->set_rules('alias_override_public','Public','max_length[255]');
		$this->form_validation->set_rules('alias_target_module','Target module','required|max_length[255]');
		$this->form_validation->set_rules('alias_target_model','Target model','max_length[255]');
		$this->form_validation->set_rules('alias_target_model_row_id','Target model row id','max_length[11]');

		if($this->form_validation->run() === FALSE)
		{
			return FALSE;
		}

		$data = array();
		if($type == 'insert') $data['file_id'] = $file_id;
		$data['override_file_name']	= $this->input->post('alias_override_file_name');
		$data['override_description']	= ($this->input->post('alias_override_description')) ? $this->input->post('alias_override_description') : '';
		$data['override_tags']		= ($this->input->post('alias_override_tags')) ? $this->input->post('alias_override_tags') : '';
		$data['override_public']	= $this->input->post('alias_override_public');
		$data['target_module']		= $this->input->post('alias_target_module');
		$data['target_model']		= ($this->input->post('alias_target_model')) ? $this->input->post('alias_target_model') : '';
		$data['target_model_row_id']	= ($this->input->post('alias_target_model_row_id') ? $this->input->post('alias_target_model_row_id') : 0);

		if($type == 'insert')
		{
			$id = $this->file_manager_alias_model->insert($data);

			if (is_numeric($id))
			{
				$return = $id;
			} else
			{
				$return = FALSE;
			}
		}
		else if($type == 'update')
		{
			$return = $this->file_manager_alias_model->update($id, $data);
		}

		return $return;
	}
}
