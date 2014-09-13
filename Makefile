# build script

.PHONY:js css html test

all: 
	make js
	make css
	make html

js:
	bash bin/minimize-js.sh

css:
	bash bin/minimize-css.sh

html:
	bash bin/minimize-html.sh

test:
	php test/*.php
