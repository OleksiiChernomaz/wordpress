# Dockerized wordpress

- latest alpine based php version with enabled opcache
- can be used as a template for WP project: just fork, change configs, setup volume for mysql
- prepared for containerized deployments: just extend docker image with your own using as example `wp-app` dockerfile, inject there plugins. statics

# How to use (checklist)

### 1. Copy or fork the project, use it as a template:
You can use the whole project as a template. Just copy-paste it or fork and remove `Dockerfile`. 
Adjust all the configs according to your needs. 

Many things are extracted into variables, so that
you just have to define variables. Configs can be also easily injected during instance creation.

### 2. Create own wordpress application
Example of the `Dockerfile` for your wordpress application you can find in the `Dockerfile-wordpress`, how to use it
you can find out in the `docker-compose.yml`: search fro the `wp-app` application definition.

### 3. Set up environment for your WP application: 
Variables are extracted into `.env` file. Example of this file you can find in the `.env.dist`.

```bash
cp ./.env.dist ./.env
```
Adjust this env file with your passwords, tokens, hosts, etc. 

Also, using env file you can inject wordpress config constants.
Available wordpress constants are:
```php
DB_NAME
DB_USER
DB_PASSWORD
DB_HOST
DB_CHARSET
DB_COLLATE
AUTH_KEY
SECURE_AUTH_KEY
LOGGED_IN_KEY
NONCE_KEY
AUTH_SALT
SECURE_AUTH_SALT
LOGGED_IN_SALT
NONCE_SALT
WP_DEBUG
ABSPATH
WP_TABLE_PREFIX
```
Also, on the top of it, if some your plugins require additional defined constants you can inject any environmental 
variable with prefix `WP_`.

### 4. Adjust nginx and php configurations
You have to adjust my default configuration with your own. Probably, you would want to define error reporting level,
set up more caching, ssl certificates, etc...

By default, host is `wordpress.loc`.
 
### 5. Create volume for database file, tune up DB
You also must create a volume for mysql, otherwise you gonna loose all the data right after
instance termination.

Do not forget to tune up mysql to get maximum of performance.

### 6. Create folders for statics files and plugins
There are many different ways how to handle static. One of them: you can put all of them into the WP application.
In this case you would have only one image, which is contain all the stuff. Negative side is that docker image can be huge.

Another way is to use assets volume and put uploads into the assets volume.
Whatever way you would choose, you need to track files with any `cvs` (for example, git).

> ### Notes for lazy
>
> You can make automated builds, just set up docker images auto-build on each push in repo. Make automated push when
> filesystem change for static assets is detected. In this case your image would always contain the latest data.

>### Warning! 
>
>`docker-compose.yml` is just an example and must be modified according to your needs and security.

# How to contribute

- checkout your feature branch from the appropriate one
- make sure that you have the latest changes from remote repository
- make all the changes, create pull request, once it get merged, container would be re-deployed automatically

# To make a test build on your local machine:

```
docker build --compress --pull --force-rm --tag oleksiichernomaz/wordpress:4.9.2 .
docker run -it oleksiichernomaz/wordpress:4.9.2 sh
```
