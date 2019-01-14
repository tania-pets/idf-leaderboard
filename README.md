# Welcome to the IDF Back-End Code Challenge!

This is a redis based leaderBoard implementation utilizing sorted sets.
Please update your .env with REDIS_HOST (copy .env.*.example)

When a grader evaluates an answer, a job is added to a queue in order to recalculate and update the user's score to redis.
The score is saved to mysql as well, but it's not used right now.

The leaderBoard is configurable from `config/leaderboard.php` file.

The architecture is flexible and makes the storage engine switch easy in the future.

You can find most of the code under ```app\LeaderBoard``` namcespace.

## Instructions

 - Install the app as described on your README.
 - Copy the updated .env.*.example to .env
 - Execute ``` php artisan leaderboard:seedcoursescores``` in order to fill the leaderboard with the scores calculated from seed's data.


## Unit Tests

The time wasn't enough for me and i added only 2 tests as a sample : (
Execute with: ```./vendor/bin/phpunit```
A mysql test connection is added to docker-compose for tests.

## About the test

The test was really good!
I was pleasantly surprised that you provided some code as a base. It's very common that things go wrong during a basic setup and much time can be lost.
Thank you for this!

It was challengeable. It's obvious that the one who wrote the specs was not the designer ; ) Every spec had it's own challenge.
I also liked the fact that it's not about some crazy algorithm that we'll never use in our lives (i am really bad with these), but it's a real life task.

*Not sure if this was on purpose but there were a couple of missing dependencies in some classes.
See this commit  https://github.com/tania-pets/idf-leaderboard/commit/0037612e94f6da8116aec59e0e9315eb7be22f30


Thanks a lot for your time and consideration!
