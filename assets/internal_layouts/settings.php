<div>
	<h4>StartMyReview plugin update</h4>
	<p>If you want to update your plugin to a latest version offering a new feature of a patch, this is the place to do so.</p>
</div>
<div hidden="">
	<div class='uk-text-meta'>
		Enter your startmyreview registered email
	</div>
	<div>
		<input type="text" id='smr-update-email' class='uk-input uk-width-medium'>
		<input type="button" id='save-update-email' class='uk-button uk-button-default' value="Save">
	</div>
</div>
<div class='uk-text-center uk-margin-medium-top uk-padding-small' style='border: 1px solid #e3e3e3'>
	<h5>Plugin Updates</h5>
	<p>Your current version number is <b><?php echo $current_version ?></b></p>

	<p id='newer-version-notification'></p>

	<input type="button" value='Check for update' class='uk-button uk-button-primary uk-border-rounded' id='smr-check-update'>

	<input type="button" value='Update now' class='uk-button uk-button-primary uk-border-rounded' id='smr-do-update' hidden="">

	<input type="hidden" id='smr-store-version' value="<?php echo $current_version ?>">

</div>