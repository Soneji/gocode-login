# gocode-login

<img src="https://repository-images.githubusercontent.com/230995457/e8e6e580-ba69-11ea-8697-65ebf34d2e1f">

## About
Student database system with docker support allowing the students to log in and out when they come and leave a location like a register. Ideal to run on iPads/tablets. Screenshots below!

## Setup

### Docker

```
git clone https://github.com/overclockedllama/gocode-login.git

docker-compose up -d
```

You should now have an app successfully running at `http://localhost:6989`

#### MariaDB (MySQL) Data Directory
The MariaDB data will be stored in `./mariadb/mariadb-data`

#### Change port (Optional)

* To change the port gocode-login runs at edit `docker-compose.yml`

* Find the lines containing: `ports:  - 6989:80` and change the 6989 to any port of your choosing

#### Reverse Proxy (Optional)

To setup a domain name and optional SSL you can use a reverse proxy.

Some reverse proxy options are:
* Apache
* Nginx

I like nginx so there is an example nginx config file at `nginx-sample.conf`

You can use this sample config file to help set up your reverse proxy with a letsencrypt.org certificate.

### Manual Setup
The software can also be setup on a standard LAMP server. You will need to configure some stuff manually however.

#### MySQL or MariaDB
You will need to create a new table called gocode in a MySQL or MariaDB database server. You can configure the file `./php/src/dbconnect.php` must to connect to your MySQL or MariaDB server.

#### PHP Source
The source php files are found at `./php/src/...` These must be copied to your webroot. You must also have some HTTP server with PHP execution software such as Apache or Nginx with php-fpm.

## Screenshots
### User Inerface
![ScreenShot1](/screenshots/1.png)
![ScreenShot2](/screenshots/2.png)
![ScreenShot3](/screenshots/3.png)
![ScreenShot4](/screenshots/4.png)
![ScreenShot11](/screenshots/11.png)
### Admin Panel
![ScreenShot5](/screenshots/5.png)
![ScreenShot6](/screenshots/6.png)
![ScreenShot7](/screenshots/7.png)
![ScreenShot8](/screenshots/8.png)
![ScreenShot9](/screenshots/9.png)
![ScreenShot10](/screenshots/10.png)
