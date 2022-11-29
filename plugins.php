<?php
add_action( 'rest_api_init', function () {
	register_rest_route( 'myplugin/v1', '/activate', array(
		'methods' => 'GET',
		'callback' => 'my_plugin_active',
	));
	register_rest_route( 'myplugin/v1', '/de-activate', array(
		'methods' => 'GET',
		'callback' => 'my_plugin_deactive',
	));
});


function my_plugin_active( $data ) {	
	$plugin = 'akismet/akismet.php';
	$current = get_option( 'active_plugins' );
	$plugin = plugin_basename( trim( $plugin ) );
	if ( !in_array( $plugin, $current ) ) {
		$current[] = $plugin;
		sort( $current );
		do_action( 'activate_plugin', trim( $plugin ) );
		update_option( 'active_plugins', $current );
		do_action( 'activate_' . trim( $plugin ) );
		do_action( 'activated_plugin', trim( $plugin) );
		echo "Done";
	}else{
		echo "Error";
	}	
}

function my_plugin_deactive( $data ) {
	$plugin = 'akismet/akismet.php';
	$current = get_option( 'active_plugins' );
  $plugin_basename = plugin_basename( trim( $plugin ) );	
	if ( in_array( $plugin_basename, $current ) ) {		
		$key = array_search($plugin,$current);
		unset($current[$key]);
		update_option( 'active_plugins', $current );		
		do_action( 'deactivate_' . trim( $plugin_basename ) );
		do_action( 'deactivate_plugins', trim( $plugin_basename) );
		echo "Done";
	}else{
		echo "Error";
	}
}
?>
