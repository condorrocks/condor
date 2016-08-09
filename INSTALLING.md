# Installing

* [Step 1: Get the code](#step1)
* [Step 2: Use Composer to install dependencies](#step2)
* [Step 3: Create database](#step3)
* [Step 4: Install](#step4)
* [Step 5: Start Page](#step5)

<a name="step1"></a>
## Step 1: Get the code

    git clone https://github.com/condorrocks/condor.git

    cd condor

-----
<a name="step2"></a>
## Step 2: Install dependencies with Composer

    composer install

-----
<a name="step3"></a>
## Step 3: Create the Database

Condor officially supports MySQL and PostgreSQL database engines.

### MySQL

Create the database with `utf-8` collation (`utf8_general_ci`).

```
CREATE USER 'condor'@'localhost' IDENTIFIED BY 'a_strong_pass';
CREATE DATABASE 'condor' CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT ALL ON 'condor'.* TO 'condor'@'localhost' IDENTIFIED BY 'a_strong_pass';
```

### PostgreSQL

```
CREATE ROLE condor WITH LOGIN;
CREATE DATABASE condor WITH OWNER condor;
REVOKE CONNECT ON DATABASE condor FROM PUBLIC;
GRANT CONNECT ON DATABASE condor TO condor;
\password condor
```

-----
<a name="step4"></a>
## Step 4: Configure the Environment

**Copy** the **.env.example** file to **.env**

    cp .env.example .env

**Edit** the `.env` file and set the database configuration among the other settings.

Set the application key

    php artisan key:generate

**Edit** all the Primary section parameters (for *local/test/development environment*)

Back to your console, **migrate** database schema

    php artisan migrate --seed
    
And we are ready to go. **Run** the server:

    php artisan serve

Starting The Scheduler

Change the artisan path and add the only Cron entry you need:

    * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1

> **Note:** Remember to run this command as the same user of the webserver.

-----
<a name="step5"></a>
## Step 5: Start Page

**Type** on web browser:

    http://localhost:8000/

Congrats! You can now register as new user and log-in.
