php-notify
==========

XMPP/Jabber notification from php through sendxmpp


## Installation

### Clone to your Webserver

	git clone https://github.com/jmara/php-notify
	
### Install sendxmpp

	aptitude install sendxmpp

### Add a sendxmpp config and change ownership to the webserver:

    cat > /var/www/php-notify/config/xmpp.conf << EOF
    mybot@jabber.local MyPassWord123 TestResource
    EOF
    chown www-data /var/www/php-notify/config/xmpp.conf
    chmod 0600 /var/www/php-notify/config/xmpp.conf


### Add a config/config.php with your settings:

    <?PHP

    date_default_timezone_set('Europe/Berlin');

    $debug      = false;
    $debug_user = "jmara";
    $server     = "jabber.example.com";
    $botname    = "Jigsaw";
    $restrict   = array("10.0.2.","10.0.3.");

    ?>

## Usage

    curl -F "msg=Test Message" http://php-notify.example.com

