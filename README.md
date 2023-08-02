

## Project Using:
    Laravel, Vue.js3 (composition api), Inertia js, Tailwind css(first time).

## Commands Used With Development:
    git init, git add , git ...... ( to use the git to upload the project on Github )

    create-project laravel/laravel project-name ( to create the laravel project from scratch )

    require laravel/breeze --dev ( to install breeze for authentications for the user )

    php artisan breeze:install vue --ssr ( to install vue with tailwind css inside the laravel project with breeze )

    npm i ( to install the packages of npm for vue )

    to run the project >>
        npm run dev ( to run only the client-side of frontend of vue with this command )
        php artisan serve ( to run only the server-side of backend of laravel with this command )

    npm i vue-material-design-icons ( to install the material-design-icons of vue package )

    npm i pinia pinia-plugin-presistedstate ( install pinia with inertia js )

    npm i @vueuse/core ( install the vueuse to make the infinite scrolling loading )

    npm install --save cropperjs ( install cropperjs Lib ) to make the crop for user images

    npm install laravel-precognition-vue-inertia ( install precognition vue inertia ) to make the live validation and live form in vue inertia.js


## Commands Used To Database:
    php artisan make:model Tweet -cm --resource ( make a model for tweet with resource )

    php artisan make:seeder Tweet TweetsSeeder ( make a seeder for testing tweets of the site )

    php artisan migrate:fresh ( to migrate the tables in the database if not exist and if exist drop it and re-run again )

    php artisan db:seed ( to insert the fake data to the database with seeding them )

## Visited Important Sites For Important Points in the project:
    A Quick Vue 3 Infinite Scrolling Component ( https://learnvue.co/articles/vue-infinite-scrolling ) {while scrolling it get rendering for more posts for the user}
