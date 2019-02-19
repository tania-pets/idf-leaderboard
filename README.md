# Laravel redis based leaderboard

This is a redis based leaderBoard implementation utilizing sorted sets.

When a grader evaluates an answer, a job is added to a queue in order to recalculate and update the user's score to redis.
The score is saved to mysql as well, but it's not used right now.

The leaderBoard is configurable from `config/leaderboard.php` file.

The architecture is flexible and makes the storage engine switch easy in the future.

You can find the main LeaderBoard code under ```app\LeaderBoard``` namcespace.

## Installation

 ```sh
# clone the project
git clone https://github.com/tania-pets/idf-leaderboard
# cd into project dir
cd idf-leaderboard
# put the .env file
cp .env.docker.example .env
# build an launce the docker container
docker-compose up -d
# install composer dependencies 	
docker-compose exec workspace composer install
# generate app key
docker-compose exec workspace php artisan key:generate
# Run all migrations and seed the DB
docker-compose exec workspace php artisan migrate:fresh --seed
# Seed the redis with leaderboard data
docker-compose exec workspace php artisan leaderboard:seedcoursescores
```
You should be able to access the project at [http://localhost:8880](http://localhost:8880).
Login as demo@demo1.com, pass: secret

## Unit Tests

Only 2 tests as a sample : (

Execute with: ```docker-compose exec workspace ./vendor/bin/phpunit```
A mysql test connection is added to docker-compose for tests.
