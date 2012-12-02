<?php
// You will need to modify the configuration each. 
// Please also visit config/database.php and ensure your database settings
$config['base_url']	= "http://localhost/demonbuddy-reporter/"; 		// This must be the FULL web URL to your DemonBuddy Reporter. Please include trailing slash!
$config['site_folder'] = "c:/xampp/htdocs/demonbuddy-reporter/"; 	// The physical directory of the DemonBuddy Reporter. Please include trailing slash!
$config['custom_smtp_host'] = "localhost";						// Email server configuration


//These are the paths to the stashlogs for your various botting characters. Select the Stash log within the GilesTrinity. These directories and files MUST BE WRITEABLE!
//PLEASE ENSURE ALL DIRECTORIES AND FILES ARE WRITEABLE BY THE SYSTEM!
$config['stash_paths'] = array(
	"C:/Users/Ben/Desktop/Demonbuddy/Plugins/GilesTrinity/Binlagin#1111 - StashLog - Monk.log",  
	"C:/Users/Ben/Desktop/Demonbuddy/Plugins/GilesTrinity/Strider#2222 - StashLog - Monk.log", 
	"Z:/Plugins/GilesTrinity/Binlaggggin#3333 - StashLog - Monk.log",
	"C:/Users/Ben/Desktop/Demonbuddy/Plugins/GilesTrinity/binlagggin#4444 - StashLog - Monk.log"
);