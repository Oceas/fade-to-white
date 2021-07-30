<?php
/**
 * Plugin Name: Fade to White
 * Description: Sunsets a site by a given date.
 * Note: Require define FTW_ENABLED as true for it to work
 * Note: Require define FTW_COMPLETION_DATE in 'YYYY-MM-DD'
 * Note: Require define FTW_COMPLETION_DATE in 'YYYY-MM-DD'
 *
 * @author  Scott Anderson <scott@thriftydeveloper.com>
 * @package ThriftyDeveloper\MU_Plugin\Fade_To_White
 * @since   NEXT
 *
 */

namespace ThriftyDeveloper\Fade_To_White;

class Fade_To_White {

	/**
	 * Current Date.
	 *
	 * @var DateTime $today
	 * @since NEXT
	 */
	private $today;

	/**
	 * Date to start fading.
	 *
	 * @var DateTime $start_date
	 * @since NEXT
	 */
	private $start_date;

	/**
	 * Date fading should end.
	 *
	 * @var DateTime $completion_date
	 * @since NEXT
	 */
	private $completion_date;

	/**
	 * Construct
	 *
	 * @since  0.1.0
	 * @author Scott Anderson <scott@thriftydeveloper.com>
	 */
	public function __construct() {
		if ( FTW_ENABLED ) {
			$this->load_variables();
			$this->hooks();
		}
	}

	/**
	 * Load Fade to White Variables
	 *
	 * @author Scott Anderson <scott@thriftydeveloper.com>
	 * @since  NEXT
	 *
	 * @return void
	 */
	private function load_variables() : void {
		$this->today           = new \DateTime( 'NOW' );
		$this->start_date      = new \DateTime( FTW_START_DATE );
		$this->completion_date = new \DateTime( FTW_COMPLETION_DATE );
	}

	/**
	 * Hooks
	 *
	 * @author Scott Anderson <scott@thriftydeveloper.com>
	 * @since  NEXT
	 * @return void
	 */
	private function hooks() : void {
		add_action( 'wp', [ $this, 'fade' ] );
	}

	/**
	 * Change site's opacity.
	 *
	 * @author Scott Anderson <scott@thriftydeveloper.com>
	 * @since  NEXT
	 *
	 * @return void
	 */
	public function fade() : void {
		$total_day_span        = $this->start_date->diff( $this->completion_date )->days;
		$days_elasped          = $this->start_date->diff( $this->today )->days;
		$opacity_value_per_day = 100 / $total_day_span;
		$total_opacity         = 100 - absint( $days_elasped * $opacity_value_per_day );

		if ( $total_day_span <= $days_elasped ) {
			$total_opacity = 0.0;
		} else {
			$total_opacity = "0.{$total_opacity}";
		}

		echo "<style>body{opacity: {$total_opacity}};</style>";
	}
}

/**
 * Load the Plugin
 *
 * @author Scott Anderson <scott@thriftydeveloper.com>
 * @since  0.1.0
 */
function load_plugin() {
	new Fade_To_White();
}

add_action( 'plugins_loaded', '\ThriftyDeveloper\Fade_To_White\load_plugin' );
