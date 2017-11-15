# I Want Some Food

[![Build Status](https://travis-ci.org/nepda/iwsf.png?branch=master)](https://travis-ci.org/nepda/iwsf)


A simple proof-of-concept application which makes use of some [prooph](https://github.com/prooph) components.

May be this project will die as baby. But I'm looking forward to some experiments with DDD, Event Sourcing, CQRS and
Microservices and maybe TDD. **Any suggestions are welcome!**. I'm currently new with these techniques.

[Product vision](https://martinfowler.com/articles/lean-inception/write-product-vision.html):

* **For** small teams at any company/organisation
* **whose** want to eat something for lunch, ordered by any local supplier,
* **the** IWantSomeFood app
* **is a** small web application
* **that** helps to organize the process of ordering and "billing".
* **Different from** separate ordering of each person and on each supplier
* **our product** will unify the process of searching for meals and ordering them.


## Features/Goals

* [ ] Add new meals
* [ ] Add new suppliers
* [ ] Configure suppliers to deliver some meals at specific price and menu card number
* [ ] Register new user
* [ ] Manage users (?)
* [ ] Any use can sign-up for todays order 
* [ ] Get notification when some one want to order today
* [ ] Get notification when enough users signed up
* [ ] As user, order a meal for today (with optional notes for specials)
* [ ] Assign one assignee for todays order
* [ ] Close sign-ups for today
* [ ] Do the order/mark as ordered


## Installation

### 1. Clone / copy files

    git clone https://github.com/nepda/iwsf.git
    composer install

### Testing

    php vendor/bin/phpunit


## Run some basic scripts

    php scripts/create_event_stream.php
    php scripts/create_some_meals.php
