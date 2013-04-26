<?php
class MD_Popular_Posts_Widget extends WP_Widget {

	/*--------------------------------------------------*/
	/* Constructor
	/*--------------------------------------------------*/

	/**
	 * Specifies the classname and description, instantiates the widget,
	 * loads localization files, and includes necessary stylesheets and JavaScript.
	 */
	public function __construct() {

		// load plugin text domain
		add_action( 'init', array( &$this, 'widget_textdomain' ) );

		// Hooks fired when the Widget is activated and deactivated
		register_activation_hook( __FILE__, array( &$this, 'activate' ) );
		register_deactivation_hook( __FILE__, array( &$this, 'deactivate' ) );

		parent::__construct(
			'md-popular-posts',
			__( 'MD Popular Posts Tabs', MD_PP_LOCALE ),
			array(
				'classname'		=>	'MD_Popular_Posts_Widget',
				'description'	=>	__( 'Widget with two tabs for popular posts, one based on views and other based upon comments.', MD_PP_LOCALE )
			)
		);

		// Register admin styles and scripts
		add_action( 'admin_print_styles', array( &$this, 'register_admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'register_admin_scripts' ) );

		// Register site styles and scripts
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_styles' ) );
		add_action( 'wp_enqueue_scripts', array( &$this, 'register_widget_scripts' ) );

	} // end constructor

	/*--------------------------------------------------*/
	/* Widget API Functions
	/*--------------------------------------------------*/

	/**
	 * Outputs the content of the widget.
	 *
	 * @param	array	args		The array of form elements
	 * @param	array	instance	The current instance of the widget
	 */
	public function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );

        $title = strip_tags( $instance['title'] );
        $max_posts = (int) $instance['max_posts'];

        $args = array(
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'posts_per_page'=> $max_posts,
            'meta_key'      => '_md_visits',
            'orderby'       => 'meta_value',
            'order'         => 'DESC'
        );
        $popular_views = new WP_Query( $args );

        unset( $args );
        $args = array(
            'post_type'     => 'post',
            'post_status'   => 'publish',
            'posts_per_page'=> $max_posts,
            'orderby'       => 'comment_count',
            'order'         => 'DESC'
        );
        $popular_comments = new WP_Query( $args );

		echo $before_widget;

		if( ! empty($title))
            echo $before_title . $title . $after_title;



		include( MD_PP_PATH . '/views/widget.php' );

		echo $after_widget;

	} // end widget

	/**
	 * Processes the widget's options to be saved.
	 *
	 * @param	array	new_instance	The previous instance of values before the update.
	 * @param	array	old_instance	The new instance of values to be generated via the update.
	 */
	public function update( $new_instance, $old_instance ) {

		$instance = $old_instance;

		$instance['title']  = strip_tags( stripslashes( $new_instance['title'] ) );
        $instance['max_posts'] = strip_tags( stripslashes( $new_instance['max_posts'] ) );

		return $instance;

	} // end widget

	/**
	 * Generates the administration form for the widget.
	 *
	 * @param	array	instance	The array of keys and values for the widget.
	 */
	public function form( $instance ) {

    	$defaults = array( 'title' => 'Popular' );
		$instance = wp_parse_args(
			(array) $instance, $defaults
		);

		$title = esc_attr( $instance['title'] );
        $max_posts = (int) strip_tags( $instance['max_posts'] );

		// Display the admin form
		include( MD_PP_PATH . '/views/admin.php' );

	} // end form

	/*--------------------------------------------------*/
	/* Public Functions
	/*--------------------------------------------------*/

	/**
	 * Loads the Widget's text domain for localization and translation.
	 */
	public function widget_textdomain() {

		load_plugin_textdomain( MD_PP_LOCALE, false, MD_PP_PATH . '/lang/' );

	} // end widget_textdomain

	/**
	 * Fired when the plugin is activated.
	 *
	 * @param		boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog.
	 */
	public function activate( $network_wide ) {
		// TODO define activation functionality here
	} // end activate

	/**
	 * Fired when the plugin is deactivated.
	 *
	 * @param	boolean	$network_wide	True if WPMU superadmin uses "Network Activate" action, false if WPMU is disabled or plugin is activated on an individual blog
	 */
	public function deactivate( $network_wide ) {
		// TODO define deactivation functionality here
	} // end deactivate

	/**
	 * Registers and enqueues admin-specific styles.
	 */
	public function register_admin_styles() {

		//wp_enqueue_style( 'md-pp-admin-styles', plugins_url( MD_PP_SLUG . '/css/admin.css' ) );

	} // end register_admin_styles

	/**
	 * Registers and enqueues admin-specific JavaScript.
	 */
	public function register_admin_scripts() {

		//wp_enqueue_script( 'md-pp-admin-script', plugins_url( MD_PP_SLUG . '/js/admin.js' ), array('jquery') );

	} // end register_admin_scripts

	/**
	 * Registers and enqueues widget-specific styles.
	 */
	public function register_widget_styles() {

		//wp_enqueue_style( 'md-pp-widget-styles', plugins_url( MD_PP_SLUG . '/css/widget.css' ) );

	} // end register_widget_styles

	/**
	 * Registers and enqueues widget-specific scripts.
	 */
	public function register_widget_scripts() {

		wp_enqueue_script( 'md-pp-script', plugins_url( MD_PP_SLUG . '/js/widget.js' ), array('jquery'), null, true );

	} // end register_widget_scripts

} // end class