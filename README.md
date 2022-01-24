# simple_form

Simple Form is a simple application where users can add posts with a message and a file upload.

To create a post the user needs to to enter a valid username/password (User: admin, Pass: password)

There is client side validation on all fields.

Valid posts are stored in a mysql database, and files are uploaded to the server.


The form is built with Bootstrap 5, the client side validation is done with jQuery, there are no PHP dependencies.

## Requirements 

- PHP 7.4
- MySQL 

## Install

- Downlaod Repo
- import sql file to new mysql database
- `mv sample-config.php config.php`
- edit config.php with correct db credentials 
- You can serve the app with any web server, (to use php built in dev server run `php -S localhost:8000`)

**User:** admin
**Pass:** password

