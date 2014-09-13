#!/bin/bash/

BIN=bin/phpcompressor.php
DIR=template
PREFIX=0_

RAWS=`ls $DIR/${PREFIX}*.php`
FILES=()

if [ ! -d "$DIR" ]; then
    echo "Error: directory '$DIR' does not exist."
    exit
fi

if [ ! -f "$BIN" ]; then
    echo "Error: '$BIN' does not exist."
    exit
fi

for raw in $RAWS
do
    file=${raw/$PREFIX/}

    echo "minimizing $raw..."
    php $BIN $raw > $file
done

