### Task Description
```
Create a program that will allow users to post comments, and view them in a chronological feed.
```

#### A quick definition: 
According to the internet, a chronological feed is used in social media platforms to display 
content to users via a timeline or newsfeed in a chronological format by displaying 
content with the `latest published content` first.

Terminologies as used in this app:

In order to avoid confusion, please take note of the following:
- A user can create a comment (think of this as a post or status update, twitter type thing)
- A user can add a comment to an existing comment (It is referred to as comment reaction in this app. Think of this as commenting on a tweet)

### Models and their relationships
- User [has a `hasMany relationship` with Comment and also a `hasmany` relationship with CommentReaction]
- Comment [has a `belongsTo` relationship with User and a `hasMany` relationship with CommentReaction]
- CommentReaction [has a `belongsTo` relationship with Comment and a `belongsTo` relationship with User]

### How I went about achieving a chronological feed
```
# My first consideration was returning a collection orderedby the updated_at field in descending order (latest to oldest). This didnt have any benefit because 
# the app does not provide a way to edit a comment. If it did, then the updated_field gets updated and the latest data is bubbled up.
# The collection is returned with its relationships like so:

$comments = Comment::with(['user', 'reactions'])->orderBy('updated_at', 'desc');

# This eagerloads the relationships with the Comment resource, under the hoods Eloquent 
runs two queries, the first to get the comments then the second a query to 
fetch the relatoinships from the other tables using a whereIn. Eagerloading is a better option
to avoid the n + 1 query issue. 

The question is now how do I ensure the comment gets updated when a users adds a response?
The simplest answer is to update the parent comment whenever a new response is submitted.

What my implementation achieved is:
- bubble up comments that have a response as a way to suffice relevant data to the user
```

## RUNNING THE APPLICATION LOCAlLY

Dev Setup
- clone the repository
- install dependencies and set app key

```
composer install && php artisan key:gen
```

- update your .env file (See .example.env)
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```

- Run the migrations
```
php artisan migrate
```

- running the app

I use Homestead, use whatever works for you. If you're using homestead, launch the app (ensure all your setup/config is done correctly)

Don't forget to keep the queues running.
```
php artisan queue:work
```

Additional setup:
- If you have issues accessing the app at this point , its not the app, 
its probably a caching issue or something, try:

```
composer dumpautoload && php artisan cache:clear && php artisan route:cache
```

Run the tests:
- From the root directory run
```
php ./vendor/bin/phpunit tests/
```

## In Summary, what was I able to finish?
- User register/login with username and password + validation
- User logout
- Guest access
- Chronological feed (paginated)
- Ability for a user to create a new comment [text and images (jpg, png, jpeg only)], 
respond to existing comments, delete only their own comment, like any comment
- Deleting a comment, deletes the resource and its relationships where cascading 
applies, also deletes the uploaded image from Storage disk
- Provide automated tests (Functional, Unit and Application)

## What is left:
- I have 2 failing tests.