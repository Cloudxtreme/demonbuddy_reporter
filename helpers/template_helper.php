<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if ( ! function_exists('get_i18n_code'))
{
	/**
	 * Get the current language code (as opposed to current language name)
	 *
	 * @return string
	 */
	function get_i18n_code()
	{
		$CI =& get_instance();
		if($CI instanceof MY_Controller) {
			return $CI->i18n->get_language_code();
		}
		
		return '';
	}
}

if ( ! function_exists('toggle_lang'))
{
	/**
	 * Get the toggle language name
	 *
	 * @return string
	 */
	function toggle_lang()
	{
		return config_item('language') == 'english' ? 'french' : 'english';
	}
}

if ( ! function_exists('toggle_uri_lang'))
{
	/**
	 * Get the toggle URI for the current page
	 *
	 * @return string
	 */
	function toggle_uri_lang($lang = 'english')
	{
		$CI =& get_instance();
		$uri_array = array_reverse($CI->uri->segment_array());
		array_pop($uri_array);
		return i18n_site_url(
			array_reverse($uri_array),
			$lang
		);
	}
}

if ( ! function_exists('toggle_uri'))
{
	/**
	 * Get the toggle URI for the current page
	 *
	 * @return string
	 */
	function toggle_uri()
	{
		$CI =& get_instance();
		return i18n_site_url(
			$CI->uri->rsegment_array(),
			toggle_lang()
		);
	}
}

if ( ! function_exists('toggle_anchor_lang'))
{
	/**
	 * Create a simple toggle anchor
	 *
	 * @param string|array $attributes
	 * @return string
	 */
	function toggle_anchor_lang($lang = 'english', $attributes = NULL)
	{
		if(toggle_lang() != $lang) {
			$attributes .= 'class="selected"';
		}

		return sprintf('<a href="%s"%s>%s</a>',
			toggle_uri_lang($lang),
			$attributes ? _parse_attributes($attributes) : '',
			i18n_lang($lang, $lang)
		);
	}
}

if ( ! function_exists('toggle_anchor'))
{
	/**
	 * Craete a simple toggle anchor
	 *
	 * @param string|array $attributes
	 * @return string
	 */
	function toggle_anchor($attributes = '')
	{
		return sprintf('<a href="%s"%s id="languageToggle" title="' . lang("language_toggle_title") . '">%s</a>',
			toggle_uri(),
			$attributes ? _parse_attributes($attributes) : '',
			i18n_lang(toggle_lang(), toggle_lang())
		);
	}
}

if ( ! function_exists('anchor_img'))
{
	/**
	 * Create an image wrapped by an anchor
	 *
	 * @param string $destination_url
	 * @param string $img_path
	 * @param string $img_name
	 * @param string $alt_tag
	 * @param string|array $attributes
	 * @return string
	 */
	function anchor_img( $destination_url, $img_path, $img_name, $alt_tag = '', $attributes = '')
	{
		$return_string = '<a href="' . $destination_url . '" ' . (!empty($alt_tag)? ' alt="' . $alt_tag . '"' : '') . '>';
		$return_string .= '<img src="' . base_url() . $img_path . $img_name . '" ' . (!empty($alt_tag)? 'title="' . $alt_tag . '" alt="' . $alt_tag . '"' : '') . '/>';
		$return_string .= '</a>';
		return $return_string;
	}
}

if ( ! function_exists('shorten_string'))
{
	/**
	 * Create an image wrapped by an anchor
	 *
	 * @param string $source_string
	 * @param string $max_size
	 * @return string
	 */
	function shorten_string( $source_string, $max_size = 100)
	{
		if(strlen($source_string) <= $max_size)
			return $source_string;
		return substr($source_string, 0, $max_size) . "...";
	}
}
/* End of file template_helper.php */
/* Location: ./application/helpers/template_helper.php */