<?php
$businesses = $wpdb->get_results($wpdb->prepare('SELECT * from ' . $wpdb->prefix . 'start_my_review where site_owner = %d', $user_id));
?>

<div uk-grid class='uk-grid-divider uk-child-width-1-2@m uk-child-width-1-1@s a'>
	<div>
		<h6 class='uk-margin-small-bottom uk-text-center'>Select Business</h6>
		<select class='uk-select' id='businesses-list'>
			<option disabled selected>Select Business</option>
			<?php
			foreach ($businesses as $business) {	
				$business_data = json_decode($business->site_data, true);    
				echo "<option data-bbb='$business_data[bbb_link]' data-borders='$business_data[btnBorders]' data-color='$business_data[btnColor]' data-btnbg='$business_data[btnBg]' data-fb='$business_data[fb_link]' data-site='$business->site_domain' data-id='$business->id' data-yelp='$business_data[yelp_link]' data-placeid='$business_data[placeId]' data-logo='$business_data[logo]' data-name='$business_data[business_name]' data-yp='$business_data[yp_link]' data-greviews='$business_data[greviews]' data-pos='$business_data[btnPos]' data-reviews-pos='$business_data[reviewsPos]'>$business_data[business_name]</option>";
			}
			?>
		</select>
		<input type="hidden" name="biz-id">
	</div>
	<div>
		<h6 class='uk-margin-small-bottom uk-text-center'>Add new business</h6>
		<button type="button" class='uk-border-rounded uk-button uk-button-primary uk-width-1-1' id='new-biz'>New Business</button>
	</div>
</div>

<div style='display: none' id='biz-info'>
	<div>
		<h6 class='uk-margin-small-top uk-margin-remove-bottom'>Business Name</h6>
		<input type="text" id='biz-name' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-1-3@m' >
	</div>

	<div>
		<h6 class='uk-margin-small-top uk-margin-remove-bottom'>Business Website</h6>
		<input type="text" id='biz-website' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-2-3@m' >
	</div>

	<div>
		<h6 class='uk-margin-small-top uk-margin-remove-bottom'>Yellow Pages URL</h6>
		<input type="text" id='biz-yp' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-1-1@m' >
	</div>

	<div>
		<h6 class='uk-margin-small-top uk-margin-remove-bottom'>Yelp Link</h6>
		<input type="text" id='biz-yelp' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-2-3@m' >
	</div>

	<div>
		<h6 class='uk-margin-small-top uk-margin-remove-bottom'>Better Business Bureau</h6>
		<input type="text" id='biz-bbb' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-2-3@m' >
	</div>

	<div>
		<h6 class='uk-margin-small-top uk-margin-remove-bottom'>Facebook Business Page Link</h6>
		<input type="text" id='biz-facebook' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-2-3@m' >
	</div>

	<div>
		<h6 class='uk-margin-small-top uk-margin-remove-bottom'>Google Place ID <span uk-icon="question"></span>
			<div uk-dropdown>
				<ul class="uk-nav uk-dropdown-nav">
					<p>In order to obtain your Google Place ID please go to <a target="_new" href="https://developers.google.com/places/place-id">Google Place ID</a> and obtain your Google Place ID by typing the location of your business</p>
					<p>If you do not have a Google Place ID please <a target="_new" href="https://business.google.com/create">Register</a> at <a target="_new" href="https://business.google.com/create">Google Businesses</a></p>
					<p>Once registered please provide the business ID of your place, it should be something like <i>ChIJzUiIeiEZTIYRdMoinnysxcg</i></p>
					<p><img src="<?php echo SMReview_REVIEW_URI ?>/assets/images/placeid.png"></p>
				</ul>
			</div>
		</h6>
		<input type="text" id='biz-placeId' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-2-5@m' >
	</div>

	<div>
    <h6 class='uk-margin-small-top uk-margin-remove-bottom'>Google Reviews
    <span uk-icon="question"></span>
			<div uk-dropdown>
				<ul class="uk-nav uk-dropdown-nav">
					<p>In order to show your Google Business reviews please go to <a target="_new" href="https://www.google.com/maps">Google Maps</a> find your business location in there and click on "Share"</p>
					<p>Then copy your link to share and paste it in here, it should be something similar to https://goo.gl/maps/YoUrIdGoesHere</p>
					<p>It's important you paste this properly</p>
					<div uk-grid>
						<div class='uk-width-1-2'>
							<img src="<?php echo SMReview_REVIEW_URI ?>assets/images/smrinst1.png" alt="First step">
						</div>
						<div class='uk-width-1-2'>
							<img src="<?php echo SMReview_REVIEW_URI ?>assets/images/smrinst2.png" alt="Second step">
						</div>
					</div>
				</ul>
			</div>
	</h6>
    <input type="text" id='biz-greviews' class='defaul-inputs uk-padding-small uk-border-rounded uk-box-shadow-medium uk-width-2-3@m' >
  </div>

	<div class='uk-margin-small-top'>
		<input type="file" id='biz-filepicker' class='uk-hidden' accept="image/*" >
		<input id='biz-logo-picker' type="submit" value='Pick Logo' class='uk-button uk-button-primary uk-border-rounded uk-box-shadow-medium uk-width-1-3@m' >
		<div class='business-logo-preview uk-padding-small uk-padding-remove-horizontal'>
			<img id='biz-logo' class='hand'>
		</div>
	</div>
	<hr class='uk-divider-icon'>

	<div id='button-preview-container' class='uk-hidden'>
		<div class='uk-margin-small uk-margin-medium-bottom'>
			<div class='uk-flex uk-flex-center'>
				<div class='uk-margin-small-right'>
					<div>
						<p>Button Font Color</p>
						<input type="text" id='review-btn-font' hidden="">
					</div>
				</div>
				<div class='uk-margin-small-right'>
					<div>
						<p>Button Background Color</p>
						<input type="text" id='review-bg-font' hidden="">
					</div>
				</div>
			</div>

			<div class='uk-text-center uk-flex-middle uk-margin-medium-top'>
				<label><span class='uk-text-lead'>Squared</span> <input type="checkbox" class="js-switch" id='btn-borders'/> <span class='uk-text-lead'>Rounded</span></label>	
			</div>

			<div class='uk-text-center uk-margin'>
				<div id='review-btn-preview' class='uk-margin-auto'>
					Review Me
				</div>
			</div>

		</div>

		<input type="hidden" id='button-data-set' data-background='#32c985' data-color='#ffffff'>

		<div id='button-position-container'>
		<div class='uk-margin-small uk-margin-medium-bottom'>			

			<div class='uk-text-center uk-margin'>
				<div class='uk-margin-auto'>
					Choose the button's position
				</div>
			</div>

			<div class='uk-text-center uk-flex-middle uk-margin-medium-top'>
				<label><span class='uk-text-lead'>Left</span> <input type="checkbox" class="js-switch" id='btn-pos'/> <span class='uk-text-lead'>Right</span></label>	
			</div>

		</div>

		<input type="hidden" id='button-data-set' data-background='#32c985' data-color='#ffffff'>
		
		<div id='button-position-container'>
			<div class='uk-margin-small uk-margin-medium-bottom'>			

				<div class='uk-text-center uk-margin'>
					<div class='uk-margin-auto'>
						<b><h4>Choose the "Read Reviews" tab's position</h4></b>
					</div>
				</div>
				<div class='uk-text-center uk-flex-middle'>
					<label><span class='uk-text-lead'>Left</span> <input type="checkbox" class="js-switch" id='readreviews-pos' /> <span class='uk-text-lead'>Right</span></label>	
				</div>

			</div></div>

	</div>

	</div>

	<div class='uk-text-meta review-code-tag uk-margin-large-top'>
		<span>Use the following tag and insert it into your site's head tag</span>

		<textarea readonly="readonly" class='uk-textarea uk-height-small uk-margin-small-top' wrap="on" cols='60' rows='8' id='bizGeneratedCode' style='height: 50px !important;resize:none'></textarea>
		<span class='uk-margin-small-top'>Send the following code to your clients and allow them to write a direct review on your business</span>
		<textarea readonly="readonly" class='uk-textarea uk-height-small uk-margin-small-top' wrap="on" cols='60' rows='8' id='reviewMeGeneratedCode' style='height: 50px !important;resize:none'></textarea>
	</div>
	<div class='save-cancel uk-margin-medium-top'>
		<input type="submit" name="save" value="Save" class='uk-button uk-border-rounded uk-button-primary' id='save-biz'>
		<input type="submit" name="cancel" value="cancel" class='uk-button uk-border-rounded' id='cancel-biz'>
		<input type="submit" name="Delete" value="Delete" class='uk-button uk-border-rounded uk-button-danger uk-hidden' id='delete-biz'>
	</div>
</div>