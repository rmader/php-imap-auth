# php-imap-auth
A simple php-imap-auth script to be used with nginx-auth

Requires: nginx (might work with other webservers, too), php, php-imap

Usage:
 - make the scripts available somewhere, in this example at https://imap-auth.liqd.net/
 - edit the imap-login.php file for your needs (email host, allowed domains)
 - for the location you want to protect, add somethink like below:

```
location / {
	auth_request /imap-auth.php;
	...
}
location /imap-auth.php {
	proxy_pass https://imap-auth.liqd.net/imap-auth.php;
}
location /imap-login.php {
	proxy_pass https://imap-auth.liqd.net/imap-login.php;
}
error_page 401 /imap-login.php;
```
