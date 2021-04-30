(function( $ ) {

  jQuery("#sc_form").submit(function(event) {
    /* stop form from submitting normally */
    event.preventDefault();
    
    /* get the action attribute from the form element */
    var url = jQuery( this ).attr( 'action' );
    
    /* Send the data using post */
    jQuery.ajax({
      type: 'POST',
      url: url,
      data: {
        action:   jQuery('#sc_action').val(),
        home:     jQuery('#home').val(), 
        siteurl:  jQuery('#siteurl').val(), 
        api_url:  jQuery('#api_url').val(), 
        nonce:    jQuery('#sc_nonce_field').val()
      },
      success: function (data, textStatus, XMLHttpRequest) {
        //alert(data);

        var timeleft = 3;
        var downloadTimer = setInterval(function(){
        timeleft--;
        jQuery("#message").text(timeleft);
          if(timeleft <= 0){
            jQuery("#message").text(data).show();
            clearInterval(downloadTimer);
          }
        },1000);
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {
          //alert(errorThrown);
          jQuery("#message").text(data).show();

      }
    });
});

})( jQuery );
