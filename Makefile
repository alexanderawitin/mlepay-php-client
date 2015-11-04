all: clean up test

up:
	composer update

test:
	vendor/bin/phpunit tests --colors=auto

coverage:
	vendor/bin/phpunit --coverage-html=artifacts/coverage --colors=auto tests

view-coverage:
	open artifacts/coverage/index.html

clean:
	rm -rf artifacts/*
