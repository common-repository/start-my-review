<?php

/*
Plugin Name: StartMyReview
Description: 
Version: 3.0.2
Author: 
Author URI: 
*/

if (!defined('ABSPATH')) {
	exit;
}

// define('SMRNC_APP_URL', 'http://localhost:8100/#');
define('SMRNC_APP_URL', 'https://app.startmyreview.com/#');

class SMRNC_Bootstrap {
	
	function run() {
		add_action('admin_menu', array($this, 'admin_menu'));
		add_action('wp_head', array($this, 'wp_head'));
	}

	function admin_menu() {
		add_menu_page('smrnc', 'StartMyReview', 'administrator', 'smrnc_settings_slug_new', array($this,'settings_page'), '');
	}
	
	function wp_head() {
		if($smrnc_integration_tag = get_option("smrnc_integration_tag", null)){
			echo stripslashes($smrnc_integration_tag);
		}
	}

	function settings_page() {
		if(isset($_POST['smrnc_integration_tag'])){
			update_option("smrnc_integration_tag", $_POST['smrnc_integration_tag']);
		}

		$smrnc_integration_tag = get_option("smrnc_integration_tag", null);
		?>

		<div class="wrap">
			<iframe src="<?php echo SMRNC_APP_URL; ?>/login/" frameborder="0" width="100%" height="500px"></iframe>
		</div>

		<form method="post">
			<table class="form-table">
				<tbody>
					<tr>
						<th scope="row">
							<label>Integration tag</label>
						</th>
						<td>
							<textarea name="smrnc_integration_tag" rows="3" style="width: 100%;"><?php echo stripslashes($smrnc_integration_tag); ?></textarea>
						</td>
					</tr>
				</tbody>
			</table>

			<p class="submit">
				<input type="submit" name="" class="button-primary" value="Save">
			</p>
		</form>
		<?php
	}
}

$smrnc = new SMRNC_Bootstrap();

$smrnc->run();
