<?php

namespace SMReview;

class YP {

    public static function get_id($url) {
        $url = parse_url($url);
        if (isset($url['query'])) {
            return @end(explode('-', @end(explode('/', $url['path']))));
        }
    }

    public static function get_reviews($bizId) {
        return wp_remote_retrieve_body(wp_remote_get("http://reviews.startmyreview.com/crawler.php?yellowpage=$bizId"));
    }

    public static function insert_reviews($reviews, $business_id) {
        global $wpdb;

        if (!$reviews) {
            return;
        }

        foreach ($reviews as $r) {

            $repeatCheck = $wpdb->get_row($wpdb->prepare("SELECT * FROM $wpdb->prefix" . "startmyreview_comments where external_id = %s", md5($r['reviewBody'])));

            if (!$repeatCheck) {
                $wpdb->insert(
                    $wpdb->prefix . 'startmyreview_comments',
                    [
                        'business_id' => $business_id,
                        'rating'      => $r['rating'],
                        'name'        => $r['reviewer'],
                        'external_id' => md5($r['reviewBody']),
                        'review'      => $r['reviewBody'],
                    ]
                );
            }
        }
    }
}
