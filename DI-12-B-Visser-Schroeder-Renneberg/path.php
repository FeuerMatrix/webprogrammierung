<?php
$path = __DIR__ . "/";

/**
 * For hrefs, $path doesn't work. The following code generates the web address used to access the file without anything after the root folder. The reason this is so complicated is because getting the whole url actually returns a file path like __DIR__ does.
 * For the absolute link to work, even the http:// is needed...
 * 
 * $hpath should work even if the folder structure above "DI-12-B-Visser-Schroeder-Renneberg" is different, but won't work anymore if the name "DI-12-B-Visser-Schroeder-Renneberg" itself is changed.
 */
$hpath = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? 'https' : 'http').'://'.$_SERVER['HTTP_HOST'].explode("DI-12-B-Visser-Schroeder-Renneberg", $_SERVER["PHP_SELF"])[0]."DI-12-B-Visser-Schroeder-Renneberg/";
?>