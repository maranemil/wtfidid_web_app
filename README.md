WTF I DID ( WEB APP )
===============

Web App able to track your time that you spend in different Tasks/Jobs/Projects


### Info
* ** Author: Emil Maran
* ** Tags: Time Tracking App, Web App, Mobile Web
* ** created:  2014 Apr 27
* ** modified: 2014 Apr 29

[![Editor Screen](https://raw.github.com/maranemil/wtfidid_web_app/master/screens/wtfidid_screen.png)](#features)

### Fix for RewriteBase, 500 Internal Server Error:

<code>

<IfModule mod_rewrite.c>
   RewriteEngine on
   RewriteBase /
   RewriteRule    ^$ app/webroot/    [L]
   RewriteRule    (.*) app/webroot/$1 [L]
</IfModule>

</code>

In all three .htaccess files, in: root, /app and /app/webroot folders must be RewriteBase / 
