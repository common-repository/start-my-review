<?php
$imgFolder = SMReview_REVIEW_URI . 'assets/images/';
$ajaxUrl   = admin_url('admin-ajax.php');

global $wpdb;

$businessData = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $wpdb->prefix . "start_my_review where id = %d", [intval($_GET['site_id'])]));
$site_data=json_decode($businessData->site_data);
$businessLogo    = $site_data->logo;
$businessYelpURL = $site_data->yelp_link;
$placeIdLink     = $site_data->placeId;
$fbLink     = $site_data->fb_link;
$bbbLink     = $site_data->bbb_link;
$yp              = $site_data->yp_link;

?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<script>
		var iframed = {
			ajax_url: '<?php echo admin_url('admin-ajax.php') ?>',
            nonce: '<?php echo wp_create_nonce('send_rate') ?>',
			isReviewSendable: false,
			captchaVerification: function (){
				$('#send-button').removeAttr('disabled').removeClass('uk-disabled')
				iframed.isReviewSendable = true
			},
			sid: <?php echo isset($_GET['site_id']) ?  intval($_GET['site_id']) : 0 ?>
		}
	</script>
	<?php wp_head(); ?>
</head>
<body>
	<div id='app'>
		<div class='uk-text-center uk-margin-top'>
			<img src="<?php echo $businessLogo; ?>" id='main-logo-business'>
		</div>

		<div class='rev-text uk-text-center'>
			Please review your experience with us, it will be less than a minute
		</div>

		<div id='stars-container' class='uk-margin-top uk-height-small uk-flex uk-flex-middle'>
			<div class='rating-div uk-display-block uk-margin-auto'>

			</div>
		</div>
	</div>

	<div id='low-review' class='uk-hidden'>

		<h3 class='rev-text uk-margin-top uk-padding-small uk-text-center uk-margin-remove-bottom prettify'>Please tell us how we can improve, send us your feedback, we really appreciate</h3>

		<div class='uk-padding-small'>
			<form action="" method="post" accept-charset="utf-8" id='low-rating-form'>
				<input type="text" name="reviewer-name" placeholder="Your Name *" class='uk-input uk-margin-small-bottom'>
				<input type="text" name="reviewer-phone" placeholder="Phone Number" class='uk-input uk-margin-small-bottom'>
				<input type="email" name="reviewer-email" placeholder="Your Email" class='uk-input uk-margin-small-bottom'>
				<label>Message</label>
				<textarea name="reviewer-message" class='uk-textarea uk-height-small' maxlength="500"></textarea>

				<div class="g-recaptcha uk-flex uk-flex-center uk-margin-small" data-callback="gCaptchaCallback" data-sitekey="6LdOgF4UAAAAAAtSO2RmUQBj5DP9tjGKnZjlXOk3"></div>

				<input type="submit" name="reviewer-send" value="Send Review" id='send-button' class='uk-button uk-button-primary uk-border-rounded uk-margin-auto uk-display-block'>

			</form>
		</div>
	</div>

	<div id='low-review-done' class='uk-flex uk-flex-middle uk-text-center uk-hidden uk-height-medium uk-flex-center'>
		<h2 class="rev-text prettify">Thank you for your feedback. We will contact you shortly</h2>
	</div>

	<div id='high-review' class='uk-hidden'>
		<h3 class='rev-text uk-margin-top uk-padding-small uk-text-center uk-margin-remove-bottom prettify'>We're glad you enjoyed your experience with us, please leave a review on your favorite site</h3>
		<div class='r-container uk-padding-small'>
			<div uk-grid class='uk-child-width-1-2@s uk-child-width-1-1 uk-flex uk-flex-center'>
				<?php if ($businessYelpURL != '' && filter_var($businessYelpURL, FILTER_VALIDATE_URL)): ?>
				<div class='uk-flex uk-flex-center uk-margin-small-top uk-margin-small-bottom'>
					<div class='uk-card uk-card-default uk-box-shadow-medium uk-width-1-1 uk-flex uk-flex-middle uk-flex-center uk-text-center uk-card-hover uk-padding-small hand uk-border-rounded' id='yelp-review-card' data-uri='<?php echo $businessYelpURL; ?>'>
						<img src="<?php echo $imgFolder ?>yelp.png" style='max-width: 200px'>
					</div>
				</div>
				<?php endif ?>

				<?php if ($placeIdLink != ''): ?>
				<div class='uk-flex uk-flex-center uk-margin-small-top uk-margin-small-bottom'>
					<div class='uk-card uk-card-default uk-box-shadow-medium uk-width-1-1 uk-flex uk-flex-middle uk-flex-center uk-text-center uk-card-hover uk-padding-small hand uk-border-rounded' id='google-review-card' data-uri='https://search.google.com/local/writereview?placeid=<?php echo $placeIdLink ?>'>
						<img src="<?php echo $imgFolder ?>google_reviews.png" style='max-width: 130px'>
					</div>
				</div>
				<?php endif ?>				

				<?php if ($yp != '' && filter_var($yp, FILTER_VALIDATE_URL)): ?>
				<div class='uk-flex uk-flex-center uk-margin-small-top uk-margin-small-bottom'>
					<div class='uk-card uk-card-default uk-box-shadow-medium uk-width-1-1 uk-flex uk-flex-middle uk-flex-center uk-text-center uk-card-hover uk-padding-small hand uk-border-rounded' id='yp-review-card' data-uri='<?php echo $yp ?>'>
						<img src="<?php echo $imgFolder ?>569638-67512a35728137d3e31ed740e666683e.jpg" style='max-width: 130px'>
					</div>
				</div>
				<?php endif ?>

				<?php if ($fbLink != ''): ?>
				<div class='uk-flex uk-flex-center uk-margin-small-top uk-margin-small-bottom'>
					<div class='uk-card uk-card-default uk-box-shadow-medium uk-width-1-1 uk-flex uk-flex-middle uk-flex-center uk-text-center uk-card-hover uk-padding-small hand uk-border-rounded' id='fb-review-card' data-uri='<?php echo $placeIdLink ?>'>
						<img src="<?php echo $imgFolder ?>facebook_pixel.png" style='max-width: 130px'>
					</div>
				</div>
				<?php endif ?>

				<?php if ($bbbLink != ''): ?>
				<div class='uk-flex uk-flex-center uk-margin-small-top uk-margin-small-bottom'>
					<div class='uk-card uk-card-default uk-box-shadow-medium uk-width-1-1 uk-flex uk-flex-middle uk-flex-center uk-text-center uk-card-hover uk-padding-small hand uk-border-rounded' id='bbb-review-card' data-uri='<?php echo $placeIdLink ?>'>
						<img src="<?php echo $imgFolder ?>bbb.png" style='max-width: 250px'>
					</div>
				</div>
				<?php endif ?>

			</div>
		</div>
	</div>

	<div id='google-review' class='uk-hidden'>
		<div class='uk-flex uk-flex-middle uk-flex-center uk-padding-small uk-margin-small-bottom uk-box-shadow-small'>
			<img src="<?php echo $imgFolder ?>google_reviews.png" style='max-width: 200px'>
		</div>
		<div uk-grid>
			<div class='uk-width-2-3 prettify'>
				<div class='uk-padding-small'>
					<p>Use your Google account to post a review and read other users' reviews</p>
					<p>As easy as clicking below and signing in automatically</p>
					<p>When you review us on Google:</p>
					<ul>
					    <li>You share your opinion with others</li>
					    <li>Your feedback is viewed by us and many more people</li>
					    <li>Easy to do</li>
					    <li>It takes less than 1 minute</li>
					</ul>
				</div>
			</div>
			<div class='uk-width-1-3'>
				<img src="<?php echo $imgFolder ?>google_rev.jpg">
			</div>
		</div>
		<div class='uk-text-center'>
			<p class='uk-text-meta uk-margin-small-bottom uk-margin-small-top'>This website is not affiliated with Google</p>
		</div>
		<div class='uk-flex uk-flex-center uk-flex-middle'>
			<input type="button" value="Review us on Google" class='uk-button uk-button-primary uk-border-rounded' data-uri='https://search.google.com/local/writereview?placeid=<?php echo $placeIdLink ?>' onclick='window.open(this.getAttribute("data-uri"))' >
		</div>
	</div>

	<div id='yp-review' class='uk-hidden'>
		<div class='uk-flex uk-flex-middle uk-flex-center uk-padding-small uk-margin-small-bottom uk-box-shadow-small'>
			<img src="<?php echo $imgFolder ?>569638-67512a35728137d3e31ed740e666683e.jpg" style='max-width: 200px'>
		</div>
		<div uk-grid>
			<div class='uk-width-2-3 prettify'>
				<div class='uk-padding-small'>
					<p>Review us on America's number one business directory</p>
					<p>As easy as clicking below and signing in automatically</p>
					<p>YelloPages is one of the oldest America's businesses directories</p>
					<p>A business listed on Yellow Pages is a business that clearly cares about its reputation</p>
				</div>
			</div>
			<div class='uk-width-1-3 uk-flex-middle uk-flex'>
				<img src="<?php echo $imgFolder ?>ypins.png">
			</div>
		</div>
		<div class='uk-text-center'>
			<p class='uk-text-meta uk-margin-small-bottom uk-margin-small-top'>This website is not affiliated with YP</p>
		</div>
		<div class='uk-flex uk-flex-center uk-flex-middle'>
			<input type="button" value="Review us on Yellow Pages" class='uk-button uk-button-primary uk-border-rounded yp-btn' data-uri='<?php echo $yp ?>' onclick='window.open(this.getAttribute("data-uri"))' >
		</div>
	</div>

	<div id='bbb-review' class='uk-hidden'>
		<div class='uk-flex uk-flex-middle uk-flex-center uk-padding-small uk-margin-small-bottom uk-box-shadow-small'>
			<img src="<?php echo $imgFolder ?>bbb.png" style='max-width: 200px'>
		</div>
		<div uk-grid>
			<div class='uk-width-2-3 prettify'>
				<div class='uk-padding-small'>
					<p>As easy as clicking below and signing in automatically</p>
					<p>Better Business Bureau leaves a professional looking review</p>
					<p>A business listed on BBB is a business that clearly cares about its reputation</p>
				</div>
			</div>
			<div class='uk-width-1-3 uk-flex-middle uk-flex'>
				<img src="<?php echo $imgFolder ?>bbb-review.png">
			</div>
		</div>
		<div class='uk-text-center'>
			<p class='uk-text-meta uk-margin-small-bottom uk-margin-small-top'>This website is not affiliated with BBB</p>
		</div>
		<div class='uk-flex uk-flex-center uk-flex-middle'>
			<input type="button" value="Review us on Yellow Pages" class='uk-button uk-button-primary uk-border-rounded' data-uri='<?php echo $bbbLink ?>' onclick='window.open(this.getAttribute("data-uri"))' style='background:#035A78'>
		</div>
	</div>

	<div id='yelp-review' class='uk-hidden'>
		<div class='uk-flex uk-flex-middle uk-flex-center uk-padding-small uk-margin-small-bottom uk-box-shadow-small'>
			<img src="<?php echo $imgFolder ?>yelp.png">
		</div>
		<div uk-grid>
			<div class='uk-width-2-3 prettify'>
				<div class='uk-padding-small'>
					<p>Use your Yelp account to post a review and read other users' reviews</p>
					<p>As easy as clicking below and signing in automatically</p>
					<p>When you review us on Yelp:</p>
					<ul>
						<li>You can review us using your Facebook account</li>
					    <li>See what others have to say</li>
					    <li>Easy to do</li>
					    <li>It takes less than 2 minutes</li>
					</ul>
				</div>
			</div>
			<div class='uk-width-1-3'>
				<img src="<?php echo $imgFolder ?>yelp_reviews.jpg" style='max-width: 200px'>
			</div>
		</div>
		<div class='uk-text-center'>
			<p class='uk-text-meta uk-margin-small-bottom uk-margin-small-top'>This website is not affiliated with Yelp</p>
		</div>
		<div class='uk-flex uk-flex-center uk-flex-middle'>
			<input type="button" value="Review us on Yelp" class='uk-button uk-button-danger uk-border-rounded' data-uri='<?php echo $businessYelpURL; ?>' id='bbb-button' onclick='window.open(this.getAttribute("data-uri"))'>
		</div>
	</div>

	<div id='facebook-review' class='uk-hidden'>
		<div class='uk-flex uk-flex-middle uk-flex-center uk-padding-small uk-margin-small-bottom uk-box-shadow-small'>
			<img src="<?php echo $imgFolder ?>facebook_pixel.png" style='max-width: 230px'>
		</div>
		<div uk-grid>
			<div class='uk-width-2-3 prettify'>
				<div class='uk-padding-small'>
					<p>Use your Facebook account to post a review and read other users' reviews</p>
					<p>As easy as clicking below and signing in automatically</p>
					<p>When you review us on Facebook:</p>
					<ul>
						<li>You can review us using your Facebook account</li>
					    <li>See what others have to say</li>
					    <li>Easy to do</li>
					    <li>It takes less than 2 minutes</li>
					</ul>
				</div>
			</div>
			<div class='uk-width-1-3'>
				<img src="<?php echo $imgFolder ?>facebook-review.png" style='max-width: 200px'>
			</div>
		</div>
		<div class='uk-text-center'>
			<p class='uk-text-meta uk-margin-small-bottom uk-margin-small-top'>This website is not affiliated with Facebook</p>
		</div>
		<div class='uk-flex uk-flex-center uk-flex-middle'>
			<input type="button" value="Review us on Facebook" class='uk-button uk-button-primary uk-border-rounded' data-uri='<?php echo $fbLink; ?>' id='facebook-button' onclick='window.open(this.getAttribute("data-uri"))'>
		</div>
	</div>
</body>
</html>