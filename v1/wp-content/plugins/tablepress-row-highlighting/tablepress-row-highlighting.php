<?php
/*
Plugin Name: TablePress Extension: Row Highlighting
Plugin URI: https://tablepress.org/extensions/row-highlighting/
Description: Extension for TablePress to highlight certain rows, depending on the existence of a certain cell
Version: 1.0
Author: Tobias Bäthge
Author URI: https://tobias.baethge.com/
*/

/**
 * Usage:
 * Quick version: [table id=1 row_highlight="Term1||Term 2" /]
 * All parameters: [table id=1 row_highlight="Term1||Term 2" row_highlight_rows="1-4" row_highlight_case_sensitive="true" row_highlight_full_cell_match="false" /]
 *
 * Rows with the found highlight term in a cell will get a CSS class like "row-highlight-term1" or "row-highlight-term-2" (for the examples above)
 * This can then be styled with "Custom CSS" like
 * 		.tablepress-id-1 .row-highlight-term1 td {
 *  		background-color: #ff0000 !important;
 * 		}
 * 		.tablepress-id-1 .row-highlight-term-2 td {
 *  		background-color: #00ff00 !important;
 * 		}
 */

// Prohibit direct script loading.
defined( 'ABSPATH' ) || die( 'No direct script access allowed!' );

/**
 * Init TablePress_Row_Highlighting.
 */
add_action( 'tablepress_run', array( 'TablePress_Row_Highlighting', 'init' ) );

/**
 * Class that contains the TablePress Row Highlighting functionality
 * @since 1.0.0
 */
class TablePress_Row_Highlighting {

	/**
	 * Necessary local class variables.
	 */
	protected static $highlight_compare_function = '';
	protected static $highlight_match_function = '';
	protected static $highlight_terms = array();
	protected static $highlight_rows = array();
	protected static $full_cell_match = false;

	/**
	 * Register necessary plugin filter hooks.
	 *
	 * @since 1.0.0
	 */
	public static function init() {
		add_filter( 'tablepress_shortcode_table_default_shortcode_atts', array( __CLASS__, 'shortcode_attributes' ) );
		add_filter( 'tablepress_table_render_data', array( __CLASS__, 'process_parameters' ), 10, 3 );
	}

	/**
	 * Add the Extension's parameters as valid [table /] Shortcode attributes.
	 *
	 * @since 1.0.0
	 *
	 * @param array $default_atts Default attributes for the TablePress [table /] Shortcode.
	 * @return array Extended attributes for the Shortcode.
	 */
	public static function shortcode_attributes( $default_atts ) {
		$default_atts['row_highlight'] = '';
		$default_atts['row_highlight_full_cell_match'] = true;
		$default_atts['row_highlight_case_sensitive'] = false;
		$default_atts['row_highlight_rows'] = 'all';
		return $default_atts;
	}

	/**
	 * Helper function for exact matching (strcmp() and strcasecmp() return 0 in case of exact match).
	 *
	 * @since 1.0.0
	 *
	 * @param string $a Cell content
	 * @param string $b Search term
	 * @return bool Whether string $a and $ are equal (thus the filter matches)
	 */
	public static function _full_cell_match( $a, $b ) {
		return ( 0 === call_user_func( self::$highlight_compare_function, $a, $b ) );
	}

	/**
	 * Helper function for part matching (strpos() and stripos() return false in case of no match)
	 *
	 * @since 1.0.0
	 *
	 * @param string $a Cell content.
	 * @param string $b Search term.
	 * @return bool Whether string $b can be found somewhere in $a (thus the filter matches).
	 */
	public static function _cell_part_match( $a, $b ) {
		return ( false !== call_user_func( self::$highlight_compare_function, $a, $b ) );
	}

	/**
	 * Extract Highlighting parameters and save them locally.
	 *
	 * The function uses the filter hook as an action and does not change the parameters.
	 *
	 * @since 1.0.0
	 *
	 * @param array $table          Table.
	 * @param array $orig_table     Original/unmodified table.
	 * @param array $render_options Render Options.
	 * @return array (Unmodified) table.
	 */
	public static function process_parameters( $table, $orig_table, $render_options ) {
		// Early exit, if no or an empty "row_highlight" parameter is given.
		if ( empty( $render_options['row_highlight'] ) ) {
			return $table;
		}

		// The Highlight values.
		self::$highlight_terms = explode( '||', $render_options['row_highlight'] );

		// The rows that shall be searched for the Highlight values.
		$highlight_rows = $render_options['row_highlight_rows'];
		// Add all rows to array if "all" value set for the columns parameter.
		if ( 'all' === $highlight_rows ) {
			$highlight_rows = '1-' . count( $table['data'] );
		}
		// We have a list of rows (possibly with ranges in it).
		$highlight_rows = explode( ',', $highlight_rows );
		// Support for ranges like 3-6.
		$range_cells = array();
		foreach ( $highlight_rows as $key => $value ) {
			$range_dash = strpos( $value, '-' );
			if ( false !== $range_dash ) {
				unset( $highlight_rows[ $key ] );
				$start = substr( $value, 0, $range_dash );
				$end = substr( $value, $range_dash + 1 );
				$current_range = range( $start, $end );
				$range_cells = array_merge( $range_cells, $current_range );
			}
		}
		$highlight_rows = array_merge( $highlight_rows, $range_cells );
		$highlight_rows = array_map( 'absint', $highlight_rows );
		$highlight_rows = array_unique( $highlight_rows, SORT_NUMERIC );
		self::$highlight_rows = $highlight_rows;

		// Determine which functions should be used for matching, depending on parameters.
		self::$full_cell_match = $render_options['row_highlight_full_cell_match'];
		if ( self::$full_cell_match ) {
			// The entire cell content has to match the search term.
			self::$highlight_match_function = '_full_cell_match';
			if ( $render_options['row_highlight_case_sensitive'] ) {
				self::$highlight_compare_function = 'strcmp';
			} else {
				self::$highlight_compare_function = 'strcasecmp';
			}
		} else {
			// The search term can be anywhere in the cell content.
			self::$highlight_match_function = '_cell_part_match';
			if ( $render_options['row_highlight_case_sensitive'] ) {
				self::$highlight_compare_function = 'strpos';
			} else {
				self::$highlight_compare_function = 'stripos';
			}
		}

		// Register actual filter and cleanup filter.
		add_filter( 'tablepress_row_css_class', array( __CLASS__, 'highlight_rows' ), 10, 5 );
		add_filter( 'tablepress_table_output', array( __CLASS__, 'remove_row_css_class_filter' ), 10, 3 );

		return $table;
	}

	/**
	 * Search current row for highlight terms, and add another CSS class on find.
	 *
	 * @since 1.0.0
	 *
	 * @param string $row_class  Current CSS classes of the row.
	 * @param string $table_id   Table ID.
	 * @param array  $row_cells  HTML code for the cells.
	 * @param int    $row_number Row number.
	 * @param string $row_data   Row data array.
	 * @return string Row's new CSS classes.
	 */
	public static function highlight_rows( $row_class, $table_id, $row_cells, $row_number, $row_data ) {
		if ( empty( $row_data ) ) {
			return $row_class;
		}
		if ( empty( self::$highlight_terms ) ) {
			return $row_class;
		}
		if ( ! in_array( $row_number, self::$highlight_rows ) ) {
			return $row_class;
		}

		foreach ( self::$highlight_terms as $highlight_term ) {
			foreach ( $row_data as $cell ) {
				if ( call_user_func( array( __CLASS__, self::$highlight_match_function ), $cell, $highlight_term ) ) { // The parameter order is important (for str(i)pos()).
					$row_class .= ' row-highlight-' . strtolower( sanitize_title_with_dashes( $highlight_term ) );
					break;
				}
			}
		}

		return $row_class;
	}

	/**
	 * Remove filter again after we are done, to allow the class to be used again on the same page.
	 *
	 * The function uses the filter hook as an action and does not change the parameters.
	 *
	 * @since 1.0.0
	 *
	 * @param string $output         Output.
	 * @param array  $table          Table.
	 * @param array  $render_options Render Options.
	 * @return string (Unmodified) output.
	 */
	public static function remove_row_css_class_filter( $output, $table, $render_options ) {
		remove_filter( 'tablepress_row_css_class', array( __CLASS__, 'highlight_rows' ), 10, 5 );
		return $output;
	}

} // class TablePress_Row_Highlighting
