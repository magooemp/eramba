<?php
define('LINK_DOMAIN', 'eramba.localhost');
define('NAME_SERVICE', 'Eramba');
define('DEFAULT_NAME', 'Ermaba');

//used protocol
if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS'])) {
	define('HTTP_PROTOCOL', 'https://');
}
else {
	define('HTTP_PROTOCOL', 'http://');
}

//permanent login constants
define('SECURITY_SALT1', 'P9xmY4S*(3gTJp8Z4;14SL32!rJYSVkok708X~?-><O9vDleB1J59U:0q7;#$0n@@sNF');
define('SECURITY_SALT2', 'Lvm9c6jnvnfZ;loCTUp/r.JNurzEQP/.,,mNfh3CJ2E;1GAn582yblB8$$v%)_+Upd+');
define('PERMANENT_LOGGED_TIME', 14 * 86400); // 14 dni
define('PERMANENT_LOG_FILE', 'cookie_logging.log');

//ON/OFF multilanguage
define('I18N_SET', 0);

//default locale in format ISO-639-2
define('DEFAULT_LOCALE', 'eng');
define('DEFAULT_LOCALE_HTML', 'en'); //ISO-639-1 format

//email settings
define('NO_REPLY_EMAIL', 'noreply@eramba.org');
define('SMTP_USE', false);
define('SMTP_HOST', '');
define('SMTP_USER', '');
define('SMTP_PWD', '');
define('SMTP_PORT', '25');
define('SMTP_TIMEOUT', '30');
