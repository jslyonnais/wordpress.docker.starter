<?php 
////////////////////////////////////////
//	WP Config
////////////////////////////////////////

/**
* Maintenance Mode
*
* This function checks for the existence of a `.maintenance` file in the WordPress root directory. 
* If this file exists, and the current user is not an administrator or superadmin, 
* the website will display a custom maintenance page and stop further execution.
*
* @see ABSPATH This constant contains the absolute path to the WordPress directory.
* @see current_user_can() This function checks whether the current user has a particular capability.
* @see get_template_directory() This function retrieves the absolute path to the directory of the current theme.
*
* @note To activate maintenance mode, create a `.maintenance` file in your WordPress root directory. 
* Ensure you have a `maintenance.php` file in your theme directory to serve as your custom maintenance page.
*/
add_action('get_header', 'maintenace_mode');
function maintenace_mode() {
  if (file_exists(ABSPATH . '.maintenance') && !(current_user_can('administrator') || current_user_can('superadmin')) ) {
    include(get_template_directory() . '/maintenance.php');
    die();
  }
}

/**
* Hide ACF Menu
*
* This function hides the Advanced Custom Fields (ACF) menu from the WordPress admin dashboard. 
* This is done because all ACF fields are registered programmatically in this project, 
* and we want to avoid users manipulating fields from the dashboard, encouraging them to understand 
* and modify the fields through the code instead.
*
* @see add_filter() This function hooks a function to a specific filter action.
* @see acf/settings/show_admin This filter is used to show/hide the ACF menu in the WordPress admin dashboard.
* @see __return_false() This function is a utility that returns false. It is used here as a callback to hide the ACF menu.
*
* @note ACF Pro must be installed and activated for this filter to work. 
*/
add_filter('acf/settings/show_admin', '__return_false');

/**
* Sanitize Upload Filename
*
* This function sanitizes the filename of uploaded files by removing accents, 
* special characters, and spaces. It also replaces dots inside filenames with dashes.
*
* @param string $filename The original name of the uploaded file.
* @return string The sanitized filename.
* 
* @see add_filter() This function hooks a function to a specific filter action.
* @see sanitize_file_name This is a WordPress filter that is applied to the name of an uploaded file.
* @see preg_replace() This function performs a regular expression search and replace.
* @see str_replace() This function replaces some characters with some others in a string.
*
* @note This function does not affect the file extension.
*/
add_filter('sanitize_file_name', 'sanitize_filename_on_upload', 10);
function sanitize_filename_on_upload($filename) {
  $ext = end(explode('.',$filename));
  // Replace all special characters except letters, numbers, dashes, underscores, and dots
  $sanitized = preg_replace('/[^a-zA-Z0-9-_.]/','', substr($filename, 0, -(strlen($ext)+1)));
  // Replace dots inside filename
  $sanitized = str_replace('.','-', $sanitized);
  return strtolower($sanitized.'.'.$ext);
}

/**
* Remove Author from oEmbed Data
*
* This function removes the author's URL and name from the oEmbed data.
* oEmbed is a protocol that allows sites to display embedded content (such as tweets, posts, etc.) 
* when a user posts a link to that resource, without having to parse the resource directly.
*
* @param array $data The original oEmbed data.
* @return array The modified oEmbed data with the author's URL and name removed.
*
* @see add_filter() This function hooks a function to a specific filter action.
* @see oembed_response_data This is a WordPress filter that is applied to the oEmbed response data.
*/
add_filter( 'oembed_response_data', 'disable_oembed_response_data' );
function disable_oembed_response_data( $data ) {
  // Check if the author's URL exists in the oEmbed data and remove it if it does
  if (isset($data['author_url'])) {
    unset($data['author_url']);
  }
  
  // Check if the author's name exists in the oEmbed data and remove it if it does
  if (isset($data['author_name'])) {
    unset($data['author_name']);
  }
  
  return $data;
}

/**
* Redirect author archive pages
*
* This function checks if an author archive page is being requested and redirects to the homepage.
* This is useful to prevent user enumeration attempts via the `?author=1` URL query.
*
* @see is_author() This function checks if an author archive page is being queried.
* @see home_url() This function retrieves the URL for the current site where the front end is accessible.
* @see wp_redirect() This function redirects the user to a specified URL.
*
* @note This function should be hooked to the 'template_redirect' action.
* @note Make sure to exit after calling wp_redirect() to prevent further output.
*/
add_action('template_redirect', 'redirect_author_archive');
function redirect_author_archive() {
  if (is_author()) {
    wp_redirect(home_url());
    exit();
  }
}


////////////////////////////////////////
//	Includes Custom
////////////////////////////////////////

/**
* Import Custom Post Types
*
* This code block dynamically includes PHP files located in the `includes/post-types` folder. 
* Each of these files is expected to define a custom post type for WordPress.
*
* @see get_template_directory() This function retrieves the absolute path to the directory of the current theme.
* @see glob() This function is used to find pathnames matching a pattern.
* @see basename() This function is used to get the base name of the file.
* @see locate_template() This function is used to return the path to the file in the template directory.
*
* @note Ensure that each PHP file in the `includes/post-types` directory is properly formatted to define a custom post type.
*/
foreach (glob(get_template_directory() . '/includes/post-types/*.php') as $file) {
  $filename = basename($file);
  require_once locate_template('/includes/post-types/' . $filename);
}

/**
* Import Custom Fields
*
* This code block dynamically includes PHP files located in the `includes/custom-fields` folder. 
* Each of these files is expected to define custom fields for Advanced Custom Fields (ACF) Pro.
*
* @see get_template_directory() This function retrieves the absolute path to the directory of the current theme.
* @see glob() This function is used to find pathnames matching a pattern.
* @see basename() This function is used to get the base name of the file.
* @see locate_template() This function is used to return the path to the file in the template directory.
*
* @warning ACF Pro must be installed and activated for these custom fields to work properly.
* @note Ensure that each PHP file in the `includes/custom-fields` directory is properly formatted to define a custom field.
*/
foreach (glob(get_template_directory() . '/includes/custom-fields/*.php') as $file) {
  $filename = basename($file);
  require_once locate_template('/includes/custom-fields/' . $filename);
}


////////////////////////////////////////
//	Tooling for dev
////////////////////////////////////////

/**
* Pretty_r function
*
* This function provides a more readable output of a variable, array or object. 
* It uses the built-in PHP function print_r() to present human-readable information about a variable, 
* and it wraps the output in <pre> HTML tags to preserve the formatting and make it easier to read in the browser.
*
* @param mixed $var This is the variable that will be output. It can be of any type (e.g., array, object, string, integer).
* @return void The function does not return a value. It directly outputs the formatted information to the browser.
* @see print_r() is a built-in PHP function that prints human-readable information about a variable.
*/
function pretty_r($var){
  echo "<pre>";
  print_r($var);
  echo "</pre>";
}


/**
 * Enqueue Vite assets
 *
 * Enqueues the Vite assets based on the current environment.
 * If in development mode, loads the assets from the Vite server with hot reloading.
 * If in production mode, loads the assets from the 'dist' directory.
 *
 * @action wp_enqueue_scripts
 */
add_action('wp_enqueue_scripts', 'load_vite_assets');
function load_vite_assets() {
  if (defined('WP_DEBUG') && WP_DEBUG) {
    // Enqueue the main JavaScript file from the Vite server with HMR enabled.
    function vite_head_module_hook() {
      echo '<script type="module" crossorigin src="' . getenv('VITE_DEV_SERVER_URL') . '/@vite/client' . '"></script>';
      echo '<script type="module" src="' . getenv('VITE_DEV_SERVER_URL') . '/index.js' . '"></script>';
    }
    add_action('wp_head', 'vite_head_module_hook');

  } else {
    // In production mode, load the assets from the 'dist' directory.
    // Path to the manifest file.
    $manifest_path = get_template_directory() . '/assets/dist/manifest.json';

    // Check if the manifest file exists.
    if (file_exists($manifest_path)) {
      // Get the contents of the manifest file.
      $manifest_contents = file_get_contents($manifest_path);

      // Decode the JSON from the manifest file.
      $manifest = json_decode($manifest_contents, true);

      // Loop through each entry in the manifest.
      foreach ($manifest as $entry) {
        // Get the filename of the built asset.
        $asset_path = get_template_directory_uri() . '/assets/dist/' . $entry['file'];

        // Get the extension of the built asset.
        $ext = pathinfo($asset_path, PATHINFO_EXTENSION);

        // Enqueue the asset based on its extension.
        switch ($ext) {
          case 'css':
            wp_enqueue_style(md5($asset_path), $asset_path, array(), null);
            break;
          case 'js':
            wp_enqueue_script(md5($asset_path), $asset_path, array(), null, true);
            break;
        }
      }
    }
  }
}

?>