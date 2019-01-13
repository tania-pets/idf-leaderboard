# Welcome to the IDF Back-End Code Challenge!

The main goal of this challenge is to get a sense of your coding style and choices.

The code challenge does not involve any exotic or bleeding-edge technologies, tools, etc. and that's the point: We'd like to focus on your code style and not get distracted. 

On that note, we're also not looking for "rights and wrongs", and there are no "trick parts" in this challenge. We would merely like to get a more profound impression of how you write code.

That also allows us to have a more fruitful and constructive discussion at the technical interview. We're not fans of white-boarding at interviews so we'd much rather have some concrete code to talk about. We think that makes the interview much more enjoyable and productive. 


## Your challenge/task
Imagine you're our new full-stack developer 🦄 and you just got a feature request!

You've just stepped into the middle of a conversation on a Github issue and here is what was said:

Our Designer (feature requester) wrote the following:
> Hey Devs.
>
> We would like to improve the gamification of our course platform because we think it will help keep our users more engaged - and thus learn more. We want to make learning just as addictive as playing a computer game! I would like your help and have you implement a "course leaderboard" section on the existing courses which displays a list of users and their points in that particular course. I will elaborate a bit on this below. Remember that each course has a slug based on the pattern `/courses/{course-slug}`, e.g. `/courses/beginners-guide-to-user-experience`).
>  
> This is an example of how the leaderboard section should look:
>
> ![image](https://user-images.githubusercontent.com/5278175/50387670-7e861400-0713-11e9-95fd-3f8c3316a070.png)
>
> Specifications of the leaderboard of a given course:
> - display a maximum of 9 users on the leaderboard of a given course
> - always display the 3 users with the **highest** score of a given course
> - always display the 3 users with the **lowest** score of a given course
> - always show the currently logged-in user's position in a section sourrounded by 2 other course participants. 
> - if a user has the **same** amount of points as another participant, then the currently logged-in user should be displayed higher than the other one with the same score as him/her. In other words, his/her position on the leaderboard should be "rounded up" if he has the same score as others.
> - logged-in user should be bolded


So, your goal now is to implement both front-end and back-end parts of this feature.


## What we will evaluate

There are no set-in-stone technical requirements for this feature.
The only requirement that is noticable by our users and visitors is performance.
Leaderboard data should always be up to date (any enrolment score can be changed by a course graders/examiners/assessors anytime (there is only one method from a Grading API, see `\App\QuizAnswer::evaluate()`)).

You can do everything you want in order to implement this feature:
 - Change the DB structure
 - Move significant parts of the logic to the DB 
 - Move significant parts of the logic to the back-end 
 - Move significant parts of the logic to the front-end, or load data by AJAX (if so, please use Vanilla JS or Vue.js) 
 - Move significant parts of the logic to ... Okay.. you get it... We don't want to limit your ideas :) 

We will be evaluating the following aspects:
 - Your ability to design the overall project architecture and keep it consistent with your implementation (note: frequent atomic commits are welcome!).
 - Your ability to write readable and reusable code with a clean API.
 - Performance of your solution (this page is pretty popular and we don't want to overload our server)

You are of course more than welcome to ask questions about this challenge in case you're in doubt about something or need more background information!


## How to setup working environment
This project is a simple Laravel 5.7 application.

In order to help you with initial setup we already added some basic code:
 - Routes, controllers and views
 - Migrations to create all required tables
 - Factories to create all entities
 - Database seeders to have enough information to display leaderboards


### A) Docker

For the docker environment we prepared a special `.env` file example: `.env.docker.example`.
In addition to that, we included a basic Docker Compose config.
So, if you are already a docker user, you simply need to execute the following commands:

```sh
# install composer dependencies 
docker run --rm --interactive --tty --volume $PWD:/app composer install

# Build, (re)create and start containers for a service.
docker-compose up

# Run all migrations and seed the DB
docker-compose exec workspace php artisan migrate:fresh --seed
```

If everything worked well, a project should be accessiable by [http://localhost:8880](http://localhost:8880).

Got problems? Help us improve this code challenge by writing to us. We're happy to help :-) 


### B) Local/Virtual Machine
```sh
# install composer dependencies 
composer install

# Run all migrations and seed DB
php artisan migrate:fresh --seed
```

### After installation done
Please log in at the `/login` page by using any auto-generated email address you can find in the DB.
The password for all auto-generated users is `secret`.

After successfull login you will be redirected to a page with a list of links to your course enrollments.
Please click any of the links and you will be redirected to a page where you should implement your this challenge, i.e. the leaderboard.


## How to submit your solution
Please submit your solution in a git repository.
You can use services like GitHub or Bitbucket.
Ideally, you could make an initial commit with the files of this code challenge and then build your solution upon that.

You can submit your solution in 2 ways:
 1. Use **public** git repository and send us the link.
 2. Use **private** git repository and send us the link (if you don't want to create a public repository for personal reasons).
 In this case, please provide read access for
 the following user: `idf-bot` (valid for [GitHub](https://github.com/idf-bot) and [Bitbucket](https://bitbucket.org/idf-bot/)).

Hint: both GitHub and Bitbucket allow you to create a private repository for free.

PS: I would greatly appreciate it if you kindly give us some feedback about this code-challenge: how it was interesting, challengeable, clean, etc. 

🦄
