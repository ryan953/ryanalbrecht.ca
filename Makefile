.PHONEY docker-run

docker-run:
  docker run -it --rm --name ryanalbrecht.ca -v "$PWD":/var/www/html/ -w /var/www/html php:5.6-apache
