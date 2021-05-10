// rps_reacting_love_ajax_action
jQuery(document).ready(function(){
    jQuery('.rct-love').click(function(){
        var post_id = jQuery(this).data('id');
        var user_name = jQuery(this).data('uname');
        var love_val = jQuery(this).val();
        jQuery.ajax({
            url : rps_ajax_object.ajax_url,
            type : 'post',
            data : {
                action : 'reacting_love_ajax_action',
                pid : post_id,
                uname : user_name,
                lvval : love_val,
            },
            success : function( msg ){
                jQuery('#ajax-responce').html(msg);
            }
        })
    });
});

// rps_reacting_like_ajax_action
jQuery(document).ready(function(){
    jQuery('.rct-like').click(function(){
        var post_id = jQuery(this).data('id');
        var user_name = jQuery(this).data('uname');
        var like_val = jQuery(this).val();
        jQuery.ajax({
            url : rps_ajax_object.ajax_url,
            type : 'post',
            data : {
                action : 'reacting_like_ajax_action',
                pid : post_id,
                uname : user_name,
                lkval : like_val,
            },
            success : function( msg ){
                jQuery('#ajax-responce').html(msg);
            }
        })
    });
});

// rps_reacting_ok_ajax_action
jQuery(document).ready(function(){
    jQuery('.rct-ok').click(function(){
        var post_id = jQuery(this).data('id');
        var user_name = jQuery(this).data('uname');
        var ok_val = jQuery(this).val();
        jQuery.ajax({
            url : rps_ajax_object.ajax_url,
            type : 'post',
            data : {
                action : 'reacting_ok_ajax_action',
                pid : post_id,
                uname : user_name,
                okval : ok_val,
            },
            success : function( msg ){
                jQuery('#ajax-responce').html(msg);
            }
        })
    });
});

// rps_reacting_dislike_ajax_action
jQuery(document).ready(function(){
    jQuery('.rct-dislike').click(function(){
        var post_id = jQuery(this).data('id');
        var user_name = jQuery(this).data('uname');
        var dislike_val = jQuery(this).val();
        jQuery.ajax({
            url : rps_ajax_object.ajax_url,
            type : 'post',
            data : {
                action : 'reacting_dislike_ajax_action',
                pid : post_id,
                uname : user_name,
                dlval : dislike_val,
            },
            success : function( msg ){
                jQuery('#ajax-responce').html(msg);
            }
        })
    });
});

// rps_reacting_hate_ajax_action
jQuery(document).ready(function(){
    jQuery('.rct-hate').click(function(){
        var post_id = jQuery(this).data('id');
        var user_name = jQuery(this).data('uname');
        var hate_val = jQuery(this).val();
        jQuery.ajax({
            url : rps_ajax_object.ajax_url,
            type : 'post',
            data : {
                action : 'reacting_hate_ajax_action',
                pid : post_id,
                uname : user_name,
                hval : hate_val,
            },
            success : function( msg ){
                jQuery('#ajax-responce').html(msg);
            }
        })
    });
});