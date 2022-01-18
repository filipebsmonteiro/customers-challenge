Instructions
========================

Welcome!

To Run my application it will be needed 2 phases:

1. [Configure the environment!][1]
2. [Configure the Database!][2]

==============================================

Configure the environment
======================
All the projects have been setup in Docker to make easier, so copy the environment file:

```
$ cp .env.example .env
```

Copy your USER and UID

```
$ echo ${USER}; echo ${UID}
```

Paste in the end of .env file

```
USER={YOUR USER}
UID={YOUR UID}
```

Open your \etc\hosts file

```
$ sudo nano /etc/hosts
```

Add this domain in the end:

```
127.0.0.1   customerschallenge.local
```

Configure the Database!
==============================================
To configure the Database if mandatory to make all steps of the Environment Configuration.

In the root path of the project run these commands in sequence:

```
$ docker-compose up -d
$ docker exec -it customers_challenge-php /bin/bash
$ composer install
$ composer du
$ php artisan migrate
$ php artisan optimize
$ exit
```

Last but not Least
==============================================
There is one Postman Collection in the root directory that can be used to test the application.

Enjoy!

[1]: #configure-the-environment

[2]: #configure-the-database
