SHELL := /bin/bash

.PHONY : test

test:
	./vendor/bin/phpunit tests
