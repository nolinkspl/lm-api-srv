## For running app

`docker-compose build`

`docker-compose up -d`


## Check it on
`http://localhost:4999`


##### To add stat record
POST: `http://localhost:4999` with `code` param

##### To view stats
GET: `http://localhost:4999/stats`

##### Start tests
`docker-compose exec -T app ./vendor/bin/phpunit`

##### ab test
`ab.exe -n 1000 -c 100 -p ab.post -T application/x-www-form-urlencoded http://localhost:4999/`

~140-180 requests average on dev machine
