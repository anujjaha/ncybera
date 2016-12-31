<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('JOB_CREATED', "Created");
define('JOB_PENDING', 'Pending');
define('JOB_DESIGN', 'Designing');
define('JOB_DESIGN_COMPLETED', "Design Completed");
define('JOB_PRINT', 'Printing');
define('JOB_PRINT_COMPLETED', "Print Completed");
define('JOB_CUTTING', 'Cutting');
define('JOB_CUTTING_COMPLETED', "Cutting Completed");
define('JOB_HOLD', 'Hold');
define('JOB_COMPLETE', 'Completed');
define('JOB_EDIT', 'Edited');
define('JOB_CANCEL', 'Cancel');
define('JOB_CLOSE', 'Closed');


define('PRINT_MUSIC','http://localhost/ncybera/printing-sound.mp3');
define('CUTTING_MUSIC','http://localhost/ncybera/cutting-sound.mp3');

define('DEBIT','debit');
define('CREDIT','credit');


define('TASK_CREATED','Task Assigned');
define('TASK_COMPLETED','Task Completed');
define('TASK_PENDING','Task Pending');
define('TASK_IN_PROGRESS','Task In Progress');

define("SITE_SIGNATURE", 'Hello <br><p></p><p><strong>CYBERA PRINT ART</strong><br />G/3 &amp; 12, SAMUDRA ANNEXE,&nbsp;NR. HOTEL KLASSIC GOLD, <br />OFF C. G. ROAD, NAVRANGPURA,&nbsp;AHMEDABAD, GUJARAT, INDIA.</p>
<div>Phone : +91 79 2 65 65 720 / 2 64 65 720</div>
<div>Mobile : <a href="tel:0%2098%2098%2030%2098%2097" target="_blank">0 98 98 30 98 97</a><br />WEBSITE : <a href="http://www.cybera.in/" target="_blank" data-saferedirecturl="https://www.google.com/url?hl=en-GB&amp;q=http://www.cybera.in&amp;source=gmail&amp;ust=1477681956691000&amp;usg=AFQjCNEAajUeeC_HxQtAH5-HOpleFdOxlA">www.cybera.in</a>
<div>&nbsp;</div>
<div><strong><span style="color: #ff0000;">OUR WORKING HOURS</span></strong></div>
<div>MONDAY TO SATURDAY &nbsp;10:00 AM TO 8:00 PM</div>
<div>SUNDAY CLOSED</div>
<div><br /><span style="color: #ff6600;"><strong>FOR SUGGESTIONS &amp; COMPLAINTS</strong></span><br />Mobile : <a href="tel:0%2098%2098%2061%2086%2097" target="_blank">0 98 98 61 86 97</a><br />E-mail : <a href="mailto:shaishav77@gmail.com" target="_blank">shaishav77@gmail.com</a></div>
</div>');
