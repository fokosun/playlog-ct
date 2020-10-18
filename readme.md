### Task Description
```
Create a program that will allow users to post comments, and view them in a chronological feed.
```

### A quick definition: 
According to the internet, a chronological feed is used in social media platforms to display 
content to users via a timeline or newsfeed in a chronological format by displaying 
content with the `latest published content` first.

### Terminologies as used in this app:

In order to avoid confusion, please take note of the following:
- A user can create a comment (think of this as a post or status update, twitter type thing)
- A user can add a reply to an existing comment (It is referred to as comment reaction in 
this app. Think of this as replying to a tweet)

### Models and their relationships
- User [has a `hasMany relationship` with Comment and also a `hasMany` relationship with CommentReaction]
- Comment [has a `belongsTo` relationship with User and a `hasMany` relationship with CommentReaction]
- CommentReaction [has a `belongsTo` relationship with Comment and a `belongsTo` relationship with User]

### The Feed Service
```
- The feed service bubbles up the latest comments by ordering the comments by the `updated_at`
field in descending order. That way, the latest comments stay at the top.

- When a comment gets a reply (reaction), the comment needs to be notified of this update. 
To achieve this, the comment's `updated_at` field is set to the current datetime stamp when 
a new reaction(reply) is created and saved.

- The feed service eagerloads the comments with its `user` relationship and also paginates by 
limiting the collection to a specified value. This helps avoid the n + 1 query situation 
and boosts user experience in terms of the response duration respectively.
```

## RUNNING THE APPLICATION LOCALLY

I use [Laravel Homestead](https://laravel.com/docs/6.x/homestead), use whatever works for you. If you're using homestead, 
launch the app (ensure all your setup/config is done correctly)

Dev Setup
- clone the repository
- install dependencies and set app key

```
composer install && php artisan key:gen
```

- update your .env file (See .example.env)
```
APP_DEBUG=false

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
Interested in seeing the query logs, set `APP_DEBUG` to true.

- Run the migrations 
```
php artisan migrate
```

- Seed the database (optional)
```
php artisan db:seed
```

- For image uploads to be successful, the queues need to be running.
```
php artisan queue:work
```

Additional setup:
- If you have issues accessing the app at this point , its likely a caching issue or something.
Try any or a combination of the following:

```
composer dumpautoload 

php artisan cache:clear

php artisan route:cache

php artisan config:clear
```

Running the tests:
- From the root directory run
```
php ./vendor/bin/phpunit tests/
```

## In Summary, what was I able to finish?
- User register/logout/login with username and password + validation
- Chronological feed (paginated) - the comments are displayed with the latest published content. 
The comment reactions too are also displayed in the same order with the newest comments always at 
the top.
- Ability for a user to create a new comment [text and images (jpg, png, jpeg only)], 
respond to existing comments
- Delete only their own comment
- Like any comment
- Deleting a comment, deletes the resource and its relationships where cascading applies, 
also deletes the uploaded image from Storage disk.
- Provide automated tests (Functional, Unit and Application).

## What I would add if I had more time
- The ability to view a page to display all the replies (reactions) to a comment by 
clicking on the `see all` button

## More:

- If you have `APP_DEBUG` set to true, and you encounter any issues viewing the app, 
repeat the steps in the additional setup above.
