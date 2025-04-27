<?php
/**
 * Plugin Name:       Disk Usage Viewer
 * Plugin URI:        https://bxmedia.pro
 * Description:       Displays server disk space usage (total, used, free) in a dashboard widget.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            BX Media
 * Author URI:        https://bxmedia.pro/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       disk-usage-viewer
 * Domain Path:       /languages
 */

// Prevent direct file access
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add the dashboard widget.
 */
function dvu_add_dashboard_widget() {
	// Check if the user has the capability to view site health
	if ( current_user_can( 'view_site_health_checks' ) ) {
		wp_add_dashboard_widget(
			'dvu_disk_usage_widget',          // Widget slug.
			__( 'Server Disk Usage', 'disk-usage-viewer' ), // Title.
			'dvu_render_dashboard_widget'     // Display function.
		);
	}
}
add_action( 'wp_dashboard_setup', 'dvu_add_dashboard_widget' );

/**
 * Render the content of the dashboard widget.
 */
function dvu_render_dashboard_widget() {
	// Get the path to the WordPress installation directory
    // Using ABSPATH provides a reliable path within the WP environment
	$disk_path = ABSPATH;

    // Check if disk_total_space and disk_free_space functions exist and are usable
    // Suppress errors for security reasons if functions are disabled
    $total_space = @disk_total_space( $disk_path );
    $free_space  = @disk_free_space( $disk_path );

    echo '<div class="dvu-widget-content">'; // Add a wrapper div for potential styling

    if ( false === $total_space || false === $free_space ) {
        // Display an error message if space information cannot be retrieved
        echo '<p>' . esc_html__( 'Could not retrieve disk space information. The PHP functions might be disabled on your server.', 'disk-usage-viewer' ) . '</p>';
    } else {
        // Calculate used space
        $used_space = $total_space - $free_space;

        // Calculate percentages
        $used_percentage = round( ( $used_space / $total_space ) * 100, 1 );
        $free_percentage = round( ( $free_space / $total_space ) * 100, 1 );

        // Display the information
        echo '<ul>';
        echo '<li><strong>' . esc_html__( 'Total Space:', 'disk-usage-viewer' ) . '</strong> ' . esc_html( dvu_format_size( $total_space ) ) . '</li>';
        echo '<li><strong>' . esc_html__( 'Used Space:', 'disk-usage-viewer' ) . '</strong> ' . esc_html( dvu_format_size( $used_space ) ) . ' (' . esc_html( $used_percentage ) . '%)</li>';
        echo '<li><strong>' . esc_html__( 'Free Space:', 'disk-usage-viewer' ) . '</strong> ' . esc_html( dvu_format_size( $free_space ) ) . ' (' . esc_html( $free_percentage ) . '%)</li>';
        echo '</ul>';

        // Optional: Add a simple progress bar
        echo '<div style="background-color: #eee; border-radius: 5px; overflow: hidden; margin-top: 10px; height: 20px; width: 100%;">';
        echo '<div style="background-color: #4CAF50; width: ' . esc_attr( $free_percentage ) . '%; height: 100%; float: left; text-align: center; color: white; line-height: 20px; font-size: 12px;">' . esc_html( round($free_percentage) ) . '% Free</div>';
         echo '<div style="background-color: #f44336; width: ' . esc_attr( $used_percentage ) . '%; height: 100%; float: left; text-align: center; color: white; line-height: 20px; font-size: 12px;">' . esc_html( round($used_percentage) ) . '% Used</div>';
        echo '</div>';
        echo '<div style="clear: both;"></div>'; // Clear float for progress bar

    }

    echo '</div>'; // Close wrapper div
}

/**
 * Format bytes into a human-readable string (KB, MB, GB, TB).
 *
 * @param int $bytes The number of bytes.
 * @param int $precision The number of decimal places.
 * @return string The formatted size string or 'N/A' if input is invalid.
 */
function dvu_format_size( $bytes, $precision = 2 ) {
    if ( ! is_numeric( $bytes ) || $bytes < 0 ) {
        return __( 'N/A', 'disk-usage-viewer' );
    }

	$units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB' );
	$bytes = max( $bytes, 0 );
	$pow   = floor( ( $bytes ? log( $bytes ) : 0 ) / log( 1024 ) );
	$pow   = min( $pow, count( $units ) - 1 );

	// Calculate the value for the chosen unit
	$bytes /= pow( 1024, $pow );

	return round( $bytes, $precision ) . ' ' . $units[ $pow ];
}

?>

