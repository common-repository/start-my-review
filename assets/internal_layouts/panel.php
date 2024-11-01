<div>
	<div uk-grid class='uk-grid-small'>

		<div class='uk-hidden@m'>
			<div class='il uk-margin-remove-top hbtns'>
				<div>
					<div class='uk-margin-remove-vertical uk-display-inline-block db hand uk-padding-small active-element' data-binding='business-container'><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo SMReview_REVIEW_URI ?>assets/images/business.png);"></span> Businesses</div>
					<div class='uk-margin-remove-vertical uk-display-inline-block db hand uk-padding-small' data-binding='reviews-container'><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo SMReview_REVIEW_URI ?>assets/images/reviews.png);"></span> Reviews</div>
					<div class='uk-margin-remove-vertical uk-display-inline-block db hand uk-padding-small' data-binding='stats-container'><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo SMReview_REVIEW_URI ?>assets/images/stats.png);"></span> Stats</div>
				</div>
			</div>
		</div>

		<div class='uk-width-expand uk-visible@m'>
			<div class='uk-padding-small uk-background-muted' id='panel-logo-container'>
				<div class='uk-text-center'>
					<img src="<?php echo SMReview_REVIEW_URI ?>assets/images/logo.png">
				</div>
				<div class='uk-text-center'>
					<h5 class='theme-brand-name uk-margin-remove-bottom uk-text-meta'> v<?php echo SMReview_PLUGIN_VERSION ?></h5>
				</div>
			</div>
			<ul class='uk-list uk-list-divider hand il uk-margin-remove-top'>
				<li class='uk-margin-remove-vertical uk-padding-remove-vertical active-element' data-binding='business-container'><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo SMReview_REVIEW_URI ?>assets/images/business.png);"></span> Businesses</li>
				<li class='uk-margin-remove-vertical uk-padding-remove-vertical' data-binding='reviews-container'><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo SMReview_REVIEW_URI ?>assets/images/reviews.png);"></span> Reviews</li>
				<li class='uk-margin-remove-vertical uk-padding-remove-vertical' data-binding='stats-container'><span class="uk-icon uk-icon-image" style="background-image: url(<?php echo SMReview_REVIEW_URI ?>assets/images/reviews.png);"></span> Stats</li>
			</ul>
		</div>

		<div class='uk-width-3-4@m uk-width-4-5@l uk-width-1-1 instant-options-panel-border-left'>
			<div class='uk-margin-small-top uk-margin-bottom uk-margin-small-left uk-margin-small-right'>

				<div id='business-container' class='he'>
					<?php

					//get account type
					$account_type = wp_remote_get('http://startmyreview.com/wp-json/smr/account-type?email='.get_option ('smr_auth_email', 'false'), ['sslverify' => false] )['body'];
					
					if ($account_type == '"user"') {
						include 'business_user.php';
					} else if ($account_type == '"agency"'){
						include 'business_agency.php';
					}else{
						delete_option('smr_auth');
						delete_option('smr_auth_email');
						delete_option('smr_auth_passwd');
					}
					?>
				</div>

				<div id='reviews-container' class='uk-hidden he'>
					<?php include 'reviews.php'; ?>
				</div>

				<div id='stats-container' class='uk-hidden he'>
					<?php include 'stats.php'; ?>
				</div>

				<div id='settings-container' class='uk-hidden he'>
					<?php include 'settings.php'; ?>
				</div>

				<div id='customers-container' class='uk-hidden he'>
					<?php include 'customers.php'; ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class='uk-background-muted' hidden="">
	<div class='uk-padding-small'>

		<div class='vertical-options uk-hidden@m'>

		</div>
		<div uk-grid class='uk-grid-divider'>
			<div class='uk-width-1-4@m uk-visible@m'>
				<ul class="uk-subnav uk-subnav-pill uk-tab-left" uk-switcher="connect: .switcher-container">
					<li><a href="#">Overview</a></li>
					<li><a href="#">Businesses</a></li>
					<li><a href="#">Reviews</a></li>
				</ul>
			</div>
			<div class='uk-width-1-1@s uk-width-3-4@m'>
				<ul class='uk-switcher switcher-container'>
					<li>
						

					</li>
					<li>


					</li>
					<li>

					</li>
				</ul>
			</div>
		</div>
	</div>