(function() {
    window.data = {
        sid: [SITE_ID],
        domain: '[SITE_DOMAIN]',
        requestUri: '[SITE_REQUEST_URI]',
        businessName: '[BUSINESS_NAME]',
        buttonShape: '[BUTTON_SHAPE]',
        buttonBackground: '[BUTTON_BACKGROUND]',
        buttonColor: '[BUTTON_COLOR]',
        buttonPosition: '[BUTTON_POSITION]',
        reviewsPosition: '[REVIEWS_POSITION]',
        btnsOpacity: '[BUTTONS_OPACITY]'
    }
    if (!parseInt(data.sid)) return;
    siteId = console.log('This site uses Start My Review to dynamically load reviews visit us at ' + data.domain);
    var r = document.createElement('div'),
        m = document.createElement('div'),
        rT = document.createTextNode('Review us'),
        s = document.createElement('link'),
        head = document.querySelector('head'),
        vexCss = document.createElement('link'),
        vexTheme = document.createElement('link'),
        vexJs = document.createElement('script')

    r.style.background = data.buttonBackground
    r.style.color = data.buttonColor
    if (data.buttonShape == 'false') {
        r.style.borderRadius = '0px'
    } else {
        r.style.borderRadius = '50px'
    }
    if (data.btnsOpacity) {
        r.style.opacity = data.btnsOpacity;
    }
    m.id = 'modal-iframe'
    r.classList.add('smr-review-clickable-button')
    r.appendChild(rT)
    vex.defaultOptions.className = 'vex-theme-wireframe'
    r.addEventListener('click', function(e) {
        var i = document.createElement('iframe')
        i.src = data.requestUri + '?action=review_rate&site_id=' + data.sid
        //i.setAttribute('scrolling', 'no')
        i.id = 'embedRating'
        i.style.display = 'none'
        i.style.height = 'inherit'
        i.onload = function() {
            console.log('loaded');
            i.style.display = 'inherit'
            loadingOverlay.remove()
        }
        vex.open('Start my review')
        var vexContent = document.querySelector('.vex-content')
        vexContent.style.height = '100%'
        //create loading overlay
        var loadingOverlay = document.createElement('div')
        loadingOverlay.className = 'loadingOverlay'
        vexContent.innerText = null
        vexContent.appendChild(loadingOverlay, vexContent.firstChild)
        vexContent.insertBefore(i, vexContent.firstChild)
        var vexClose = document.createElement('div')
        vexClose.className = 'vex-close'
        vexContent.appendChild(vexClose)
        vexClose.addEventListener('click', function() {
            vex.closeAll()
        })
    })
    //add view
    var av = document.createElement('link')
    av.setAttribute('rel', 'stylesheet')
    av.setAttribute("type", "text/css")
    av.setAttribute('href', data.requestUri + '?action=count_view&sid=' + data.sid)
    //create side reviews loader
    var sideButton = document.createElement('div'),
        sideIframe = document.createElement('iframe'),
        sideDiv = document.createElement('div'),
        sideCloseButton = document.createElement('div'),
        sideDivHeader = document.createElement('div'),
        sideNameHolder = document.createElement('div'),
        sideName = document.createTextNode('Reviews for ' + data.businessName)
    sideNameHolder.className = 'side-div-business-name'
    sideNameHolder.appendChild(sideName)
    sideDivHeader.appendChild(sideNameHolder)
    sideButton.innerText = 'Read our Reviews'
    sideButton.className = 'sideButton'
    sideButton.style.background = data.buttonBackground
    sideButton.style.color = data.buttonColor
    if (data.buttonShape == 'false') {
        sideButton.style.borderRadius = '0px'
    } else {
        sideButton.style.borderRadius = '50px'
    }
    if (data.btnsOpacity) {
        sideButton.style.opacity = data.btnsOpacity;
    }
    //place button to the left
    if (data.buttonPosition == 'false') {
        r.classList.add('l')
    } else {
        r.classList.add('r')
    }
    //place read reviews to the left
    if (data.reviewsPosition == 'false') {
        sideButton.classList.add('l')
    } else {
        sideButton.classList.add('r')
    }
    sideDiv.className = 'side-reviews'
    sideDiv.style.display = 'none'
    sideDiv.id = 'side-reviews-smr'
    sideDivHeader.className = 'side-reviews-header'
    sideDiv.appendChild(sideDivHeader)
    sideDivHeader.appendChild(sideCloseButton)
    sideCloseButton.className = 'side-reviews-close-action hand'
    sideButton.addEventListener('click', function(e) {
        var ld = document.createElement('div')
        sideDiv.style.display = 'inherit'
        ld.className = 'loadingOverlay'
        sideDiv.appendChild(ld)
        sideIframe.src = data.requestUri + '?action=side_comments&page=1&site_id=' + data.sid
        sideDiv.appendChild(sideIframe)
        sideIframe.onload = function() {
            sideIframe.style.height = '100%'
            ld.remove()
        }
    })
    sideCloseButton.addEventListener('click', function(e) {
        sideDiv.style.display = 'none'
    })
    document.addEventListener('DOMContentLoaded', function() {
        document.body.appendChild(r)
        document.body.appendChild(av)
        document.body.appendChild(sideDiv)
        document.body.appendChild(sideButton)
    });
    try {
        document.body.onload = function() {
            document.body.appendChild(r)
            document.body.appendChild(av)
            document.body.appendChild(sideDiv)
            document.body.appendChild(sideButton)
        }
    } catch (e) {}
})();