Timelet (C) 2007 Matias Muhonen
Modified by Mike Arvela

REQUIREMENTS:

- PHP4+
- PEAR DB in include path

SETUP:

1. Create a database
2. Add appropriate database options into inc/prepend.php
3. Set baseurl directive in config.inc.php (URL relative to server root)
4. Create users into database and password for each user using htpasswd
5. Give HTTP server write permissions to both tmp/templates_c and tmp/cache