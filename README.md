# 📷 Photos Project

<p align="center">
    <a href="#"><img src="https://img.shields.io/badge/Symfony-4.2-purple.svg?style=flat-square&logo=symfony" alt="Symfony 4.2"/></a>
</p>
<p align="center">
  Photos PHP + Symfony + ReactJS application. 
</p>

<!-- TABLE OF CONTENTS -->
## Table of Contents

* [🚀 Environment setup](#-environment-setup)
  * [🐳 Needed tools](#-needed-tools)
  * [🛠️ Environment configuration](#-environment-configuration)
  * [🌍 Application execution](#-application-execution)


## 🚀 Environment setup 

#### 🐳 Needed Tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `git clone https://github.com/iamandresdiaz/photos.git`
3. Move to the project folder: `cd photos`


### 🛠️ Environment configuration

1. Modify the environment variables if needed: `vim .env`


### 🌍 Application execution

1. Install PHP dependencies and bring up the project Docker containers with Docker Compose: `make build`
2. Log in to PHP container bash `docker exec -it php /bin/bash`
3. Run `php bin/console make:migration` to make project migrations
4. Run `php bin/console doctrine:migrations:migrate` to create database tables for the project