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
         * openWrapper function
         *
         * @return string
         * */
        public function openWrapper($pageTitle, $icon = 'themes') {
            $content = '<div class="wrap">
                            <div id="icon-' . $icon . '" class="icon32"><br /></div>
                            <h2>' . $pageTitle . '</h2>
                            <br />';
            return $content;
        }

        /**
         * closeWrapper function
         *
         * @return string
         * */
        public function closeWrapper() {
            $content = '</div>';
            return $content;
        }

        /**
         * function to open a form
         *
         * @return void
         * */
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
         * function to close a form
         *
         * @return void
         * */
        public function closeForm() {
            $content = '</form>';
            return $content;
        }

        /**
         * function to open table
         *
         * @return void
         * */
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
         * function to open table
         *
         * @return void
         * */
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
         * loadView function
         *
         * @return void
         * */
        public function loadView($view, $pluginName, $ext = 'php') {
            include($_SERVER['DOCUMENT_ROOT'] . 'wp-content/plugin/' . PLUGIN_NAME . '/views/' . $view . '.' . $ext);
        }

        /**
         * function to send an email
         *
         * @return void
         * */
        public function sendmail($to, $from, $subject, $message) {
            $headers = 'From: ' . $from;
            mail($to, $subject, $message, $headers);
        }

        /**
         * a plugin to set a default value in form fields
         *
         * @return void
         * */
        public function set_value($value, $default_value) {
            if (isset($value) && !empty($value)) {
                return $value;
            } else {
                return $default_value;
            }
        }

        /**
         * a plugin to set a default value in form fields
         *
         * @return void
         * */
        public function set_form_value($name, $default_value) {
            return (array_key_exists($name, $_POST)) ? $_POST[$name] : (isset($default_value)) ? $default_value : '';
        }

        /**
         * public to check if a checkbox is checked. If it is the attribute checked will be returned
         *
         * @return void
         * */
        public function if_checked($value) {
            if ($value == 1 || $value == 'on' || $value == 'checked') {
                return true;
            } else {
                return false;
            }
        }

        /**
         * public to check if a radio is checked
         *
         * @return void
         * */
        public function if_selected($value) {
            if ($value == 1 || $value == 'on' || $value == 'checked' || $value == 'selected') {
                return true;
            } else {
                return false;
            }
        }

        /**
         * function to create a slug for usage in an url for example
         *
         * @return void
         * */
        public function createSlug($slug) {
            if (!empty($slug)):
                $str = strtolower(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $slug), '_'));
                return $str;
            else:
                return false;
            endif;
        }

        /**
         * function to get file contents
         *
         * @return void
         * */
        public function getFileContent($path) {
            if (!file_exists($path)) {
                throw new exception(__CLASS__ . '::' . __FUNCTION__ . ' - Could not get content from file!');
            }
            $content = file_get_contents($path, FILE_USE_INCLUDE_PATH);
            return $content;
        }

        /**
         * Response with json header
         * @param string $response 
         */
        public function jsonResponseOutput($response) {
            header("Content-Type: application/json");
            echo $response;
            exit;
        }
        
        public function crud_page($name, $submenu, $records, $count)
        {
            
        }
        
        
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
        
        public function minifyCode($code)
        {
            $code = preg_replace('/((?<!\/)\/\*[\s\S]*?\*\/|(?<!\:)\/\/(.*))/','',$code);
            $code = preg_replace("/\n|\r|\t/","", $code);
            $code = preg_replace("/[ \t]{2,} /"," ", $code);
            return $code;
        }
        
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