<?php

namespace SMReview;

//Block direct access to the file.
if (!defined('ABSPATH')) {
    exit('You are not allowed to access this file.');
}

class Yelp
{

    /**
     * https://www.yelp.com/developers/v3/manage_app
     * Yelp's personal account API Key
     *
     * @var string
     */
    private $api_key = null;
    private $info;

    public static function get_id($url)
    {
        $url = parse_url($url);
        if (isset($url['path'])) {
            return str_ireplace('biz/', '', trim($url['path'], '/'));
        }
        return false;
    }

    public static function get_reviews($id)
    {
        return wp_remote_retrieve_body(wp_remote_get("http://reviews.startmyreview.com/crawler.php?yelp=$id"));
    }

    public static function save_reviews($reviews, $business_id = null)
    {
        global $wpdb;
        $reviews = @json_decode($reviews)->reviews;
        if (!is_array($reviews)) {
            return;
        }
        foreach ($reviews as $review) {
            $commentExists = $wpdb->get_row($wpdb->prepare('SELECT external_id FROM ' . $wpdb->prefix . 'startmyreview_comments where external_id = %s', $review->id));
            if (!$commentExists) {
                $wpdb->insert(
                    $wpdb->prefix . 'startmyreview_comments',
                    [
                        'business_id'   => sanitize_text_field($business_id),
                        'rating'        => sanitize_text_field($review->rating),
                        'external_id'   => sanitize_text_field($review->id),
                        'profile_photo' => sanitize_text_field($review->user->image_url),
                        'name'          => sanitize_text_field($review->user->name),
                        'review'        => sanitize_text_field($review->text),
                        'comment_url'   => sanitize_text_field($review->url),
                    ]
                );
            }
        }
    }
}
