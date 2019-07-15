# 📷 Photos Project

This project uses the following technologies:

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
2. Clone this project: `git clone https://github.com/iamandresdiaz/www.photos.io.git`
3. Move to the project folder: `cd www.photos.io`

#### 🌍 Application execution

1. Create a custom host inside `/etc/hosts` using `sudo vim /etc/hosts` and add `127.0.0.1  local-www.photos.io`
2. Install the App dependencies and bring up the Docker containers with the command `make build`
3. Run `make migration` to create a migration
4. Run `make migrate` to apply database migration
5. Open 2 or more terminal tabs inside the same project folder (photos)
6. Bring up the rabbitMQ consumers inside each terminal tab opened before and use the command `make consumer` inside 
each terminal tab
7. Go to [local-www.photos.io](http://local-www.photos.io:8080/) on your browser
8. Use the images provided inside the folder `./images` 
9. In order to see the original images and their filters you will need to use the search bar to show the results

#### 🔍 Profiling

1. Change the blackfire environment values inside `docker-compose.yml` to your own blackfire Client and Server keys
2. Run `make down` to turn down docker containers
3. Run `make build` if you haven't done it before, otherwise use `make start` to turn up the docker containers without an optimized project build
4. Run `make profile` to make a profiling of the application with blackfire

✅ The last Lighthose report can be consulted [here](http://local-www.photos.io:8080/performance/report_2019-07-11_00-56-23.html) 
but you need to run `make build` first in order to see the report
