<?php
// add reacting btn in the posts using filter
add_filter( 'the_content', 'add_reacting_data' );
function add_reacting_data($content) {
	global $wpdb;
	$table_name = $wpdb->prefix . "rps_reacting_system";
	$post_id = get_the_ID();
	$count_reacting = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id=$post_id AND ( reacting_love_count = 1 OR reacting_like_count = 1 OR reacting_ok_count = 1  OR reacting_dislike_count = 1 OR reacting_hate_count = 1 )" );
    $love_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_love_count = 1" );
    $like_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_like_count = 1" );
    $ok_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_ok_count = 1" );
    $dislike_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_dislike_count = 1" );
    $hate_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_hate_count = 1" );
    $lchecked = '';
    $lkchecked = '';
    $okchecked = '';
    $dkchecked = '';
    $hchecked = '';
    if ( $love_count == 1 ) {
        $lchecked =  'checked';
    }
    if ( $like_count == 1 ) {
        $lkchecked =  'checked';
    }
    if ( $ok_count == 1 ) {
        $okchecked =  'checked';
    }
    if ( $dislike_count == 1 ) {
        $dkchecked =  'checked';
    }
    if ( $hate_count == 1 ) {
        $hchecked =  'checked';
    }
	$content .= "<center>This post has been reacting <strong>".$count_reacting."</strong> time(s).</center>";
	$content .= '<div id="ajax-responce"></div>';
	$content .= '<div class="rating">';
	$content .= '<input type="radio" '.$lchecked.' value="1" data-id="'.get_the_ID().'" data-uname="'.get_current_user().'" class="rct-love" id="rct-love">';
	$content .= '<label for="rct-love">';
	$content .= '<img src="https://image.flaticon.com/icons/svg/1933/1933691.svg" alt="Loved it" width="120" height="120">';
	$content .= '<span>Loved it</span>';
	$content .= '</label>';
	$content .= '<input type="radio" '.$lkchecked.' value="1" data-id="'.get_the_ID().'" data-uname="'.get_current_user().'" class="rct-like" id="rct-like">';
	$content .=	'<label for="rct-like">';
	$content .= '<img src="https://image.flaticon.com/icons/svg/1933/1933646.svg" alt="Liked it" width="120" height="120">';
	$content .= '<span>Liked it</span>';
	$content .= '</label>';
	$content .= '<input type="radio" '.$okchecked.' value="1" data-id="'.get_the_ID().'" data-uname="'.get_current_user().'" class="rct-ok" id="rct-ok">';
	$content .= '<label for="rct-ok">';
	$content .= '<img src="https://image.flaticon.com/icons/svg/1933/1933511.svg" alt="It OK" width="120" height="120">';
	$content .= '<span>It OK</span>';
	$content .= '</label>';
	$content .= '<input type="radio" '.$dkchecked.' value="1" data-id="'.get_the_ID().'" data-uname="'.get_current_user().'" class="rct-dislike" id="rct-dislike">';
	$content .= '<label for="rct-dislike">';
	$content .= '<img src="https://image.flaticon.com/icons/svg/1933/1933115.svg" alt="Disliked it" width="120" height="120">';
	$content .= '<span>Disliked it</span>';
	$content .= '</label>';
	$content .= '<input type="radio" '.$hchecked.' value="1" data-id="'.get_the_ID().'" data-uname="'.get_current_user().'" class="rct-hate" id="rct-hate">';
	$content .= '<label for="rct-hate">';
	$content .= '<img src="https://image.flaticon.com/icons/svg/1933/1933127.svg" alt="Hated it" width="120" height="120">';
	$content .= '<span>Hated it</span>';
	$content .= '</label>';
	$content .= '</div>';
	return $content;
}

// rps_reacting_love_ajax_action
add_action( 'wp_ajax_reacting_love_ajax_action', 'rps_reacting_love_ajax_action' );
add_action( 'wp_ajax_nopriv_reacting_love_ajax_action', 'rps_reacting_love_ajax_action' );
function rps_reacting_love_ajax_action() {
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$table_name = $wpdb->prefix . "rps_reacting_system";
	$user_name = $_POST['uname'];
	$post_id = $_POST['pid'];
	$love_val = $_POST['lvval'];
	if ( isset($user_name) && isset($post_id) ) {
		$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
		if ( $check_like > 0 ) {
			echo "You already love this post";
		}
		else {
			$wpdb->insert(
				''.$table_name.'',
				array(
					'user_name' => $_POST['uname'],
					'post_id' => $post_id,
					'reacting_love_count' => $love_val,
				),
				array(
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
				)
			);
		}
		if ( $wpdb->insert_id ) {
			echo "Thank You for loving this post";
		}
	}
	wp_die();
}

// rps_reacting_like_ajax_action
add_action( 'wp_ajax_reacting_like_ajax_action', 'rps_reacting_like_ajax_action' );
add_action( 'wp_ajax_nopriv_reacting_like_ajax_action', 'rps_reacting_like_ajax_action' );
function rps_reacting_like_ajax_action() {
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$table_name = $wpdb->prefix . "rps_reacting_system";
	$user_name = $_POST['uname'];
	$post_id = $_POST['pid'];
	$like_val = $_POST['lkval'];
	if ( isset($user_name) && isset($post_id) ) {
		$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
		if ( $check_like > 0 ) {
			echo "You already like this post";
		}
		else {
			$wpdb->insert(
				''.$table_name.'',
				array(
					'user_name' => $_POST['uname'],
					'post_id' => $post_id,
					'reacting_like_count' => $like_val,
				),
				array(
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
				)
			);
		}
		if ( $wpdb->insert_id ) {
			echo "Thank You for like this post";
		}
	}
	wp_die();
}

// rps_reacting_ok_ajax_action
add_action( 'wp_ajax_reacting_ok_ajax_action', 'rps_reacting_ok_ajax_action' );
add_action( 'wp_ajax_nopriv_reacting_ok_ajax_action', 'rps_reacting_ok_ajax_action' );
function rps_reacting_ok_ajax_action() {
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$table_name = $wpdb->prefix . "rps_reacting_system";
	$user_name = $_POST['uname'];
	$post_id = $_POST['pid'];
	$ok_val = $_POST['okval'];
	if ( isset($user_name) && isset($post_id) ) {
		$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
		if ( $check_like > 0 ) {
			echo "You already give your postive feedback on this post.";
		}
		else {
			$wpdb->insert(
				''.$table_name.'',
				array(
					'user_name' => $_POST['uname'],
					'post_id' => $post_id,
					'reacting_ok_count' => $ok_val,
				),
				array(
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
				)
			);
		}
		if($wpdb->insert_id){
			echo "Thank You for giving the postive fedback on this post.";
		}
	}
	wp_die();
}

// rps_reacting_dislike_ajax_action
add_action( 'wp_ajax_reacting_dislike_ajax_action', 'rps_reacting_dislike_ajax_action' );
add_action( 'wp_ajax_nopriv_reacting_dislike_ajax_action', 'rps_reacting_dislike_ajax_action' );
function rps_reacting_dislike_ajax_action() {
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$table_name = $wpdb->prefix . "rps_reacting_system";
	$user_name = $_POST['uname'];
	$post_id = $_POST['pid'];
	$dislike_val = $_POST['dlval'];
	if ( isset($user_name) && isset($post_id) ) {
		$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
		if ( $check_like > 0 ) {
			echo "You already dislike this post.";
		}
		else {
			$wpdb->insert(
				''.$table_name.'',
				array(
					'user_name' => $_POST['uname'],
					'post_id' => $post_id,
					'reacting_dislike_count' => $dislike_val,
				),
				array(
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
				)
			);
		}
		if ( $wpdb->insert_id ) {
			echo "Thank You for dislike our post.";
		}
	}
	wp_die();
}

// rps_reacting_hate_ajax_action
add_action( 'wp_ajax_reacting_hate_ajax_action', 'rps_reacting_hate_ajax_action' );
add_action( 'wp_ajax_nopriv_hate_dislike_ajax_action', 'rps_reacting_hate_ajax_action' );
function rps_reacting_hate_ajax_action() {
	global $wpdb;
	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	$table_name = $wpdb->prefix . "rps_reacting_system";
	$user_name = $_POST['uname'];
	$post_id = $_POST['pid'];
	$hate_val = $_POST['hval'];
	if ( isset($user_name) && isset($post_id) ) {
		$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
		if ( $check_like > 0 ) {
			echo "You already hate this post";
		}
		else {
			$wpdb->insert(
				''.$table_name.'',
				array(
					'user_name' => $_POST['uname'],
					'post_id' => $post_id,
					'reacting_hate_count' => $hate_val,
				),
				array(
					'%s',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
					'%d',
				)
			);
		}
		if ( $wpdb->insert_id ) {
			echo "Thank You for hate our post";
		}
	}
	wp_die();
}