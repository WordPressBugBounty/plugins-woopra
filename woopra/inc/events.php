<?php
/**
 * WoopraEvents_Frontend and WoopraEvents_Admin Class for Woopra
 *
 * This class contains all event related code including the API for other plugins to use.
 *
 * @since 1.4.1
 * @package woopra
 * @subpackage events
 */
 
/**
 * Main Woopra Events Class
 * @since 1.4.1
 * @package events
 * @subpackage woopra
 */
class WoopraEvents extends WoopraFrontend {
	
	/**
	 * Woopra's Built in Events.
	 * @since 1.4.1
	 * @var
	 */
	var $default_events;
	
	/**
	 * Woopra's Built in WooCommerce Events.
	 * @since 3.2
	 * @var array
	 */
	var $default_woocommerce_events;
	
	/**
	 * What are the current event's going on?
	 * @since 1.4.1
	 * @var object
	 */
	var $current_event;
	
	/**
	 * Are there events present?
	 * @var 1.4.3
	 */
	var $present_event;
	
	/**
	 * Events Contructor Class
	 * @since 1.4.1
	 * @return 
	 * @constructor
	 */
	function __construct() {
		Woopra::__construct();
		
		// Register Events!
		$this->register_events();
	}

	/**
	 * Register Events
	 * @since 1.4.1
	 * @return 
	 */
	function register_events() {
		/*
		 * 
		 * These are all standard events that WordPress
		 * has that Woopra built-in it's system.
		 * 
		 * 
		 * VALID FIELDS:
		 * 
		 * name* - The name the Woopra App will see.
		 * label* - What the description of the event in WordPress admin panel
		 * function - If a function is required to get the event data.
		 * object - Depending if the function returns an object, this would be the object name to get.
		 * value - Simple value when processed.
		 * 
		 * action** - The action that this event triggers.
		 * filter** - The filter that this event triggers.
		 * 
		 * setting*** - If the 'action' or 'filter' have duplicities, they must have unique setting names.
		 * 
		 */
		
		// Define events without translations first
		$default_events = array(
			array(
				'name'		=>	'comments',
				'label'		=>	'Show comments as they are posted.',
				'action'	=>	'comment_post',
			),
			array(
				'name'		=>	'search',
				'label'		=>	'Show users search queries.',
				'action'	=>	'search_query',
			),
			array(
				'name'		=>	'signup',
				'label'		=>	'Show users sign up.',
				'action'	=>	'signup',
			)
		);
		
		$this->default_events = $default_events;

		$default_woocommerce_events = array(
			array(
				'name'		=>	'cart update',
				'label'		=>	'Show cart updates.',
				'action'	=>	'cart',
			),
			array(
				'name'		=>	'checkout',
				'label'		=>	'Show users checkouts.',
				'action'	=>	'checkout',
			),
			array(
				'name'		=>	'coupon',
				'label'		=>	'Track coupons applied.',
				'action'	=>	'coupon',
			)
		);

		$this->default_woocommerce_events = $default_woocommerce_events;
		
		// Apply translations after init
		add_action('init', array($this, 'translate_event_strings'), 15);
	}
	
	/**
	 * Translate event strings after text domain is loaded
	 * @since 3.2
	 * @return void
	 */
	function translate_event_strings() {
		// Apply translations to default events
		if (is_array($this->default_events)) {
			foreach ($this->default_events as $key => $event) {
				$this->default_events[$key]['name'] = __($event['name'], 'woopra');
				$this->default_events[$key]['label'] = __($event['label'], 'woopra');
			}
		}
		
		// Apply translations to WooCommerce events
		if (is_array($this->default_woocommerce_events)) {
			foreach ($this->default_woocommerce_events as $key => $event) {
				$this->default_woocommerce_events[$key]['name'] = __($event['name'], 'woopra');
				$this->default_woocommerce_events[$key]['label'] = __($event['label'], 'woopra');
			}
		}
	}
	

}
