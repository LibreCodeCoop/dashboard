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

run:
```bash
docker-compose up
docker-compose down
docker-compose up
```

PS: Is necessary run up, down and up now because in the first up is created an environment.

open http://localhost

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
 * `resources/sass/invoice.scss`

If you want more CSS customizations, change the file `resources/sass/app.scss`

After change, restart nodejs container to build assets:
```bash
docker-compose restart nodejs
```

## Contributing

Read the [contributing](/CONTRIBUTING.md) file first.

Look the project [issues](/../../issues) and the [tasks](/../../projects) board
