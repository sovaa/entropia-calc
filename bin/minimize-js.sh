#!/bin/bash/

DIR=js
BIN=bin/yuicompressor-2.4.7.jar
OUTPUT=js/scripts-min.js

PREFIX=orig_
SUFFIX=js

if [ ! -d "$DIR" ]; then
    echo "Error: directory '$DIR' does not exist."
    exit
fi

if [ ! -f "$BIN" ]; then
    echo "Error: '$BIN' does not exist."
    exit
fi

if [ -f "$OUTPUT" ]; then
    echo "cleaning output file $OUTPUT"
    echo "" > $OUTPUT
else
    echo "creating output file $OUTPUT"
    touch $OUTPUT
fi

for file in `ls $DIR/${PREFIX}*.$SUFFIX`
do
    echo "minimizing $file..."
    java -jar $BIN --type $SUFFIX $file >> $OUTPUT
done

