<?php
global $wpdb;

$user_id = 1;

//define user 
if (get_user_meta( $user_id, 'smr_type', true ) == '') {
	update_user_meta( $user_id, 'smr_type', 'user' );
}


$current_version = SMReview_PLUGIN_VERSION;


$haveBusinesses = count((array) $wpdb->get_results($wpdb->prepare('SELECT * from ' . $wpdb->prefix . 'start_my_review where site_owner = %d', $user_id))) >= 1 ? true : false;

$accounts = get_users();

?>


<?php if (!$haveBusinesses): ?>
	<script type="text/javascript" charset="utf-8">
		window.DELCANVAS = true;
	</script>
<?php endif?>

<div class='uk-margin-top' id='insop-panel-wrapper'>
	<?php
	if (get_option('smr_auth', 0) == "1") {		
		$response = wp_remote_get('http://startmyreview.com/wp-json/smr/auth?email='. get_option("smr_auth_email") .'&password='.get_option('smr_auth_passwd'), ['sslverify' => false]);
		if (!$response instanceof WP_Error && trim($response['body'], '"') == 'success') {			
			include 'panel.php';
		}else{
			include 'smr_auth.php';
		}
		
	}else {
		include 'smr_auth.php';
	}
	?>
</div>



<script type="text/javascript">
	if (window.DELCANVAS == true) {
		document.querySelectorAll('#bizVisits, #bizComments, #bizRatings').forEach(function(e) {
			e.remove();
		})
	}
</script>