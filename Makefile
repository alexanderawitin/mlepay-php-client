all: clean up test

up:
	composer update

test:
	vendor/bin/phpunit --configuration tests/phpunit.xml --colors=auto

view-coverage:
	open artifacts/coverage/index.html

clean:
	rm -rf artifacts/*
