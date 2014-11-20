Entropia Armory
===============

Hunting economy calculator for Entropia Universe.

* Deployed at: http://eldslott.org/entropia/
* Development thread: http://www.planetcalypsoforum.com/forums/showthread.php?219992

You're free to fork it and do whatever you want with it if you want, or send pull-request to this repo, up to you!

It's a big php mess built without any frameworks, sorry. I've tried to keep it structured, but there's no documentation, so good luck!

Basically you can "build" it with gnu make. What it does is minimize the css, js and the `template/` php files. When a template has been minimized it's be named `0_filename.php`, which is what is being included when rendering. Since it can render a couple of thousands of the templates if you list a lot of weapons it became necessary to minimize it to keep the data transfer size down and render time up.

There's some sql create table queries in `sql/` that you should run, then visit the `import/index.php`, which can import the .csv files in `csv/`. The csv files are identical to what you get when you export lists on entropedia (with all columns shown).
