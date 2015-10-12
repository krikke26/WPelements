WPelements
==========

An easy to use Library Class to speed the process of writting wordpress plugin and the structure layout of your plugin.

## Install

	composer require krike/wp-elements

## Usage

You can can create a new instance of the class WP_elements or make a static function call.

	$wpelements = new WP_elements();
	$wpelements->set_featured_image($file, $post_id)
OR

	WP_elements::set_featured_image($file, $post_id)

#### openWrapper()

	WP_elements::openWrapper('Page title', 'themes'); //second parameter is the icon, it is optional


#### closeWrapper()

	WP_elements::closeWrapper()


#### openForm()
	openForm($action = '', $method = 'post', $enctype = false, $id = '')

#### closeForm()
	closeForm()

#### openTableWrapper()
	openTableWrapper($title, $icon = false, $class = 'options', $columns = 3)

#### closeTableWrapper()
	closeTableWrapper($columns = 3, $submit = array('btn_name' => 'submit', 'btn_title' => 'Update Options'))

#### loadView()
	loadView($paths, $data = null)

#### set_value()
	set_value($value, $default_value)

#### set_form_value()
	set_form_value($name, $default_value)

#### if_checked()
	if_checked($value)

#### if_selected()
	if_selected($value)

#### createSlug()
	createSlug($slug)

#### getFileContent()
	getFileContent($path)

#### jsonResponseOutput()
	jsonResponseOutput($response)

#### input_field()
	input_field($type = 'text', $name, $label, $params = null)

#### textarea_field()
	textarea_field($name, $label, $params = null)

#### select_field(
	select_field($options, $name, $label, $params = null)

#### minifyCode()
	minifyCode($code)

#### uploadDownloadFiles($)
	uploadDownloadFiles($fieldName, $supported_types, $optional = false)

#### set_featured_image()
	set_featured_image($file, $post_id)

#### check_upload_folder()
	check_upload_folder($folderName)

#### filter_options()
	filter_options()

Coming in next update
==========
- Twig ready functions

License
==========
This Library Class is licensed under GPL and can be used in both personal and commercial applications.