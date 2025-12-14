#!/bin/sh

docker run -d \
  --name taskmanager \
  -p 8085:80 \
  -e DB_HOST=mysql \
  -e DB_USER=root \
  -e DB_PASS=password \
  -e DB_NAME=taskmanager \
  -e REDIS_HOST=redis \
  -e REDIS_PORT=6379 \
  mytaskmanager:latest

echo "Task Manager container started!"
echo "Access the app at: http://localhost:8085"
