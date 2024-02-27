#!/usr/bin/env bash

cd ./shell

FILE=./"$1".sh
if test -f "$FILE"; then
  ./"$1".sh ${*:2}
else
  echo "Command \"$1\" not found. List of available commands:"
  ls -1 | sed -e 's/\.sh$//'
fi