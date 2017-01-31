jQuery(function($) {
    "use strict";


// ouibounce($('#ouibounce-modal')[0], {
//   // Uncomment the line below if you want the modal to appear every time
//   // More options here: https://github.com/carlsednaoui/ouibounce
//   aggressive: true,
//   sitewide: true,
//   callback: function() { console.log('Ouibounce fired!'); }
// });

// $("#js-optin-submit").click(function(event) {
//   event.preventDefault();

//   $(this).val('Subscribing...').prop('disabled');

//   var data = {
//     'action': 'process_optin_submission',
//     'nonce': window.OuibounceVars.nonce,
//     'email': $('#js-optin-email').val()
//   };

//   $.post(window.OuibounceVars.ajaxUrl, data, function(response) {
//     console.log('Server returned:', response);

//     // Handle the response (take care of error reporting!)
//     $('#js-optin-step1').hide().next('#js-optin-step2').show();
//   });

// });

// $('.js-optin-close').on('click', function(event) {
//   event.preventDefault();
//   $('#js-optin-wrap').hide();
// });


    // if you want to use the 'fire' or 'disable' fn,
    // you need to save OuiBounce to an object
    var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {

        aggressive: wpeiVars.opt_is_agressive,
        timer: wpeiVars.opt_timer,
        delay: wpeiVars.opt_delay,
        callback: function() {
            console.log('ouibounce fired!');
            console.log(wpeiVars);
            $('body').addClass('modal-open');

            // I can show the Bootstrap modal instead
            // $('#myModalSteps').modal('show'); 
        }
    });

    $('body').on('click', function() {
        $('#ouibounce-modal').hide();
        $('body').removeClass('modal-open');
    });
    $('#ouibounce-modal .wpei-modal-footer').on('click', function() {
        $('#ouibounce-modal').hide();
        $('body').removeClass('modal-open');
    });
    $('#ouibounce-modal .wpei-modal').on('click', function(e) {
        e.stopPropagation();
    });

});