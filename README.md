# Punks & Pints API

---

## Screenshots


---

## Summary

This project is a Laravel application designed to provide an authenticated frontend to the (Punk API)[https://punkapi.com/documentation/v2]. Users can login and register, at which point they will have full access to the paged library of beers available at the Punk API. It provides filtering options for all available fields and will reflect changes as-you-type while trying to respect the rate limits imposed by the API.

In addition to being able to view and filter a list of all beers with their basic attributes, each item can be clicked to display the full breakdown.

When viewing the details for a beer you can click the handy save icon in the upper right corner of the modal to save a local copy of the beer to your favourites along with its food pairings.

## Design Decisions

**Project**:

This project is using Laravel Sail to make local development plain sailing 🥁. It is based on PHP 8.3 and MySQL and it is generally always my preference to leverage Docker for repeatable, isolated environments. Be that via Sail or a custom Ansible/Makefile led docker-compose.

I also installed `laravel/pint` to test for proper Laravel Code Styling and `larastan/larastan` for error checking.

**Authentication**: 

Leverages Laravel Breeze for a simple, quick SPA authentication setup. However i have gone one step further and utilised Laravel Sanctum to generate authentication tokens. A custom UI panel has been added to the Profile (`/profile`) page which will allow you to generate (and revoke) API tokens for use with any web client.  

**Frontend Framework**: 

Inertia.js was chosen to help bridge the gap between Laravel and Vue, enabling direct routing to Vue components and various form helpers for development velocity.

**Vue.js Components**:

Individual Vue components are children of full-page Inertia components with communication between siblings via parent components or via the Pinia global store for the search filters.

**Styling**:

Tailwind was used for styling, this is the default for the scaffolding but it is excellent and allows me to iterate very quickly alongside Vite. I have created some basic layers in `app.css` and extended the color palettes to provide a cute `ipa` theme.

**Backend Logic**: 

Utilised mostly single-action Laravel controllers, taking advantage of as much that the framework has to offer as I could. You will find `FormRequest` objects for all relevant requests, factories for all the models and 
custom `Responsables` for consistent API response objects among other things.

**Documentation**: 

I have used Swagger to document the sites API endpoints, including their parameters and response examples. It is accessible at `/api/documentation`. One side benefit of single action controllers for this is that our in-line OAPI spec is nice and self-contained and we don't end up with 12,000 line controllers.

If changes are made to the code docs, the swagger file can be regenerated with `sail artisan l5-swagger:generate`

## Getting Started

To run the project locally, follow these steps:

1. **Clone the Repository**: `git clone git@github.com:broakenmedia/punks-and-pints-api.git`
2. **Install Dependencies**: `sail composer install && sail npm install`
3. **Set Up Environment Variables**: `cp .env.example .env && sail artisan key:generate`
4. **Start the Development Server**: `sail up -d` (for Laravel) and `sail npm run dev` (for frontend assets)
5. **Run Migrations and Seed**: `sail artisan migrate:fresh --seed`

I have seeded a basic user account for you to make testing easier. See `database/seeders/DatabaseSeeder.php` for the credentials

## Notes

As you might expect, I have focussed on trying to demonstrate a breadth of skills in this project rather than depth given the time available.
I wasn't able to come up with a fully fleshed out world-build for the site but i've basically imagined it as an Admin panel for a shop looking to purchase stock from Brewdog for their pub/store.

In order to get some eloquent/model usage into the project i went with the idea that the person would like to save different beers for comparison later on. You can click save when viewing the full details about a beer.
In the interest of time/simplicity i have not implemented a screen for displaying said saved items. I felt this would just re-demonstrate the same skills used in the other components.

I fully implemented the "Random Beer" endpoint along with tests etc but i have not surfaced it on the frontend. It is of course documented via swagger and available for other people to use though!

There are certainly things i'd do differently in a production environment. For example having generated API tokens expire by default, cache API responses, add more specific error messages for validation failures and possibly even build on Livewire due to the simple nature of the client UI interactions.

## Points of Interest (Not exhaustive)

`[127.0.0.1/punk.local]/api/documentation`

`resources/js/Components/Punk` 

`resources/js/Pages/Dashboard.vue`

`resources/js/Pages/Profile/Partials/ApiTokenForm.vue` (Api Token Generation Component)

`tests/Feature/Api`

`resources/js/Stores` (Pinia)

`database/factories`

`app/Http/Integrations/Punk` (Punk API Connector)

`app/Facades/PunkFacade.php`