<?php
/**
 * Class responsible for the RPS.
 *
 * @author    WP Square
 * @package   reacting-post-system
 */

/**
 * Class for RPS.
 */
class RPS {
	/**
	 * add reacting btn in the posts using filter
	 *
	 * @since 1.0.0
	 */
	public function add_reacting_data($content) {
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
		$content .= "<center>".__( 'This post has been reacting <strong>'.$count_reacting.'</strong> time(s).', 'RPS' )."</center>";
		$content .= '<div id="ajax-responce"></div>';
		$content .= '<div class="rating">';
		$content .= '<input type="radio" '.$lchecked.' value="1" data-id="'.get_the_ID().'" data-uname="'.get_current_user().'" data-rcount="'.$count_reacting.'" class="rct-love" id="rct-love">';
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

	/**
	 * Constructor.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		add_filter( 'the_content', array( $this, 'add_reacting_data' ) );
		add_action( 'wp_ajax_reacting_love_ajax_action', array( $this, 'rps_reacting_love_ajax_action' ) );
		add_action( 'wp_ajax_nopriv_reacting_love_ajax_action', array( $this, 'rps_reacting_love_ajax_action' ) );
		add_action( 'wp_ajax_reacting_like_ajax_action', array( $this, 'rps_reacting_like_ajax_action' ) );
		add_action( 'wp_ajax_nopriv_reacting_like_ajax_action', array( $this, 'rps_reacting_like_ajax_action' ) );
		add_action( 'wp_ajax_reacting_ok_ajax_action', array( $this, 'rps_reacting_ok_ajax_action' ) );
		add_action( 'wp_ajax_nopriv_reacting_ok_ajax_action', array( $this, 'rps_reacting_ok_ajax_action' ) );
		add_action( 'wp_ajax_reacting_dislike_ajax_action', array( $this, 'rps_reacting_dislike_ajax_action' ) );
		add_action( 'wp_ajax_nopriv_reacting_dislike_ajax_action', array( $this, 'rps_reacting_dislike_ajax_action' ) );
		add_action( 'wp_ajax_reacting_hate_ajax_action',  array( $this, 'rps_reacting_hate_ajax_action' ) );
		add_action( 'wp_ajax_nopriv_reacting_hate_ajax_action', array( $this, 'rps_reacting_hate_ajax_action' ) );
		add_action( 'add_meta_boxes', array( $this, 'rps_post_meta' ) );
		add_filter( 'manage_page_posts_columns', array ( $this, 'rps_filter_posts_pages_columns' ) );
		add_filter( 'manage_post_posts_columns', array ( $this, 'rps_filter_posts_pages_columns' ) );
		add_action( 'manage_page_posts_custom_column', array( $this, 'rps_page_post_column' ), 10, 2);
		add_action( 'manage_post_posts_custom_column', array( $this, 'rps_page_post_column' ), 10, 2);
	}

	/**
	 * rps_reacting_love_ajax_action
	 *
	 * @since 1.0.0
	 */
	public function rps_reacting_love_ajax_action() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_name = $wpdb->prefix . "rps_reacting_system";
		$user_name = $_POST['uname'];
		$post_id = $_POST['pid'];
		$love_val = $_POST['lvval'];
		if ( isset($user_name) && isset($post_id) ) {
			$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
			if ( $check_like > 0 ) {
				echo "<center>".__( 'You already love this post.', 'RPS' )."</center>";
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
				echo "<center>".__( 'Thank You for loving this post.', 'RPS' )."</center>";
			}
		}
		wp_die();
	}

	/**
	 * rps_reacting_like_ajax_action
	 *
	 * @since 1.0.0
	 */
	public function rps_reacting_like_ajax_action() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_name = $wpdb->prefix . "rps_reacting_system";
		$user_name = $_POST['uname'];
		$post_id = $_POST['pid'];
		$like_val = $_POST['lkval'];
		if ( isset($user_name) && isset($post_id) ) {
			$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
			if ( $check_like > 0 ) {
				echo "<center>".__( 'You already like this post.', 'RPS' )."</center>";
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
				echo "<center>".__( 'Thank You for like this post.', 'RPS' )."</center>";
			}
		}
		wp_die();
	}

	/**
	 * rps_reacting_ok_ajax_action
	 *
	 * @since 1.0.0
	 */
	public function rps_reacting_ok_ajax_action() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_name = $wpdb->prefix . "rps_reacting_system";
		$user_name = $_POST['uname'];
		$post_id = $_POST['pid'];
		$ok_val = $_POST['okval'];
		if ( isset($user_name) && isset($post_id) ) {
			$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
			if ( $check_like > 0 ) {
				echo "<center>".__( 'You already give your postive feedback on this post.', 'RPS' )."</center>";
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
				echo "<center>".__( 'Thank You for giving the postive fedback on this post.', 'RPS' )."</center>";
			}
		}
		wp_die();
	}

	/**
	 * rps_reacting_dislike_ajax_action
	 *
	 * @since 1.0.0
	 */
	public function rps_reacting_dislike_ajax_action() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_name = $wpdb->prefix . "rps_reacting_system";
		$user_name = $_POST['uname'];
		$post_id = $_POST['pid'];
		$dislike_val = $_POST['dlval'];
		if ( isset($user_name) && isset($post_id) ) {
			$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
			if ( $check_like > 0 ) {
				echo "<center>".__( 'You already dislike this post.', 'RPS' )."</center>";
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
				echo "<center>".__( 'Thank You for dislike our post.' , 'RPS' )."</center>";
			}
		}
		wp_die();
	}

	/**
	 * rps_reacting_hate_ajax_action
	 *
	 * @since 1.0.0
	 */
	public function rps_reacting_hate_ajax_action() {
		global $wpdb;
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$table_name = $wpdb->prefix . "rps_reacting_system";
		$user_name = $_POST['uname'];
		$post_id = $_POST['pid'];
		$hate_val = $_POST['hval'];
		if ( isset($user_name) && isset($post_id) ) {
			$check_like = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE user_name='$user_name' AND post_id='$post_id'" );
			if ( $check_like > 0 ) {
				echo "<center>".__( 'You already hate this post.', 'RPS' )."</center>";
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
				echo "<center>".__('Thank You for hate our post', 'RPS')."</center>";
			}
		}
		wp_die();
	}

	/**
	 * Function used for to add meta 
	 *
	 * @since 1.0.0
	 */
	public function rps_post_meta() {
		$post_types = array( 'page', 'post' );
		add_meta_box( 
			'rps-metabox-id', 
			__( 'User Reaction', 'RPS' ), 
			array($this, 'rps_user_reaction'), 
			$post_types, 
			'normal', 
			'high'
		);
	}

	/**
	 * Callback Function of rps_post_meta 
	 *
	 * @since 1.0.0
	 */
	public function rps_user_reaction() {
		add_post_type_support( 'download', 'custom-fields' );
		global $wpdb;
		$table_name = $wpdb->prefix . "rps_reacting_system";
		$post_id = get_the_ID();
		$love_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_love_count = 1" );
		$like_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_like_count = 1" );
		$ok_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_ok_count = 1" );
		$dislike_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_dislike_count = 1" );
		$hate_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_hate_count = 1" );
		?>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>User Rection</th>
					<th>User Count</th>
				</tr>
			</thead>
  			<tbody>
   				<tr>
      				<td><img src="https://image.flaticon.com/icons/svg/1933/1933691.svg" alt="Loved it" width="50" height="50"><span>Loved It</span></td>
      				<td><?php echo $love_count; ?></td>
    			</tr>
				<tr>
      				<td><img src="https://image.flaticon.com/icons/svg/1933/1933646.svg" alt="Liked it" width="50" height="50"><span>Liked it</span></td>
      				<td><?php echo $like_count; ?></td>
    			</tr>
				<tr>
      				<td><img src="https://image.flaticon.com/icons/svg/1933/1933511.svg" alt="It's OK" width="50" height="50"><span>It's OK</span></td>
      				<td><?php echo $ok_count; ?></td>
    			</tr>
				<tr>
      				<td><img src="https://image.flaticon.com/icons/svg/1933/1933115.svg" alt="Disliked it" width="50" height="50"><span>Disliked it</span></td>
      				<td><?php echo $dislike_count; ?></td>
    			</tr>
				<tr>
      				<td><img src="https://image.flaticon.com/icons/svg/1933/1933127.svg" alt="Hated it" width="50" height="50"><span>Hated it</span></td>
      				<td><?php echo $hate_count; ?></td>
    			</tr>
  			</tbody>
		</table>
		<?php
	}
	
	/**
	 * Add a rating Column in post and page
	 *
	 * @since 1.0.0
	 */
	public function rps_filter_posts_pages_columns( $columns ) {
		$columns['like-ratio'] = __( 'Postive Reacting', 'RPS' );
		$columns['dislike-ratio'] = __( 'Negative Reacting', 'RPS' );
		return $columns;
	}

	/**
	 * Adding the rating Column in post and page
	 *
	 * @since 1.0.0
	 */
	public function rps_page_post_column( $column, $post_id ) {
		global $wpdb;
		$table_name = $wpdb->prefix . "rps_reacting_system";
		$count_reacting = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id=$post_id AND ( reacting_love_count = 1 OR reacting_like_count = 1 OR reacting_ok_count = 1  OR reacting_dislike_count = 1 OR reacting_hate_count = 1 )" );
		$love_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_love_count = 1" );
		$like_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_like_count = 1" );
		$ok_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_ok_count = 1" );
		$dislike_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_dislike_count = 1" );
		$hate_count = $wpdb->get_var( "SELECT COUNT(*) FROM $table_name WHERE post_id = $post_id AND reacting_hate_count = 1" );
		$like_prec = $love_count + $like_count + $ok_count;
		$dislike_prec = $dislike_count + $hate_count;
		if ( 'like-ratio' === $column ) {
			if ( ( $like_prec == 0 ) && ( $dislike_prec == 0 ) ) {
				echo __( 'No one reacted to your post', 'RPS' );
			}
			elseif ( $like_prec || $dislike_prec ) {
				echo ( $like_prec / ( $dislike_prec + $like_prec ) ) * 100 . '%';
			}
		}

		if ( 'dislike-ratio' === $column ) {
			if ( ( $like_prec == 0 ) && ( $dislike_prec == 0 ) ) {
				echo __( 'No one reacted to your post', 'RPS' );
			}
			elseif ( $dislike_prec || $like_prec ) {
				echo ( $dislike_prec / ( $dislike_prec + $like_prec ) ) * 100 . '%';
			}
		}
	}

}
$object = new RPS();