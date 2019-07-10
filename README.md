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

### 🌍 Profiling

export BLACKFIRE_CLIENT_ID=3622b39f-ea96-43e1-b209-9ccbb1e4d575
export BLACKFIRE_CLIENT_TOKEN=eed7d05d9fdb206ebdbd7140f5a7369fe86e28f0001bd5330bfd988404ed31b4
export BLACKFIRE_SERVER_ID=4750c8df-009b-4b8c-89a0-b2ba1d34b4c4
export BLACKFIRE_SERVER_TOKEN=5f0564a2e75a206b01d276895b1ebd7e52cbe5451ddcdf2f833617177e50bd3d

docker exec photos-blackfire blackfire curl --proxy http://photos-nginx:80 http://www-local.photos.io/