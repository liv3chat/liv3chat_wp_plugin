jQuery(function() {

    /* This flag will prevent multiple comment submits: */
    var working = false;
    
    /* Listening for the submit event of the form: */
    jQuery('.jak-ajaxform').submit(function(e){

        e.preventDefault();
        if(working) return false;
        
        working = true;
        var jakform = jQuery(this);
        var button = jQuery(this).find('.jak-submit');
        var buttontxt = jQuery(button).val();
        jQuery(jakform).find('#signup-help, #username-help').html("");
        
        jQuery(button).val('checking...');
        
    
    
    });

    jQuery("[name=jaklc_account]").click(function(){
        jQuery('#jakweblc_have, #jakweblc_nohave').fadeToggle();
    });

    jQuery("[name=always_display]").click(function(){
        jQuery('.single_options').fadeToggle();
    });

});