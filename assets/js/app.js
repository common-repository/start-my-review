document.addEventListener('DOMContentLoaded', function() {
    //click on yelp or google review
    $('#yelp-review-card, #google-review-card, #yp-review-card, #fb-review-card, #bbb-review-card').click(function(e) {
        if ($(this).get(0).id == 'yelp-review-card') {
            $('#yelp-review').removeClass('uk-hidden')
        } else if ($(this).get(0).id == 'google-review-card') {
            $('#google-review').removeClass('uk-hidden')
        } else if ($(this).get(0).id == 'yp-review-card') {
            $('#yp-review').removeClass('uk-hidden')
        } else if ($(this).get(0).id == 'fb-review-card') {
            $('#facebook-review').removeClass('uk-hidden')
        } else if ($(this).get(0).id == 'bbb-review-card') {
            $('#bbb-review').removeClass('uk-hidden')
        }
        $('#high-review').addClass('uk-hidden')
    });
    //rating
    $(".rating-div").rateYo({
        normalFill: "#CCCCCC",
        starWidth: '45px',
        fullStar: true,
        onSet: function(r) {
            if (r <= 3) {
                $('#low-review').removeClass('uk-hidden')
                $('#app').addClass('uk-hidden')
            } else {
                if (document.querySelector('#yp-review-card') == null && document.querySelector('#google-review-card') == null && document.querySelector('#yelp-review-card') == null && document.querySelector('#fb-review-card') == null && document.querySelector('#bbb-review-card') == null) {
                    $('#low-review').removeClass('uk-hidden')
                    $('#app').addClass('uk-hidden')
                } else {
                    $('#app').addClass('uk-hidden')
                    $('#high-review').removeClass('uk-hidden')
                    $('#loginFB').removeClass('uk-hidden')
                }
            }
            //add button thing just in case
            document.getElementById('send-button').addEventListener('click', function(e) {
                e.preventDefault()
                var f = document.querySelector('#low-rating-form')
                if (f[0].value !== '' && f[2].value !== f[3].value !== '' && f[3].value.length > 4) {
                    $.post(iframed.ajax_url, {
                        action: 'send_rate',
                        _ajax_nonce: iframed.nonce,
                        ratingGiven: r,
                        sid: iframed.sid,
                        name: f[0].value,
                        phone: f[1].value,
                        email: f[2].value,
                        reviewMessage: f[3].value
                    }, function(d) {
                        $('#low-review').addClass('uk-hidden')
                        $('#low-review-done').removeClass('uk-hidden')
                    });
                } else {
                    alert('Please fill the required fields')
                }
            })
        }
    });
})

function gCaptchaCallback() {
    iframed.captchaVerification()
}