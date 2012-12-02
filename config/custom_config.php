<?php
// You will need to modify the configuration each. 
// Please also visit config/database.php and ensure your database settings
$config['base_url']	= "http://localhost/demonbuddy_reporter/"; 		// This must be the FULL web URL to your DemonBuddy Reporter. Please include trailing slash!
$config['site_folder'] = "c:/xampp/htdocs/demonbuddy_reporter/"; 	// The physical directory of the DemonBuddy Reporter. Please include trailing slash!
$config['custom_smtp_host'] = "localhost";						// Email server configuration


//These are the paths to the stashlogs for your various botting characters. Select the Stash log within the GilesTrinity
//Characters are created dynamically in the databases as required. Characters are defined as Name#BattleTag from the stash log.
//In the future I would like this to be a database configurable list.
$config['stash_paths'] = array(
	"C:/Users/Ben/Desktop/Demonbuddy/Plugins/GilesTrinity/Binlagin#1234 - StashLog - Monk.log",
	"C:/Users/Ben/Desktop/Demonbuddy/Plugins/GilesTrinity/Strider#1235 - StashLog - Monk.log", 
	"Z:/Plugins/GilesTrinity/Binlaggggin#1236 - StashLog - Monk.log",
	"C:/Users/Ben/Desktop/Demonbuddy/Plugins/GilesTrinity/binlagggin#1237 - StashLog - Monk.log"
);