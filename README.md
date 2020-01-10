![GitHub](https://img.shields.io/github/license/lyseontech/dashboard)

# Administrative dashboard

Administrative dashboard made with PHP

The first version of the dashboard will be to serve VoIP enterprise customers.

There are 2 types of users:
administrators and users associated with customers.

Users should log in to the system and view invoices and recording audios of all customers they have.

The project needs to be internationalized. Do not display any text to the user that cannot be translated.

## Instructions to getting run

Make sure port 3306 and 80 are free.

Create `.env` file from `.env.example`
Create `docker-compose.yml` file from `docker-compose-example.yml`

> PS: If you don't use internal database, remove the `db` service.

run:
```bash
docker-compose up
docker-compose down
docker-compose up
```

open http://localhost

## Run in production

* Remove the `mailhog` service from `docker-compose.yml`
* Remove environment of xdebug from `docker-compose.yml`
* Remove instalation xdebug lines from `.docker/php7/Dockerfile`

## Customize

### Images

Look images in this folders and change:
 * `public/image/`
 * `public/material/image/`

### CSS and colors
Change the file `public/material/scss/material-dashboard/variables/_brand.scss`

using the vars from

 * `public/material/scss/material-dashboard/variables/_colors.scss`
 * `public/material/scss/material-dashboard/bootstrap/scss/_variables.scss`

If you want more CSS customizations, change the file `resources/sass/app.scss`

**Invoice customizations:**
 * `resources/sass/invoice.scss`

After make all customizations, restart nodejs container to build assets:
```bash
docker-compose restart nodejs
```

## Contributing

Read the [contributing](/CONTRIBUTING.md) file first.

Look the project [issues](/../../issues) and the [tasks](/../../projects) board
