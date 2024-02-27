#!/usr/bin/env bash

./stop.sh

docker-compose up -d --remove-orphans
