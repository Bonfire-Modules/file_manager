Bonfire-Filemanager
===================

Includes upload and import, aliases and widgets for easy display and download from other modules

-----------------------------------------------------------------------

### Road Map

Check out our online [road map](https://trello.com/board/file-manager/51a12c111ea77c6f79007df9) where you can comment and vote on items in the lists.

### More info
This module is a complete file manager where the user can upload files and assign aliases connected to other modules, their models or model rows.
Module or model related file aliases is displayed calling the alias display widget using one line of code in any view file.
For improved listing functionality we have implemented our Datatable module that includes filter and search capability, pagination and much more.

### Features

- Multiple file upload and file import capability.
- Sanitized downloads
- Improved tables with Datatable
- File aliases
- Widgets for easy display from other modules

### Usage

#### Alias widget

Type the following from any view:

- echo Modules::run('file_manager/widget/alias');

The above lists all aliases. To filter the output to specific modules, models and/or model rows use either manual or automatic targets:

- Automatic targets: echo Modules::run('file_manager/widget/alias', array('autorun' => array('module', 'model', 'model_row_id')));

Available configurations:

- array('autorun' => array('module')) [outputs aliases attached to only the module, aliases attached to the module and model and/or model_row_id is ignored]
- array('autorun' => array('module', 'model')) [outputs all aliases attached to the model]
- array('autorun' => array('module', 'model', 'model_row_id')) [outputs aliases attached to model_row_id and aliases attached to model with no model_row_id

- Manual targets: echo Modules::run('file_manager/widget/alias', array('target_module' => 'module'));

Available configurations:

- array('target_module' => 'module');
- array('target_module' => 'module', 'target_model' => 'model');
- array('target_module' => 'module', 'target_model' => 'model', 'target_model_row_id' => [int]);

- Manual targets overrides automatic targets: echo Modules::run('file_manager/widget/alias', array('autorun' => array('module', 'model'), 'target_model' => 'model'));

### The Team

- [inbe](https://github.com/inbe) - Lead Developer
- [Janne-](https://github.com/Janne-) - Lead Developer
