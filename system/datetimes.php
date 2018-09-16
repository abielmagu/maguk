<?php // DATETIMES SYSTEM

// Datetimes
define('DATETIME_ZERO', '0000-00-00 00:00:00');
define('DATETIME_FULL', '9999-12-31 23:59:59');
define('DATETIME_NOW' , date('Y-m-d H:i:s'));

// Dates
define('DATE_ZERO' , '0000-00-00');
define('DATE_FULL' , '9999-12-31');
define('DATE_HUMAN', date('F d, Y'));
define('DATE_NOW'  , date('Y-m-d'));
define('DATE_INIT' , date('Y-01-01'));
define('DATE_USA'  , date('F, jS Y'));

// Times
define('TIME_ZERO' , '00:00:00');
define('TIME_FULL' , '23:59:59');
define('TIME_HUMAN', date('g:i:s a'));
define('TIME_NOW'  , date('H:i:s'));

// Format to display
define('DATETIME_DISPLAY'     , 'd-m-Y h:i:s a');
define('DATETIME_DISPLAY_ZERO', '00-00-0000 00:00:00');
define('DATE_DISPLAY'         , 'd-m-Y');
define('DATE_DISPLAY_ZERO'    , '00-00-0000');
define('TIME_DISPLAY'         , 'h:i:s a');
define('TIME_DISPLAY_ZERO'    , '00:00:00');