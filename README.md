# 📷 Photos Project

<h3 align="center">
  Photos Symfony + ReactJS application. 
</h3>

This project use technologies like:

* Blackfire
* Elasticsearch with elastica.io + kibana
* MySQL
* Symfony
* ReactJS (hooks) + react-dropzone/react-dropzone
* RabbitMQ with jakubkulhan/bunny + claviska/SimpleImage
* Redis

<!-- TABLE OF CONTENTS -->
## Table of Contents

* [🚀 Environment setup](#-environment-setup)
  * [🐳 Needed tools](#-needed-tools)
  * [🌍 Application execution](#-application-execution)
  * [🔍 Profiling](#-profiling)


## 🚀 Environment setup 

#### 🐳 Needed Tools

1. [Install Docker](https://www.docker.com/get-started)
2. Clone this project: `git clone https://github.com/iamandresdiaz/photos.git`
3. Move to the project folder: `cd photos`

### 🌍 Application execution

1. Create a custom host inside `/etc/hosts` using `sudo vim /etc/hosts` and add `127.0.0.1  local-www.photos.io`
2. Install App dependencies and bring up the project Docker containers: `make build`
3. Run `make migration` to make project migration
4. Run `make migrate` to apply database migration
5. Open 2 or more terminal tabs inside the same project route
6. Bring up the rabbitMQ consumers inside each terminal tab opened before and use the command `make consumer` inside 
each one
7. Go to [local-www.photos.io](http://local-www.photos.io:8080/) on your browser

### 🔍 Profiling

1. Change the blackfire environment values inside `docker-compose.yml` to your own blackfire Client and Server keys
2. Run `make down` to turn down docker containers
3. Run `make build` if you didnt do that before other wise use `make start` to turn up the docker containers
4. Run `make profile` to make a profiling of the application