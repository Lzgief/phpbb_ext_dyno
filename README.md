# Module for connecting forum phpBB3 and housing-related website.
The main aim of the website is to educate tenants about their rights as homeowners and ensure the possibility of communicating via the forum. 

## Project description
The module is fulfilling the following functionalities:
* on search adding house address to the BD of phpBB and forum page corresponding to this house
* on authentification on main website user automatically authenticates in phpBB
* on registration on the main website as a tenant of a house user automatically registers in phpBB at according to forum 
* automatically rights distribution according to the process of registration


## Important code
All latest project-related files are contained in folder **nashdom_module/**.

File **choice.php** after user search for a house at address checks if that address exists in phpBB database if not adds forum cascade.

File **add_forum.php** contains the necessary forum page structure. When called, adds a forum to the phpBB database.

File **login.php** checks if the user is authenticated, if not tries to authenticate, if not suggests to fill in for registration, on registration adds user data to phpBB database.
File *login_copy.php* is an old test version. File *login.html* is HTML form for registration.

File **reg_standart.js** contains few rows for sending posts with user data to "login.php"

File **verify.php** compares user's input and hash in phpBB database for authentification and registration purposes.

Folder **gaip/** belongs to my colleague.
Folder **dyno/** was used for tests with phpBB.

## Technologies used

[**phpBB3**](https://github.com/phpbb/phpbb) v3.3.x - open-source bulletin board with huge community

Framework [**Symfony**](https://github.com/symfony/symfony) v2 - base for phpBB 

