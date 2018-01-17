# Dockerized wordpress

- latest alpine based php version with enabled opcache
- can be used as a template for WP project: just fork, change configs, setup volume for mysql
- prepared for containerized deployments: just extend docker image with your own, inject there plugins. statics

# How to use (checklist)

### 1. Copy or fork the project, use it as a template:
You can use the whole project as a template. Just copy-paste it or fork and remove `Dockerfile`. 
Adjust all the configs according to your needs. 

Many things are extracted into variables, so that
you just have to define variables. Configs can be also easily injected during instance creation.

### 2. Set up environment: 
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

### 3. Adjust nginx and php configurations
You have to adjust my default configuration with your own. Probably, you would want to define error reporting level,
set up more caching, ssl certificates, etc...

By default, host is `wordpress.localhost`.
 
### 4. Create volume for database file, tune up DB
You also must create a volume for mysql, otherwise you gonna loose all the data right after
instance termination.

Do not forget to tune up mysql to get maximum of performance.

>### Warning! 
>
>`docker-compose.yml` is just an example and must be modified according to your needs and security.

# How to contribute

- checkout your feature branch from the appropriate one
- make sure that you have the latest changes from remote repository
- make all the changes, create pull request, once it get merged, container would be re-deployed

# To make a test build on your local machine:

```
docker build --compress --pull --force-rm --tag oleksiichernomaz/wordpress:4.9.2 .
docker run -it oleksiichernomaz/wordpress:4.9.2 sh
```
