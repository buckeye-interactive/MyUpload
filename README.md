# Building a Docker image for your organization

In order to build a custom Docker image for your organization, you must have at least `docker` installed. There are convenience scripts written that will build and deploy the images as long as you have `make` installed. It is also recommended to have `docker-compose` installed for ease of running and managing the docker containers.

- docker: https://docs.docker.com/get-docker/
- docker-compose: https://docs.docker.com/compose/install/
- make: available through linux package managers (ie. `sudo apt-get install make`)

Clone the repository, navigate to the `build` directory and run this make command:

`make build PRIMARY_COLOR=#ff0000` - Replacing `PRIMARY_COLOR` with your organization's primary color.

This creates a customized Docker image

# Running your customized Docker image

The simplest way to run your new image is to use the `docker-compose` files that are in the `build` folder. There are 3 different docker-compose files based on what type of environment you are running in:

- docker-compose: This is the default script and should be run only in development.
- staging.docker-compose: Should be run on staging sites.
- production.docker-compose: Should be run on production sites.

There are many different environment varibles that can be used to customize the application. The simplest way to add environment variables is to create a `env.mk` file in the `build` folder. The following is an example of a production `env.mk` file:

```
export COMPOSE_FILE=production.docker-compose.yml
export EXPOSE_PORT=3000
export APP_URL=https://production-url.com
export APP_NAME=MyUpload
export DB_HOST=db
export DB_DATABASE=myupload
export DB_USERNAME=myupload_admin
export DB_PASSWORD=change_password
export DB_PORT=5432
export MAIL_DRIVER=mailgun
export MAILGUN_DOMAIN=mg.example.com
export MAILGUN_SECRET=your-mailgun-secret
export MAIL_FROM_ADDRESS=info@myupload.com
export MAIL_FROM_NAME=MyUpload
export MEMCACHED_HOST=memcached
export CACHE_DRIVER=memcached
export SESSION_DRIVER=memcached
export RECAPTCHA_SITE=your-recapcha-site-key
export RECAPTCHA_SECRET=your-recapcha-site-secret
export GA_PROPERTY_ID=your-GA-id
export PRIMARY_COLOR=\#de5431
export LOGO=https://mysite.com/logo.png
export COPYRIGHT=Copyright © 2020 Company Name. All rights reserved.
export CONTACT_INFORMATION=Street Address, City, State Zip (Phone Number)
export USAGE_VERBIAGE=I authorize Company Name to use these images
```

An `env.mk.example` file is also in the `build` folder to show the fewest environment variables that can be set while still having a functional application.

After creating this `env.mk` file, running `make up` from the `build` folder will create all of the Docker services listed in the docker compose file. (`make down` does the opposite, stopping and removing all docker containers listed in the compose file)

Once the docker containers are running, the last thing that needs to happen is proxying all requests to the exposed port in the `env.mk` file. This can be done with a web server running on the server that you are hosting the docker containers on. The recommended web server for this is Nginx.

## Available Environment Variables

| Name                | Description                                                                                                                                                  | Default                                             |
| ------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------ | --------------------------------------------------- |
| APP_DEBUG           | Whether or not the application is in debug mode                                                                                                              | false                                               |
| APP_ENV             | The current environment running the application (local, staging, production)                                                                                 | production                                          |
| APP_KEY             | The encryption key used throughout the application, a new one can be generated by running `php artisan key:generate --show` from within the docker container | base64:sK6yeEl2XZPPVsXbfFEcID7rxc2wNSBCUONwGwSmMuY= |
| APP_LOG_LEVEL       | The lowest level of logging that will be written to the log file (debug, info, notice, warning, error, critical, alert, emergency)                           | warning                                             |
| APP_NAME            | The name of the application, used in multiple public facing aspects of the site                                                                              |                                                     |
| APP_URL             | The url of the application, used in generating links in emails and other public facing communication                                                         |                                                     |
| CACHE_DRIVER        | The driver used to cache information for the application - documentation here: https://laravel.com/docs/6.x/cache                                            | file                                                |
| CONTACT_INFORMATION | The contact information text in the footer of the application                                                                                                |                                                     |
| COPYRIGHT           | The copyright text in the footer of the application                                                                                                          |                                                     |
| DB_CONNECTION       | The type of database connection (mysql, sqlite, pgsql, sqlsrv)                                                                                               | pgsql                                               |
| DB_DATABASE         | The database that the application will store all of its information in                                                                                       |                                                     |
| DB_HOST             | The database host the application will connect to                                                                                                            |                                                     |
| DB_PASSWORD         | The database password                                                                                                                                        |                                                     |
| DB_PORT             | The database port                                                                                                                                            |                                                     |
| DB_USERNAME         | The database username                                                                                                                                        |                                                     |
| EXPOSE_PORT         | The port to serve the application from                                                                                                                       |                                                     |
| GA_PROPERTY_ID      | The google analytics account ID in the application                                                                                                           |                                                     |
| LOGO                | The logo (as a url) used in the header of the application                                                                                                    |                                                     |
| MAIL_DRIVER         | The way that the application will send email - documentation here: https://laravel.com/docs/6.x/mail                                                         | log                                                 |
| MAIL_ENCRYPTION     | The encryption protocol that the application will use to send email                                                                                          | tls                                                 |
| MAIL_FROM_ADDRESS   | The "From" address that all emails from the application will be sent from                                                                                    |                                                     |
| MAIL_FROM_NAME      | The "From" name that all emails from the application will be sent from                                                                                       |                                                     |
| MAILGUN_DOMAIN      | If using the `mailgun` driver, the mailgun domain to send mail from                                                                                          |                                                     |
| MAILGUN_SECRET      | If using the `mailgun` driver, the mailgun secret to send mail from                                                                                          |                                                     |
| MAIL_HOST           | The host to send mail from                                                                                                                                   |                                                     |
| MAIL_PASSWORD       | The password for the mail sending service                                                                                                                    |                                                     |
| MAIL_PORT           | The port for the mail sending service                                                                                                                        |                                                     |
| MAIL_USERNAME       | The username for the mail sending service                                                                                                                    |                                                     |
| MEMCACHED_HOST      | If using memcached for either cache or session, the host of the memcached server                                                                             |                                                     |
| PRIMARY_COLOR       | The primary color (in hex) used throughout the application                                                                                                   |                                                     |
| RECAPTCHA_SITE      | The Recaptcha (v2) site key for the application                                                                                                              |                                                     |
| RECAPTCHA_SECRET    | The Recaptcha (v2) secret for the application                                                                                                                |                                                     |
| SESSION_DRIVER      | The driver used for sessions in the application - documentation here: https://laravel.com/docs/6.x/session                                                   | file                                                |
| USAGE_VERBIAGE      | The verbiage used when asking a user if they authorize the application to use their uploads                                                                  |                                                     |
| WEB_REPO_NAME       | The docker registry where the application's docker image will be stored                                                                                      |                                                     |

## Initial Database Setup

Before you can use the site, all of the database tables must be created. Running `make setup-environment` will run all of the database migrations and seed the database with 1 admin user. This user's email is `admin@test.com` and its password is `password`. This email / password can be changed by logging into the portal (via the /login route) and visiting the account settings page.
