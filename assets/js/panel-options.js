(function($) {
    $(document).ready(function() {
        $('#grabreviews').click(function(e) {
            e.currentTarget.classList.add('uk-button-default', 'uk-disabled')
            e.currentTarget.classList.remove('uk-button-primary')
            e.currentTarget.setAttribute('disabled', true)
            Toastify({
                text: "Getting reviews",
                duration: 999999,
                gravity: 'bottom',
                backgroundColor: "#0F7AE5",
                className: "asuP updating-reviews-toast",
            }).showToast();
            $.get(app.baseurl + '/wp-json/smr/grabreviews', function(data) {
                e.currentTarget.classList.remove('uk-button-default', 'uk-disabled')
                e.currentTarget.classList.add('uk-button-primary')
                e.currentTarget.removeAttribute('disabled')
                document.querySelector('.updating-reviews-toast').remove()
                window.location.reload()
            });
        });
        $('#biz-logo-picker, #biz-logo').click(function(e) {
            $('#biz-filepicker').click();
        });
        $('#new-biz').click(function(e) {
            $('#assign-owner-select').val($(this).attr('data-uid'))
            $('#button-preview-container, #assign-owner').removeClass('uk-hidden')
            $('#biz-name').val('').removeAttr('disabled')
            $('#biz-website').val('').removeAttr('disabled')
            $('#biz-yp').val('').removeAttr('disabled')
            $('#biz-yelp').val('').removeAttr('disabled')
            $('#biz-placeId').val('').removeAttr('disabled')
            $('#biz-facebook').val('').removeAttr('disabled')
            $('#biz-bbb').val('').removeAttr('disabled')
            $('#biz-filepicker').removeAttr('disabled')
            $('#biz-greviews').removeAttr('disabled')
            $('#businesses-list').get(0).selectedIndex = 0
            $('#biz-info').show('fast');
            $('#biz-logo').get(0).src = defLog
            $('#biz-name, #biz-website, #biz-yelp, #biz-placeId, #biz-facebook, #biz-greviews').val('')
            $('#save-biz').attr('data-mode', 'new')
            $('#biz-filepicker').removeAttr('disabled')
            $('#save-biz').val('save')
            $('#biz-name').focus()
            $('#bizGeneratedCode, #reviewMeGeneratedCode, .review-code-tag>span').addClass('uk-hidden')
            $('.ctsc').removeClass('uk-hidden')
        });
        $('#biz-filepicker').change(function(e) {
            var fileReader = new FileReader()
            fileReader.onload = function() {
                document.getElementById('biz-logo').src = fileReader.result
            }
            fileReader.readAsDataURL(e.target.files[0])
        });
        //save business
        $('#save-biz').click(function(e) {
            if ($('#biz-name').get(0).value.length == 0) {
                alert('You cannot have an empty business name')
                return
            }
            if ($(this).attr('data-mode') == 'new') {
                /*Create toast*/
                Toastify({
                    text: "Updating",
                    duration: 999999,
                    gravity: 'bottom',
                    backgroundColor: "#0F7AE5",
                    className: "asuP",
                }).showToast();
                $.post(app.ajaxurl, {
                    action: 'panel',
                    _ajax_nonce: app.nonce,
                    bizName: $('#biz-name').val(),
                    bizWebsite: $('#biz-website').val(),
                    bizYelp: $('#biz-yelp').val(),
                    bizYp: $('#biz-yp').val(),
                    bizFb: $('#biz-facebook').val(),
                    bizBbb: $('#biz-bbb').val(),
                    placeId: $('#biz-placeId').val(),
                    greviews: $('#biz-greviews').val(),
                    btnBorders: $('#btn-borders').is(':checked'),
                    btnPos: $('#btn-pos').is(':checked'),
                    reviewsPos: $('#readreviews-pos').is(':checked'),
                    btnsOpacity: $('#btns-opacity').val(),
                    btnBg: $('#button-data-set').attr('data-background'),
                    btnColor: $('#button-data-set').attr('data-color'),
                    logo: document.getElementById('biz-logo').src,
                    mode: $('#save-biz').attr('data-mode'),
                    id: $('#businesses-list option:selected').attr('data-id'),
                    assignedOwner: $('#assign-owner-select option:selected').val()
                }, function(d) {
                    console.log(d.responseText)
                    window.location.reload()
                });
            } else if ($(this).attr('data-mode') == 'edit') {
                $(this).val('Save')
                $('#biz-name').removeAttr('disabled')
                $('#biz-website').removeAttr('disabled')
                $('#biz-yelp').removeAttr('disabled')
                $('#biz-facebook, #biz-bbb').removeAttr('disabled')
                $('#biz-yp').removeAttr('disabled')
                $('#biz-placeId').removeAttr('disabled')
                $('#biz-greviews').removeAttr('disabled')
                $('#biz-filepicker').removeAttr('disabled')
                $(this).attr('data-mode', 'update')
                $('#delete-biz,#button-preview-container, #assign-owner').removeClass('uk-hidden')
            } else if ($(this).attr('data-mode') == 'update') {
                /*Create toast*/
                Toastify({
                    text: "Updating",
                    duration: 999999,
                    gravity: 'bottom',
                    backgroundColor: "#0F7AE5",
                    className: "asuP",
                }).showToast();
                $('#delete-biz,#button-preview-container, #assign-owner').addClass('uk-hidden')
                $.post(app.ajaxurl, {
                    action: 'panel',
                    _ajax_nonce: app.nonce,
                    bizName: $('#biz-name').val(),
                    bizWebsite: $('#biz-website').val(),
                    bizYelp: $('#biz-yelp').val(),
                    bizYp: $('#biz-yp').val(),
                    bizFb: $('#biz-facebook').val(),
                    bizBbb: $('#biz-bbb').val(),
                    placeId: $('#biz-placeId').val(),
                    greviews: $('#biz-greviews').val(),
                    btnBorders: $('#btn-borders').is(':checked'),
                    btnPos: $('#btn-pos').is(':checked'),
                    reviewsPos: $('#readreviews-pos').is(':checked'),
                    btnsOpacity: $('#btns-opacity').val(),
                    btnBg: $('#button-data-set').attr('data-background'),
                    btnColor: $('#button-data-set').attr('data-color'),
                    logo: document.getElementById('biz-logo').src,
                    mode: $('#save-biz').attr('data-mode'),
                    id: $('#businesses-list option:selected').attr('data-id'),
                    assignedOwner: $('#assign-owner-select option:selected').val()
                }, function(d) {
                    window.location.reload()
                    console.log(d)
                });
                $(this).attr('data-mode', 'edit')
                $(this).val('Edit')
                $('#biz-name').attr('disabled', 'disabled')
                $('#biz-yp').attr('disabled', 'disabled')
                $('#biz-facebook, #biz-bbb').attr('disabled', 'disabled')
                $('#biz-website').attr('disabled', 'disabled')
                $('#biz-yelp').attr('disabled', 'disabled')
                $('#biz-placeId').attr('disabled', 'disabled')
                $('#biz-greviews').attr('disabled', 'disabled')
                $('#biz-filepicker').attr('disabled', 'disabled')
            }
        });
        $('#delete-biz').click(function(e) {
            $.post(app.ajaxurl, {
                action: 'panel',
                id: $(this).attr('data-id'),
                mode: 'delete'
            }, function() {
                window.location.reload()
            });
        });
        //business select
        $('#businesses-list').change(function(e) {
            $('#review-btn-font').iris('color', $(this).find('option:selected').attr('data-color'));
            $('#review-bg-font').iris('color', $(this).find('option:selected').attr('data-btnbg'));
            //determine button borders
            if ($(this).find('option:selected').attr('data-borders') == 'false') {
                $('#review-btn-preview').css('border-radius', '0');
            } else if ($(this).find('option:selected').attr('data-borders') == 'true') {
                $('#review-btn-preview').css('border-radius', '50px');
                $('#btn-borders').trigger("click")
            }
            if ($(this).find('option:selected').attr('data-pos') == 'true') {
                $('#btn-pos').trigger("click")
            } else if ($('#btn-pos').is(':checked') && $(this).find('option:selected').attr('data-pos') == 'false') {
                $('#btn-pos').trigger("click")
            }
            if ($(this).find('option:selected').attr('data-reviews-pos') == 'true') {
                $('#readreviews-pos').trigger("click")
            } else if ($('#readreviews-pos').is(':checked') && $(this).find('option:selected').attr('data-reviews-pos') == 'false') {
                $('#readreviews-pos').trigger("click")
            }
            //rest
            $('#delete-biz').addClass('uk-hidden')
            $('#biz-name').val($(this).find('option:selected').attr('data-name')).attr('disabled', 'disabled')
            $('#biz-yp').val($(this).find('option:selected').attr('data-yp')).attr('disabled', 'disabled')
            $('#biz-website').val($(this).find('option:selected').attr('data-site')).attr('disabled', 'disabled')
            $('#biz-yelp').val($(this).find('option:selected').attr('data-yelp')).attr('disabled', 'disabled')
            $('#biz-placeId').val($(this).find('option:selected').attr('data-placeid')).attr('disabled', 'disabled')
            $('#biz-facebook').val($(this).find('option:selected').attr('data-fb')).attr('disabled', 'disabled')
            $('#biz-bbb').val($(this).find('option:selected').attr('data-bbb')).attr('disabled', 'disabled')
            $('#biz-greviews').val($(this).find('option:selected').attr('data-greviews')).attr('disabled', 'disabled')
            $('#biz-filepicker').attr('disabled', 'disabled')
            document.getElementById('biz-logo').src = $(this).find('option:selected').attr('data-logo')
            $('#biz-info').show('fast');
            $('#save-biz').val('Edit')
            $('#save-biz').attr('data-mode', 'edit')
            $('#delete-biz').attr('data-id', $(this).find('option:selected').attr('data-id'))
            $('#bizGeneratedCode').text("<script src='" + app.ajaxurl + "?action=review_main_frame&site_id=" + $(this).find('option:selected').attr('data-id') + "' type='text/javascript' charset='utf-8' async defer></script>")
            $('#reviewMeGeneratedCode').text(app.ajaxurl + "?action=review_rate&site_id=" + $(this).find('option:selected').attr('data-id'))
            $('#bizGeneratedCode, #reviewMeGeneratedCode, .review-code-tag>span').removeClass('uk-hidden')
            $('.ctsc').addClass('uk-hidden')
            $('#assign-owner-select').val($(this).find('option:selected').attr('data-owner'))
        });
        //cancel editing or adding
        $('#cancel-biz').click(function(e) {
            $('#biz-info').hide('fast');
            $('#button-preview-container, #assign-owner').addClass('uk-hidden')
            $('#businesses-list').get(0).selectedIndex = 0
        });
        //load more local reviews
        $('#load-more-panel-reviews').click(function(e) {
            $.post(app.ajaxurl, {
                action: 'load_more_panel_reviews',
                _ajax_nonce: app.nonce,
                page: $('#load-more-panel-reviews').attr('data-page')
            }, function(d) {
                if (d !== '') {
                    $('#panel-reviews-div').append(d)
                    $('#load-more-panel-reviews').attr('data-page', Number($('#load-more-panel-reviews').attr('data-page')) + 1)
                } else {
                    $('#load-more-panel-reviews').remove()
                }
            });
        });
    });
    var defLog = 'data:image/png;base64,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'
})(jQuery);