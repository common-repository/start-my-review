<?php

$sid              = intval($_REQUEST["site_id"]);
$perpage          = 10;
$page             = intval($_REQUEST["page"]);
$offset           = ($perpage * $page) - $perpage;
$business_reviews = $wpdb->get_results($wpdb->prepare("SELECT * FROM $wpdb->prefix" . "startmyreview_comments where business_id = %d and rating > 2 order by comment_id desc limit $offset, $perpage", [$sid]));

$imgFolder = SMReview_REVIEW_URI . 'assets/images/';
$ajaxUrl   = admin_url('admin-ajax.php');
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    
    <?php wp_head(); ?>

    <title>Reviews</title>
</head>
<body class='uk-margin-xlarge-bottom'>

<script type="text/javascript" charset="utf-8">
    var ajaxurl = "<?php echo $ajaxUrl ?>";
    var site_id = <?php echo intval($_REQUEST["site_id"]) ?>
</script>
<?php

$totalComments = $wpdb->get_row("SELECT count(*) as total from " . $wpdb->prefix . "startmyreview_comments where business_id = $sid");
if ($totalComments) {
    $totalComments = $totalComments->total;
}

echo "<div id='side-reviews-comments-embed'>";
if ($business_reviews) {
    foreach ($business_reviews as $comment) {
        ?>
     <div class='uk-padding-small uk-padding-remove-bottom'>
    <div class='uk-card uk-card-default uk-border-rounded <?php if ($comment->comment_url) echo "hand"; ?> uk-padding-small' <?php if ($comment->comment_url) echo "onclick='window.open(\"$comment->comment_url\")'"; ?>>
        <div class='panel-rating'>
            <?php for ($i = 0; $i < $comment->rating; $i++) { ?>
                <span><img src="<?php echo SMReview_REVIEW_URI . 'assets/images/if_Star_Gold_1398915.png'; ?>" style='max-width: 20px'></span>
            <?php } ?>
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
                <span>&nbsp;<?php echo esc_html($comment->name) ?></span>&nbsp;<span>
            </div>
        </div>

    </div>
</div>
<?php
}
} else {
    ?>
    <div class='uk-text-center uk-text-lead uk-flex-middle uk-flex uk-height-large'>
        <span>No reviews yet, be the first one!</span>
    </div>
    <?php
}
echo "</div>";
if ($totalComments > 10) {
    echo '<input type="button" value="Load more Reviews" class="uk-border-rounded uk-margin-small-top uk-button uk-button-primary uk-margin-xlarge-bottom uk-margin-auto uk-display-block" page="2">';
}

?>
<script>
    (function (){
        $('input').click(function (e) {
            $.post(ajaxurl, {
                action: 'load_more_side_comments',
                _ajax_nonce: '<?php echo wp_create_nonce('load_more_side_comments') ?>',
                page: $('input').attr('page'),
                site_id: site_id
            }, function(data, textStatus, xhr) {
                if(xhr.responseText == ''){
                    $("input").remove()
                }else{
                    $('#side-reviews-comments-embed').append(xhr.responseText)
                }
            });
            $('input').attr('page', Number($('input').attr('page'))+1)
        });
    })();
</script>
<div class='uk-text-center'>
    <a href="https://startmyreview.com" target='_new' title="Powered by StartMyReview" class='uk-link-muted'>Powered by StartMyReview</a>
</div>
</body>
</html>