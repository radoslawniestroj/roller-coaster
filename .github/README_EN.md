# Roller Coaster App

The application supports the basic operating mechanism of a roller coaster via an API. The data is stored in Redis memory.

- ### [API](README_EN_API.md)
- ### [Production vs development](README_EN_PROD_DEV.md)
- ### [Simulation](README_EN_SIM.md)

### Application Installation

Project installation:
- in the `project-root` directory, copy the `env` file with the name `.env`, or use the command `cp project-root/env project-root/.env`
- run the command `docker-compose up -d`, which downloads and configures the necessary containers
- then `docker-compose exec php bash`, which gives you access to the container
- inside the container, run `composer install` to install the missing code

And that’s it! You now have a working roller coaster project. Check if it’s running by visiting [localhost](http://localhost/#).</br>
I recommend getting familiar with the functionalities listed in the table of contents.</br>
\* remember that some browsers, such as Google Chrome, may block HTTP domains, in that case, you’ll need to allow localhost
to run in your browser settings

Redis
Access the container with `docker-compose exec redis bash`:
- clear the memory with `redis-cli flushall`
- choose the database with `redis-cli -n 0` or `redis-cli -n 1`
- fetch data for a specific coaster with `get coaster:1`
- fetch a list of available coasters with `scan 0 MATCH *coaster*`
