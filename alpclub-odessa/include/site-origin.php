<?php
/**
 * Support for Site Origin builder
 *
 */



/**
 * Add tab in builder widgets section.
 *
 * @since 1.0.0
 *
 * @param array $tabs Tabs.
 * @return array Modified tabs.
 */

add_filter( 'siteorigin_panels_widget_dialog_tabs', function ( $tabs ) {

		$tabs['alpclub-odessa'] = array(
			'title'  => esc_html__( 'Alpclub Odessa Widgets', 'alpclub-odessa' ),
			'filter' => array(
				'groups' => array( 'alpclub-odessa' ),
			),
		);

		return $tabs;
} );


/**
 * Grouping theme widgets in builder.
 *
 * @since 1.0.0
 *
 * @param array $widgets Widgets array.
 * @return array Modified widgets array.
 */


add_filter( 'siteorigin_panels_widgets', function ( $widgets ) {

	if ( isset( $GLOBALS['wp_widget_factory'] ) && ! empty( $GLOBALS['wp_widget_factory']->widgets ) ) {

		$all_widgets = array_keys( $GLOBALS['wp_widget_factory']->widgets );

		foreach ( $all_widgets as $widget ) {
			if ( false !== strpos( $widget, 'Alpclub_Odessa_' ) ) {
				$widgets[ $widget ]['groups'] = array( 'alpclub-odessa' );
				$widgets[ $widget ]['icon']   = 'dashicons dashicons-awards';
			}
		}
	}

	return $widgets;
}
 );



/**
 * Make widgets active.
 *
 * @since 1.0.0
 *
 * @param array $active Array of widgets.
 * @return array Modified array.
 */
	


add_filter( 'siteorigin_widgets_active_widgets', function ( $active ) {
		$active['alpclub-odessa-cta']             = true;
		return $active;
} );