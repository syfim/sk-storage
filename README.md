If you have many projects, you may need a convenient data storage for logging in (sites, databases, ssh, etc.), links and life monitoring systems.

What is included in sk-storage:

- Admin panel for creating and editing projects, accounts, users, access rights and monitoring settings
- A page for viewing monitoring data and accounts
- Breakdown notification system based on project monitoring (email, sms (future))
- Configured set of software for deploying applications (NGINX, mysql, php-fmp, phpmyadmin (if you need)). 

In sk-storage all sensitive user data is stored in the database in encrypted form (default is `Halite`, but you can change crypto algorithm)


### Install

1) clone this project
2) run commands in root project dir:

```bash
cp .env.dist .env
docker-compose up -d --build
docker-compose exec --user=www-data php bash
composer install
bin/console doctrine:migrations:migrate -n
bin/console app:db:init --admin-email=[you_email] --admin-password=[you_password]
```

3) Open `localhost:8001` and sign in like admin from the previous step (you can change port in `docker-compose.yml` file


### Usage
