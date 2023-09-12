# Installation

- Install docker and docker-compose
- Create a .env file with following variables

```
IP=127.0.0.1
DB_ROOT_PASSWORD=yoursecretpassword
DB_NAME=wordpress
```

- Run `docker-compose up`
- Access using `http://localhost/`

## Wordpress CLI Usage

- Run `docker-compose run --rm wpcli <command>`
