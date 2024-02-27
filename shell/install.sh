#!/usr/bin/env bash

./stop.sh

if [[ " $@ " =~ " -rm " ]]; then
  sudo rm -rf ../app/vendor/
fi

docker-compose build --force-rm

./composer.sh install

if [[ " $@ " =~ " -start " ]]; then
  ./start.sh
else
  ./stop.sh
fi
