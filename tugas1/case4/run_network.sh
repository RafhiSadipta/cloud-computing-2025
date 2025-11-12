#!/bin/sh

docker rm -f redis-server app-publisher
docker network rm case4-net

docker network create case4-net

docker run \
	-d --name redis-server \
	--network case4-net \
	-v $(pwd)/redis_data:/data \
	redis:7.0-alpine \
	redis-server --appendonly yes

echo "Menunggu Redis Server siap..."
until docker run --rm --network case4-net redis:7.0-alpine redis-cli -h redis-server PING | grep PONG; do
	echo "Redis belum siap, mencoba lagi dalam 1 detik.."
	sleep 1
done
echo "Redis siap mengirim pesan.."

docker run \
	--rm \
	--name app-publisher \
	--network case4-net \
	redis:7.0-alpine \
	redis-cli -h redis-server RPUSH task_queue "PROSES_EMAIL_USER_123"
