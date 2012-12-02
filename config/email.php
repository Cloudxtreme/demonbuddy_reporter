<?php
	// Load instance of CI so we have access to all preloaded libs, configs, plugins, etc.
	$CI = &get_instance();
	$CI->config->load('custom_config');

	// Use the config for SMTP set in our custom configs file
	$config['smtp_host'] = $CI->config->item('custom_smtp_host');
	$config['protocol'] = 'smtp';
	$config['charset'] = 'utf-8';