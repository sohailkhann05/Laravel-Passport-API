## Frontend Steps

=>  Extract inside htdocs
=>  create database named `books_db`
=>  Run command `php artisan migrate --seed`, it will create random users, books {all users password is set to `password`}
=>  We need to create the encryption keys that are needed to generate our secure access tokens. So run command `php artisan passport:install`, incase if installed skip it
=>  go to database users table take any user email and login using 	`password` as password {default for all users}
=>  when login you can do Books CRUD operation from frontend views



## Postman Laravel Passport API
=> Open postman
=> find `Laravel Passport API.postman_collection.json` inside root directory, incase of bug i have included version-II json file as well.
=> import it
=> you will find all routes used for api
=> first step is to login user and get bearer `token`
=> set header `Authorization` with value `Bearer {API Token}`
=> e.g.
	`Authorization` => `Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiZmZlN2JhNzU5MzBmMGQwZmUyYjM2MjhhMGM3NWJkNzMzMDZkY2I0NGEwZGE0ZTM0OTU1MzZkMmExYzkxYzNmN2FlYWM2NzEyZjIzZGRkNDciLCJpYXQiOjE2MjQ5MDE2NjIuMTk1MDQxLCJuYmYiOjE2MjQ5MDE2NjIuMTk1MDQ2LCJleHAiOjE2NTY0Mzc2NjIuMTg4OTgzLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.LOgHUE3VghfSNzuEdYvlzAK_KmLfQhgn1tv9BbYdJGEmFRY2-xtXWGA8waLnXnZp4n-huSZZcYH8iFfh_5wt34c24YyiFDlym9_KP0LIivDMQqrkosbFh7X4EtyMuCyYFDmp6c9cmNeQRgDn7JvxgRk3k831O3pJZustgwrz_apilRArFt8xDlOEnc9tE34cjece3f5dWSsrNTJ63PuTL078OQwIYVeCSr1oBHh2N-5yUg3OR59ftsAV6D5pfVr5lEYod_k1ho7di2FTV-iySpE7CHsa4md1JGj5p6p8_91TKTwnmBJk43N5UtIAvelzMHc77AzqZUbhPOAq6BxmPuxzgMRXpKoJepBC3uDat9IiC7je_80404GjFMOhAgC06mTEH_kg7OYxVcqnZTO79t8NDEQbuA9Ur_9WlqrJU6Nin2JDbPltFd99xAnByuF1GpGetW8ol4DRTA_2R05JOA2ST0All-BrzW3Eoc2uPWioGDmv4BSBx-OGbZRdsfyFFvzM47E6ntsrR_icT7TvXGIYS5A_X09G0Gd6oEhF6EDrQZ5HvMdh0ofcDyk6dZlymG-MXosynRevPAFGd_kMjZKH2r6JW5hZztYRI6XponARUZd2QEO2k5vxsjzwmlu0UF2MhACvUDEjrpiauIKDwFuY980Ric9Y8_ZgwburdGk`
=> with each request pass the authorization header