<?php
/**
 * This checks, if the admin bar gets hidden by the theme
 **/
class NoHiddenAdminBar implements themecheck {
	protected $error = array();

		function check( $php_files, $css_files, $other_files ) {
			$ret = true;
			checkcount();
			$php_regex = "/(add_filter(\s*)\((\s*)(\"|')show_admin_bar(\"|')(\s*)(.*))|(([^\S])show_admin_bar(\s*)\((.*))/";
			$css_regex = "/(#wpadminbar)/";

			//Check php files for filter show_admin_bar and show_admin_bar()
			foreach ( $php_files as $file_path => $file_content ) {

				$filename = tc_filename( $file_path );

				if ( preg_match( $php_regex, $file_content, $matches ) ) {
					$this->error[] = sprintf( '<span class="tc-lead tc-required">' . __( 'REQUIRED', 'theme-check').'</span>: ' . __( 'You are not allowed to hide the admin bar. File : %1$s', 'theme-check' ), 
						'<strong>' . $filename . '</strong>');	
					$ret = false;			
				}
			}

			//Check CSS Files for #wpadminbar
			foreach ( $css_files as $file_path => $file_content ) {

				$filename = tc_filename( $file_path );

				if ( preg_match( $css_regex, $file_content, $matches ) ) {
					$this->error[] = sprintf( '<span class="tc-lead tc-warning">' . __( 'WARNING', 'theme-check').'</span>: ' . __( 'The theme is using `#wpadminbar`. Hiding the admin bar is not allowed. File : %1$s', 'theme-check' ), 
						'<strong>' . $filename . '</strong>');		
				}
			}
		return $ret;
	}

	function getError() { return $this->error; }
}
$themechecks[] = new NoHiddenAdminBar;
