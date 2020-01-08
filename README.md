If you have many projects, you may need a convenient data storage for logging in (sites, databases, ssh, etc.) and links.
This project provides you with an admin panel where you can create projects, save accounts, add users and configure access rights. You also get a browser widget. 

Install:
1) clone this project
2) run commands in root project dir:

`cp .env.dist .env`

`docker-compose up -d --build`

`docker-compose exec --user=www-data php bash`

`composer install`

`bin/console doctrine:migrations:migrate -n`

`bin/console app:db:init --admin-email=[you_email] --admin-password=[password]`

