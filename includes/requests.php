<?php

namespace SMReview;

//Block direct access to the file.
if (!defined('ABSPATH')) {
    exit('You are not allowed to access this file.');
}

class StartReviewRequest {

    public static function Process() {
        header('Access-Control-Allow-Origin: *');
        global $wpdb;

        if (isset($_REQUEST["action"])) {
            $action=sanitize_text_field($_REQUEST["action"]);
            if ($action == 'smw_global_reviews') {
                parse_global_reviews();
            } else if ($action == 'review_rate') {
                // header('Content-Type: text/html');
                include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'external_layout' . DIRECTORY_SEPARATOR . 'review_rate.tpl.php';
            } else if ($action == 'send_rate') {
                wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']),'send_rate');
                $wpdb->insert(
                    $wpdb->prefix . 'startmyreview_comments',
                    [
                        'business_id'  => intval($_REQUEST["sid"]),
                        'rating'       => sanitize_text_field($_REQUEST["ratingGiven"]),
                        'name'         => sanitize_text_field($_REQUEST["name"]),
                        'review_email' => sanitize_email($_REQUEST["email"]),
                        'review'       => sanitize_text_field($_REQUEST["reviewMessage"]),
                    ]
                );
            } else if ($action == 'side_comments') {
                // header('Content-Type: text/html');
                include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'external_layout' . DIRECTORY_SEPARATOR . 'side_comments.tpl.php';
            } else if ($action == 'load_more_side_comments') {
                wp_verify_nonce(sanitize_text_field($_REQUEST['_ajax_nonce']),'load_more_side_comments');

                $page             = isset($_REQUEST["page"]) ? intval($_REQUEST["page"]) : 1;
                $sid              = intval($_REQUEST["site_id"]);
                $perpage          = 10;
                $offset           = ($perpage * $page) - $perpage;
                $business_reviews = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->prefix" . "startmyreview_comments where business_id = %d and rating > 2 order by comment_id desc limit $offset, $perpage", [$sid]));
                if ($business_reviews) {
                    foreach ($business_reviews as $comment) {
                        ?>
                     <div class='uk-padding-small uk-padding-remove-bottom'>
                    <div class='uk-card uk-card-default uk-border-rounded <?php if ($comment->comment_url) {
                            echo "hand";
                        }
                        ?> uk-padding-small' <?php if ($comment->comment_url) {
                            echo "onclick='window.open(\"$comment->comment_url\")'";
                        }
                        ?>>
                        <div class='panel-rating'>
                            <?php
for ($i = 0; $i < $comment->rating; $i++) {
                            ?>
                                    <span><img src="<?php echo SMReview_REVIEW_URI . 'assets/images/if_Star_Gold_1398915.png'; ?>" style='max-width: 20px'></span>
                                    <?php
}
                        ?>
                        </div>
                        <div class='panel-review-comment'>
                            <?php echo esc_html($comment->review) ?>
                        </div>
                        <div class='uk-text-meta uk-margin-small-top uk-grid-collapse' uk-grid>
                            <div class='uk-width-1-6 commenter-profile-photo uk-text-center'>
                                <?php if ($comment->profile_photo): ?>
                                    <img src="<?php echo esc_html($comment->profile_photo) ?>" class='uk-border-rounded'>
                                <?php else: ?>
                                    <img src="<?php echo SMReview_REVIEW_URI . 'assets/images/o.jpg'; ?>" class='uk-border-rounded'>
                                <?php endif?>
                            </div>
                            <div class='uk-width-5-6 uk-flex uk-flex-middle'>
                                <span><?php echo esc_html($comment->name) ?></span>&nbsp;<span>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
}
                }

            }
        }
        wp_die();
    }

    public static function MainFrame() {

        
        header('Access-Control-Allow-Origin: *');
        header('Content-Type: text/javascript');
        global $wpdb;
        $site_id          = isset($_REQUEST["site_id"]) ? intval($_REQUEST["site_id"]) : 0;
        $row              = $wpdb->get_row("SELECT * FROM $wpdb->prefix" . "start_my_review where id = ".intval($_REQUEST["site_id"]));
        
        if(!$row){
            die("Sorry, you are not allowed to access this file.");
        }

        $site_data=json_decode($row->site_data);
        $businessName     = $site_data->business_name;
        $buttonShape      = $site_data->btnBorders;
        $buttonColor      = $site_data->btnColor;
        $buttonBackground = $site_data->btnBg;
        $buttonPosition   = $site_data->btnPos;
        $reviewsPosition   = $site_data->reviewsPos;
        $buttonsOpacity   = $site_data->btnsOpacity;

        echo str_replace(['[SITE_DOMAIN]', '[SITE_ID]', '[SITE_REQUEST_URI]', '[BUSINESS_NAME]', '[BUTTON_SHAPE]', '[BUTTON_COLOR]', '[BUTTON_BACKGROUND]', '[BUTTON_POSITION]', '[REVIEWS_POSITION]', '[BUTTONS_OPACITY]'], [get_bloginfo('url'), $site_id, admin_url('admin-ajax.php'), $businessName, $buttonShape, $buttonColor, $buttonBackground, $buttonPosition, $reviewsPosition, $buttonsOpacity], file_get_contents(dirname(__DIR__) . '/assets/js/embed.js'));
        wp_die();
    }
}
