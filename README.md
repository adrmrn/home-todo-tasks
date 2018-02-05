# Home TODO Tasks
***The project hasn't been finished yet***

Create own group and the board, add family members and start to manage your housework together! As a parent reward relatives with points which can be changed into little gifts then.

## Back-end description
The project main goal is to create and maintain application based on Domain Driven Design, SOLID and CQRS. Bounded Contexts have been divided as separated modules in the app.

## Technology and tools
- Zend Framework 3
- Apigility - API service (REST/RPC)
- Doctrine
- PostgreSQL
- MongoDB - logs projections for Read/View Models
- RabbitMQ - message queuing - sending events
- JWT - authentication
- Vagrant - dev environment

## Installation
> #### Vagrant and VirtualBox
>
> The vagrant image is based on ubuntu/xenial64. If you are using VirtualBox as
> a provider, you will need:
>
> - Vagrant 1.8.5 or later
> - VirtualBox 5.0.26 or late

1. Install Vagrant and VirtualBox
2. Clone repository
3. Run ```$ vagrant up```
4. Install dependencies ```$ vagrant ssh -c 'composer install'```
5. Enable development mode ```$ composer development-enable```
6. Enjoy!

*In case of problems, for more information about an installation look at [ZF3 documentation](https://github.com/zendframework/ZendSkeletonApplication)*

## Running Unit Tests
You can run the tests using:

```bash
$ ./vendor/bin/phpunit
```