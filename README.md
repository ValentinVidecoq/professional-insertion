# Professional insertion of old students

I worked on this project with 2 other student in 2019

To navigate through the website you'll need Wamp (or Mamp on Mac) :
- Download the folder and put it in the Wamp `www` folder
- In phpMyAdmin, using MySQL, create a new database named `ip` and import the file `bdd.sql` into it
- If your credentials to log in phpMyAdmin are different from the default Username : `root` & no password, you'll need to modify the database connection variable in `inc/bdd.php` like this : `$bdd = new PDO('mysql:host=localhost;dbname=ip;charset=utf8', '`username`', '`password`' , array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));`
- Now you can start Wamp and access the website
