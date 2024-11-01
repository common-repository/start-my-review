<?php
$businesses = $wpdb->get_results($wpdb->prepare('SELECT * from ' . $wpdb->prefix . 'start_my_review where site_owner = %d order by id desc', $user_id));
?>

<div class='uk-child-width-1-2@m uk-child-width-1-1 uk-padding-small' uk-grid id='panel-reviews-div'>

	<div class='uk-width-1-1 uk-margin-bottom'>
		<center><button id='grabreviews' type="submit" class="uk-first-column uk-display-block uk-width-1-1 uk-button uk-button-primary uk-border-rounded">Update Reviews</button></center>
	</div>

	<?php
	$bizIds = array();
	if ($haveBusinesses) {
		foreach ($businesses as $biz) {
			$bizIds[] = (int) $biz->id;
		}

		$totalComments = $wpdb->get_row("SELECT count(*) as total from " . $wpdb->prefix . "startmyreview_comments where business_id in (" . implode(',', $bizIds) . ")");


		if ($totalComments->total > 0) {		

		$user_id    = get_current_user_id();
        $businesses = $wpdb->get_results($wpdb->prepare('SELECT * from ' . $wpdb->prefix . 'start_my_review where site_owner = %d', $user_id));

        foreach ($businesses as $biz) {
            $bizIds[] = (int) $biz->id;
        }

        $perpage = 10;
        $page    = 1;
        $offset  = ($perpage * $page) - $perpage;

        $reviews = $wpdb->get_results("SELECT * from " . $wpdb->prefix . "startmyreview_comments where business_id in (" . implode(',', $bizIds) . ") order by comment_id desc limit $offset, $perpage");

			foreach ($reviews as $comment) {
				?>
				<div data-review-container='<?php echo $comment->comment_id ?>'>
					<div class='uk-card uk-card-default uk-border-rounded uk-padding-small'>
						<div class='panel-rating'>
							<?php
							for ($i = 0; $i < $comment->rating; $i++) {
								?>
								<span><img src="<?php echo SMReview_REVIEW_URI . 'assets/images/if_Star_Gold_1398915.png'; ?>"></span>
								<?php
							}
							?>
						</div>
						<div class='panel-review-comment'>
							<?php echo $comment->review ?>
						</div>
						<div class='uk-text-meta uk-margin-small-top uk-grid-collapse' uk-grid>
							<div class='uk-width-1-6 commenter-profile-photo uk-text-center'>
								<?php if ($comment->profile_photo): ?>
									<img src="<?php echo $comment->profile_photo ?>" class='uk-border-rounded'>
									<?php else: ?>
										<img src="<?php echo SMReview_REVIEW_URI . 'assets/images/o.jpg'; ?>" class='uk-border-rounded'>
									<?php endif?>
								</div>
								<div class='uk-width-5-6 uk-flex uk-flex-middle'>
									<span><?php echo $comment->name ?></span>&nbsp;<span> on <?php SMReview\StartMyReview::get_business_name($comment->business_id)?></span>
								</div>
							</div>
							<div class='uk-flex uk-flex-right'>
								<?php if ($comment->rating < 4 && !$comment->comment_url): ?>
									<span data-email='<?php echo $comment->review_email ?>' uk-icon='mail' class='hand review-message-user' uk-tooltip='title:Message User'></span>
								<?php endif ?>
								<span uk-icon='trash' class='hand review-delete-comment' data-id='<?php echo $comment->comment_id ?>' uk-tooltip="title:Delete Comment"></span>
								<?php if ($comment->comment_url) {
									echo "<span uk-icon='link' class='hand' uk-tooltip='title:View Comment' onclick='window.open(\"$comment->comment_url\")'></span>";
								}
								?>
							</div>
						</div>
					</div>
					<?php
				}
			}else{
				?>
				<div class='uk-width-1-1'>
					<h5>Sometimes comments can take a while to appear on the system while we parse it from different sites, please be patient, comments will appear here automatically.</h5>
				</div>	
				<?php	
			}
		} else {
			?>
			<div class='uk-width-1-1'>
				<h5>Businesses need to be added in order to appear in here, please add a business.</h5>
			</div>
			<?php
		}
		?>
	</div>
	<?php
	if ($totalComments->total > 10) {
		echo "<div class='uk-text-center'><input type='button' class='uk-button uk-button-primary uk-margin-auto uk-border-rounded' value='Load more reviews' data-page='2' id='load-more-panel-reviews'></div>";
	}
	?>