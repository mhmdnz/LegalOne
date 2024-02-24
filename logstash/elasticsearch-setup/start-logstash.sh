#!/bin/bash

echo "Running Elasticsearch setup script..."
/elasticsearch-setup/setup-elasticsearch.sh

echo "Starting Logstash..."
/usr/local/bin/docker-entrypoint ${@}