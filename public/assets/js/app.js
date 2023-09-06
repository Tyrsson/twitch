(($) => {
    'use strict'
    // $.subscribe('system/message', function(type, message, c) {
    //     let alert = '<div class="alert alert-' + type + ' alert-dismissible" role="alert"><div>' + message + '</div></div>';
    //     $('#system-message').html(alert);
    //     $('#system-message-modal').modal('show');
    // });
    // Ajax the main navigation, uncomment this to ajaxify the site
    // $('ul.nav li a').on('click', function(event) {
    //     //alert('found');
    //     event.preventDefault();
    //     // goTo is the target, the clicked link
    //     let goTo = $(this);
    //     let get  = $.ajax({
    //         url: goTo.attr('href'), // use the links href to request the page
    //         dataType: 'html',
    //         method: 'get'
    //     });
    //     get.done(function(response, textStatus,jqXHR) {
    //         // only after the deffered is resolved do we try to update the DOM
    //         $('#app-workspace').html(response);
    //         // if were here we did not have a 403, 404, 500
    //         // If this was not ajaxed we would've navigated away from this tab, it can not stay in an active state
    //         let previous = $('ul.nav li a.active');
    //         // remove its state
    //         previous.removeClass('active');
    //         // set the clicked link as active
    //         goTo.addClass('active');
    //     });
    //     //console.log('cartId', cartId);
    // });
    // attach a .on to the app-workspace so we can listen for the submit
    // $('#app-workspace').on('submit', function(event) {
    //     event.preventDefault();
    //     let form    = $(event.target);
    //     let href    = $(form).attr('action');
    //     let domTrgt = $(form).attr('id');
    //     let d       = $(form).serialize();
    //     let p       = $(form).attr('method');
    //     let request = $.ajax({
    //         url: href,
    //         method: p,
    //         data: d
    //     });
    //     request.done(function(response, textStatus, jqXHR) {
    //         $('#' + domTrgt).html(response);
    //     });
    //     request.fail(function() {
    //     });
    //     request.always(function() {
    //         //console.log(request.getResponseHeader('systemMessage'));
    //         if (request.getResponseHeader('successMessage') !== null) {
    //             $.publish(
    //                 'system/message',
    //                 ['success', request.getResponseHeader('successMessage')]
    //             );
    //         } else if (request.getResponseHeader('exceptionMessage') !== null) {
    //             $.publish(
    //                 'system/message',
    //                 ['danger', request.getResponseHeader('exceptionMessage')]
    //             );
    //         }
    //     });
    // });
})(jQuery);