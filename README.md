## For running app

`docker-compose build`

`docker-compose up -d`

`docker-compose exec -T app composer install`


## Check it on
`http://localhost:4999`


##### To add stat record
POST: `http://localhost:4999` with `code` param

##### To view stats
GET: `http://localhost:4999/stats`

##### Start tests
`docker-compose exec -T app ./vendor/bin/phpunit`

##### ab test
If you use linux be sure that you have apache utils:

`sudo apt-get install apache2-utils`

Run command:

`ab` | `ab.exe -n 3000 -c 300 -p ab.post -T application/x-www-form-urlencoded http://localhost:4999/`

~500 requests average on dev machine
