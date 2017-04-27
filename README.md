# php-imap-auth
A simple php-imap-auth script to be used with nginx-auth

Requires: nginx (might work with other webservers, too), php, php-imap
 
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
