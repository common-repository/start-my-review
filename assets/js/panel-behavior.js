(function($) {
    "use strict";
    $(document).ready(function() {
        //login authentication
        $('#smr_login_btn').click(function(event) {
            $('#smr_auth_email,#smr_auth_passwd').attr('disabled', true)
            $(this).attr('disabled', true)
            $.post(app.ajaxurl, {
                action: 'smr_authenticate',
                _ajax_nonce: app.nonce,
                email: $('#smr_auth_email').val(),
                passwd: $('#smr_auth_passwd').val()
            }, function(d) {
                console.log(d)
                if (d == 'null') {
                    $('#smr_auth_email,#smr_auth_passwd').addClass('uk-form-danger')
                    UIkit.modal.dialog('<div class="uk-padding-small">Invalid credentials</div>')
                } else if (d == 'success') {
                    UIkit.modal.dialog('<div class="uk-padding-small">Correct Login, reloading...</div>')
                    $('#smr_auth_email,#smr_auth_passwd').addClass('uk-form-success')
                    window.location.reload()
                } else {
                    UIkit.modal.dialog('<div class="uk-padding-small">There was an error</div>')
                }
                $('#smr_login_btn').removeAttr('disabled')
                $('#smr_auth_email,#smr_auth_passwd').removeAttr('disabled')
                setTimeout(function() {
                    UIkit.modal('.uk-modal').hide();
                }, 3000)
            });
        });
        //Add change div behavior
        $('.il>li, .db').click(function(e) {
            $('.il>li, .db').removeClass('active-element')
            var d = $(this).attr('data-binding')
            $('[data-binding="' + d + '"]').addClass('active-element')
            $('.he').addClass('uk-hidden')
            $('#' + d).removeClass('uk-hidden') //.css('visibility', 'visible');
        });
        //button colors
        jQuery('#review-btn-font, #review-bg-font').iris({
            hide: false,
            palettes: true,
            change: function(event, ui) {
                if (event.target.id == 'review-btn-font') {
                    //btn color change
                    $('#review-btn-preview').css('color', ui.color.toString());
                    $('#button-data-set').attr('data-color', ui.color.toString())
                } else if (event.target.id == 'review-bg-font') {
                    //bg change
                    $('#review-btn-preview').css('background', ui.color.toString());
                    $('#button-data-set').attr('data-background', ui.color.toString())
                }
            }
        });
        //switchery options
        //Switchery options
        var switches = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));
        switches.forEach(function(de) {
            var switchery = new Switchery(de, {
                color: '#0F7AE5'
            });
        });
        //change button look
        $('#btn-borders').change(function(event) {
            if ($(this).is(':checked')) {
                $('#review-btn-preview').css('border-radius', '50px');
            } else {
                $('#review-btn-preview').css('border-radius', '0');
            }
        });
        //delete review
        interact('.review-delete-comment').on('tap', function(event) {
            event.preventDefault();
            UIkit.modal.dialog("<div class='uk-padding-small'><div class='uk-margin-small uk-text-meta uk-text-center'>Delete review?</div><div class='uk-flex uk-flex-center'><input type='button' class='uk-button uk-button-danger' value='Delete' id='delete-review-action' data-id='" + event.currentTarget.getAttribute('data-id') + "'><input type='button' id='delete-cancel-action' class='uk-button uk-button-default' value='Cancel'></div></div>")
            $('#delete-cancel-action').click(function(event) {
                UIkit.modal('.uk-modal').hide();
            });
            $('#delete-review-action').click(function() {
                $.post(app.ajaxurl, {
                    action: 'remove_reviews',
                    _ajax_nonce: app.nonce,
                    id: event.currentTarget.getAttribute('data-id')
                }, function(d) {
                    console.log(d)
                    $('[data-review-container="' + event.currentTarget.getAttribute('data-id') + '"]').remove()
                });
                UIkit.modal('.uk-modal').hide();
            });
        });
        //reply review
        interact('.review-message-user').on('tap', function(event) {
            UIkit.modal.dialog("<div class='uk-padding-small'><div><p class='uk-margin-remove-bottom'>Message Subject</p><input type='text' id='message-subject' class='uk-input'><p class='uk-margin-remove-bottom'>Message:</p><textarea id='message-to-reviewer' class='uk-textarea uk-width-1-1 uk-height-small'></textarea></div><div class='uk-margin-medium-top'><input type='submit' class='uk-button uk-button-primary' id='smr-send-message' value='Send'><input type='submit' class='uk-button uk-button-default' id='smr-cancel-message' value='Cancel'></div></div>")
            $('#smr-send-message').click(function() {
                if ($('#message-subject').val() == '' || $('#message-to-reviewer').val() == '') {
                    alert('Please verify the fields')
                    return;
                }
                $.post(app.ajaxurl, {
                    action: 'smr_send_message',
                    _ajax_nonce: app.nonce,
                    email: event.currentTarget.getAttribute('data-email'),
                    subject: $('#message-subject').val(),
                    message: $('#message-to-reviewer').val()
                }, function(d) {
                    console.log(d)
                });
                UIkit.modal('.uk-modal').hide();
            });
            $('#smr-cancel-message').click(function() {
                UIkit.modal('.uk-modal').hide();
            });
        });
        $('#smr-check-update').click(function() {
            $('#smr-check-update').attr('disabled', 'disabled').addClass('uk-button-disabled')
            $.post(app.ajaxurl, {
                action: 'smr_update',
                _ajax_nonce: app.nonce
            }, function(d) {
                console.log(d)
                var r = JSON.parse(d)
                if (r.message == 'success') {
                    if (r.version == $('#smr-store-version').val()) {
                        $('#newer-version-notification').html('Latest version is <b>' + r.version + '</b>, you have the latest version')
                        return
                    } else if (r.version > $('#smr-store-version').val()) {
                        $('#newer-version-notification').html('There is a newer version, please click on update to update to ' + r.version)
                        $('#smr-do-update').removeAttr('hidden');
                        $('#smr-check-update').attr('hidden', true)
                    }
                } else {
                    $('#newer-version-notification').text('Looks like you are using the latest version of the plugin')
                }
            });
        });
        $('#smr-do-update').click(function(event) {
            $(this).attr('disabled', 'disabled').addClass('uk-button-disabled')
            $('#newer-version-notification').text('WordPress is upgrading to a newer version, this page will reload when the update is completed')
            $.post(app.ajaxurl, {
                action: 'smr_upgrade',
                _ajax_nonce: app.nonce
            }, function(d) {
                console.log(d)
                window.location.reload()
            });
        });
        /*===========================================
        =            Business Users only            =
        ===========================================*/
        jQuery('#review-btn-font').iris('color', jQuery('#button-data-set').attr('data-color'));
        jQuery('#review-bg-font').iris('color', jQuery('#button-data-set').attr('data-background'));
        if ($('#button-data-set').attr('data-borders') == 'false') {
            $('#review-btn-preview').css('border-radius', '0');
        } else if ($('#button-data-set').attr('data-borders') == 'true') {
            $('#review-btn-preview').css('border-radius', '50px');
        }
        /*=====  End of Business Users only  ======*/
    });
})(jQuery);