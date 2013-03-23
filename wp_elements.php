<?php
/**
 * This is an easy to use Library Class to speed the process of writting wordpress plugin and the structure layout of your plugin
 * This Library Class is licensed under GPL and can be used in both personal and commercial applications.
 *
 * @author Christophe Debruel (uWebic)
 * */

if (!class_exists('WP_elements')) {
    class WP_elements {

        public function __construct() {

        }

        /**
         * openWrapper function - generates the basic admin wrap opening tags
         * @param type $pageTitle
         * @param type $icon
         * @return string 
         */
        public function openWrapper($pageTitle, $icon = 'themes') {
            $content = '<div class="wrap">
                            <div id="icon-' . $icon . '" class="icon32"><br /></div>
                            <h2>' . $pageTitle . '</h2>
                            <br />';
            return $content;
        }

        /**
         * closeWrapper function - generates the basic admin wrap closing tags
         * @return string 
         */
        public function closeWrapper() {
            $content = '</div>';
            return $content;
        }

        /**
         * Function to generate the form open tag
         * @param type $action
         * @param type $method
         * @param type $enctype
         * @param type $id
         * @return string 
         */
        public function openForm($action = '', $method = 'post', $enctype = false, $id = '') {
            if ($enctype === true) {
                $enc = 'enctype="multipart/form-data"';
            } else {
                $enc = '';
            }
            $content = '<form id="' . $id . '" method="' . $method . '" action ="' . $action . '" ' . $enc . ' >';
            return $content;
        }

        /**
         * Function to generate the form closing tag
         * @return string 
         */
        public function closeForm() {
            $content = '</form>';
            return $content;
        }

        /**
         * Function to generate the open tags of a table including some classes from wordpress + icon & title
         * @param type $title
         * @param type $icon
         * @param type $class
         * @param type $columns 
         */
        public function openTableWrapper($title, $icon = false, $class = 'options', $columns = 3) {
            if ($icon !== false):
            ?>
                <div class="icon32" id="icon-themes"><br></div>
            <?php endif; ?>
            <h2><?php echo $title; ?></h2>
            <table class="widefat creafolio_options">
                <thead><tr><th colspan="<?php echo $columns; ?>">&nbsp;</th></tr></thead>
                <tbody>
            <?php
        }

        /**
         * Function to generate the closing tags of a table and a submit button if requested
         * @param type $columns
         * @param type $submit 
         */
        public function closeTableWrapper($columns = 3, $submit = array('btn_name' => 'submit', 'btn_title' => 'Update Options')) {
                    ?>
                </tbody>
                <tfoot><tr><th colspan="<?php echo $columns; ?>">&nbsp;</th></tr></tfoot>
            </table>
            <?php if ($submit !== false): ?>
                <p><input type="submit" name="<?php echo $submit['btn_name']; ?>" value="<?php echo $submit['btn_title']; ?>" class="button-primary" /></p>
                <?php
            endif;
        }

        /**
         * Function to load a given view or if the first view does not exist load a fallback view
         * Example: $wpelements->loadView(array('path' => 'view.php', 'original_path' => 'original_view.php',), $data);
         * @param array $paths
         * @param array $data
         */
        public function loadView($paths, $data = null) {
            if(!isset($paths['path']) && !isset($paths['original_path'])) {
                throw new exception ('No view specified.');
            }

            if (isset($paths['path']) && file_exists($paths['path'])) {
                include $paths['path'];
            } else {
                if (!empty($paths['original_path']) && file_exists($paths['original_path'])) {
                    include $paths['original_path'];
                } else {
                    throw new exception ('No views could be loaded. Make sure the paths to the view files are correct.');
                }
            }
        }

        /**
         * Function to set a value for a field or return the default value given. Removes away the need to add an if/else statement to check if a value exists or not
         * @param type $value
         * @param type $default_value
         * @return type  
         */
        public function set_value($value, $default_value) {
            if (isset($value) && !empty($value)) {
                return $value;
            } else {
                return $default_value;
            }
        }

        /**
         * Function that checks if a given key exist in the $_POST array and returns it
         * @param type $name
         * @param type $default_value
         * @return type 
         */
        public function set_form_value($name, $default_value) {
            return (array_key_exists($name, $_POST)) ? $_POST[$name] : (isset($default_value)) ? $default_value : '';
        }

        /**
         * Function to check if a checkbox is checked. If it is the attribute checked will be returned
         * @param type $value
         * @return type 
         */
        public function if_checked($value) {
            if ($value == 1 || $value == 'on' || $value == 'checked') {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Function to check if a radio input field is checked
         * @param type $value
         * @return type 
         */
        public function if_selected($value) {
            if ($value == 1 || $value == 'on' || $value == 'checked' || $value == 'selected') {
                return true;
            } else {
                return false;
            }
        }

        /**
         * Function to create a slug for usage in an url for example
         * @param type $slug
         * @return type 
         */
        public function createSlug($slug) {
            if (!empty($slug)):
                $str = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $slug), '_'));
                return $str;
            else:
                return false;
            endif;
        }

        /**
         * Function to get the contents of a file or throw an exception
         * @param type $path
         * @return type 
         */
        public function getFileContent($path) {
            if (!file_exists($path)) {
                throw new exception(__CLASS__ . '::' . __FUNCTION__ . ' - Could not get content from file!');
            }
            $content = file_get_contents($path, FILE_USE_INCLUDE_PATH);
            return $content;
        }

        /**
         * Function to respond with json header. Usefull for ajax calls
         * @param type $response 
         */
        public function jsonResponseOutput($response) {
            header("Content-Type: application/json");
            echo $response;
            exit;
        }
        
        
        /**
         * Function to generate an input field
         * @return string
         * */
        public function input_field($type = 'text', $name, $label, $params = null)
        {
            $value = (isset($params['value']))? $params['value'] : get_option($name) ;
            $class = (isset($params['class']))? $params['class'] : 'input_field' ;
            $class .= (isset($params['required']) && $params['required'] == true) ? ' required':'';
            $size = (isset($params['size']))? $params['size'] : '30' ;
            $for_table = (isset($params['for_table']))? $params['for_table'] : true ;
            $message = (isset($params['message']))? $params['message'] : '' ;
            
            if ($for_table) {
                $input = '<tr valign="top">';
                    $input .= '<th scope="row"><label for="' . $name . '">' . _($label) . '</label></th>';
                    $input .= '<td><input class="' . $class . '_input" type="' . $type . '" value="' . $value . '" name="'. $name . '" id="'. $name . '" size="' . $size . '" /> ';
                    $input .= '<small>' . $message . '</small></td>';
                $input .= '</tr>';
            } else {
                $input = '<p>';
                    $input .= '<label for="' . $name . '">' . _($label) . '</label>';
                    $input .= '<input class="' . $class . '" type="' . $type . '" value="' . $value . '" name="'. $name . '" id="'. $name . '" size="' . $size . '" /> ';
                    $input .= '<small>' . $message . '</small>';
                $input .= '</p>';
            }
            return $input;
        }
        
        /**
         * Function to generate an textarea
         * @return string
         * */
        public function textarea_field($name, $label, $params = null)
        {
            $value = (isset($params['value']))? $params['value'] : '' ;
            $class = (isset($params['class']))? $params['class'] : 'input_field' ;
            $cols = (isset($params['cols']))? $params['cols'] : '50' ;
            $rows = (isset($params['rows']))? $params['rows'] : '5' ;
            $for_table = (isset($params['for_table']))? $params['for_table'] : true ;
            $message = (isset($params['message']))? $params['message'] : '' ;
            
            if ($for_table) {
                $input = '<tr valign="top">';
                    $input .= '<th scope="row"><label for="' . $name . '" class="txt_frm_label">' . _($label) . '</label></th>';
                    $input .= '<td><textarea class="' . $class . '_textarea" name="'. $name . '" id="'. $name . '" cols="' . $cols . '" rows="' . $rows . '">' . $value . '</textarea><small>' . $message . '</small></td>';
                $input .= '</tr>';
            } else {
                $input = '<p>';
                    $input .= '<label for="' . $name . '" class="txt_frm_label">' . _($label) . '</label>';
                    $input .= '<textarea class="' . $class . '_textarea" name="'. $name . '" id="'. $name . '" cols="' . $cols . '" rows="' . $rows . '">' . $value . '</textarea>';
                    $input .= '<small>' . $message . '</small>';
                $input .= '</p>';
            }
            return $input;
        }
        
        /**
         * Function to generate an select dropdown
         * @return string
         * */
        public function select_field($options, $name, $label, $params = null)
        {
            //check if there are options
            if (!is_array($options) || empty($options)) {
                return 'No select options provided';
            }
            $default = (isset($params['default']))? $params['default'] : '' ;
            $class = (isset($params['class']))? $params['class'] : 'input_field' ;
            $for_table = (isset($params['for_table']))? $params['for_table'] : true ;
            $message = (isset($params['message']))? $params['message'] : '' ;
            
            if ($for_table) {
                $field = '<tr valign="top">';
                    $field .= '<th scope="row"><label for="' . $name . '">' . _($label) . '</label></th>';
                    $field .= '<td>';
                        $field .= '<select name="' . $name . '" id="' . $name . '">';
                            foreach ($options as $option){
                                if ($option['value'] == $default) {
                                    $selected = 'selected';
                                } else {
                                    $selected = '';
                                }
                                $field .= '<option name="' . $option['value'] . '" value="' . $option['value'] . '" ' . $selected . '>' . $option['option'] . '</option>';
                            }
                        $field .= '</select>';
                    $field .= '</td>';
                    $field .= '<td><small>' . $message . '</small></td>';
                $field .= '</tr>';
            } else {
                $field = '<p>';
                    $field .= '<label for="' . $name . '">' . _($label) . '</label>';
                    $field .= '<select name="' . $name . '" id="' . $name . '">';
                        foreach ($options as $option){
                            if ($option['value'] == $default) {
                                $selected = 'selected';
                            } else {
                                $selected = '';
                            }
                            $field .= '<option name="' . $option['value'] . '" value="' . $option['value'] . '">' . $option['option'] . '</option>';
                        }
                    $field .= '</select>';
                    $field .= ' <small>' . $message . '</small>';
                $field .= '</p>';
            }
            return $field;
        }
        
        /**
         * Function to minify any given string (usefull for javascript)
         * @return string
         * */
        public function minifyCode($code)
        {
            $code = preg_replace('/((?<!\/)\/\*[\s\S]*?\*\/|(?<!\:)\/\/(.*))/','',$code);
            $code = preg_replace("/\n|\r|\t/","", $code);
            $code = preg_replace("/[ \t]{2,} /"," ", $code);
            return $code;
        }
        
        /**
         * Function to upload a file to the media library
         * @return string
         * */
        public function uploadDownloadFiles($fieldName, $supported_types, $optional = false)
        {
            // Make sure the file array isn't empty  
            if(!empty($_FILES[$fieldName]['name']) && $_FILES[$fieldName]['error'] == 0) { 

                // Get the file type of the upload  
                $arr_file_type = wp_check_filetype(basename($_FILES[$fieldName]['name']));
                $uploaded_type = $arr_file_type['type'];  

                // Check if the type is supported. If not, throw an error.  
                if(in_array($uploaded_type, $supported_types)) {  

                    // Use the WordPress API to upload the file  
                    $upload = wp_upload_bits(sanitize_file_name($_FILES[$fieldName]['name']), null, file_get_contents($_FILES[$fieldName]['tmp_name']));  

                    if(isset($upload['error']) && $upload['error'] != 0) {  
                        throw new exception('There was an error uploading your file. The error is: ' . $upload['error']);  
                    } else {  
                        return $upload;      
                    } // end if/else  

                } else {  
                    throw new exception("wrong file type.");  
                } // end if/else  
            } else {
                if (!$optional) {
                    $fieldName = str_replace('_thumb_', ' ', $fieldName);
                    throw new exception('you did not upload an image for ' . $fieldName);
                }
            }
         }
         
         /**
         * Function to upload an image to the media library and set it as the featured image of a post
         * @param string Name of the upload field
         * @param int ID of the post
         * @return string
         * */
        public function set_featured_image($file, $post_id){  
            require_once(ABSPATH . "wp-admin" . '/includes/image.php');  
            require_once(ABSPATH . "wp-admin" . '/includes/file.php');  
            require_once(ABSPATH . "wp-admin" . '/includes/media.php');  
            $attachment_id = media_handle_upload($file, $post_id);  
            update_post_meta($post_id, '_thumbnail_id', $attachment_id);  
            $attachment_data = array(  
            'ID' => $attachment_id
            );  
            wp_update_post($attachment_data);  
            return $attachment_id;  
        } 

    }//end of class
}