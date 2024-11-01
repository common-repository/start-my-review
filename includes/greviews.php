<?php

namespace SMReview;
class GoogleBusiness {

    const API_URL = 'http://reviews.startmyreview.com:8661/?site=';

    const PARSE_URL = 'http://reviews.startmyreview.com:8661/stored_reviews/?id=';

    public static function get_reviews($gBusinessLink = null) {

        if ($gBusinessLink == null) {
            return null;
        }

        if (is_string($gBusinessLink) and preg_match('/https:\/\/goo.gl\/maps/', $gBusinessLink) and preg_match('/[a-zA-Z0-9]{1,}/i', @array_pop(explode('/', $gBusinessLink)), $match)) {
            $reviews = json_decode(file_get_contents(self::PARSE_URL . $match[0]), true);
            if ($reviews['status'] == 'success') {
                //obtener reseñas ya obtenidas
                return $reviews;
            } else {
                //no existe pedir que se obtengan las reseñas de google
                $result = wp_remote_retrieve_body(wp_remote_get(API_URL . $gBusinessLink));
                return $result;
            }
        }
    }

    public static function save_reviews($reviews, $business_id) {
        global $wpdb;

        if ($reviews == null) {
            return;
        }

        $external_id = $reviews['place'];

        $reviews = $reviews['reviews'];

        foreach ($reviews as $review) {
            $commentExists = $wpdb->get_row($wpdb->prepare('SELECT external_id FROM ' . $wpdb->prefix . 'startmyreview_comments where external_id = %s', $external_id . $review['image']));

            if (!$commentExists) {
                $wpdb->insert(
                    $wpdb->prefix . 'startmyreview_comments',
                    [
                        'business_id'   => sanitize_text_field($business_id),
                        'rating'        => sanitize_text_field($review['rating']),
                        'external_id'   => sanitize_text_field($external_id . $review['image']),
                        'profile_photo' => sanitize_text_field($review['image']),
                        'name'          => sanitize_text_field($review['person']),
                        'review'        => sanitize_text_field($review['comment']),
                        'comment_url'   => sanitize_text_field('https://goo.gl/maps/' . $external_id),
                    ]
                );
            }
        }
    }
}
