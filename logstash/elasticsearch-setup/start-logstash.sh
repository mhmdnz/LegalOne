#!/bin/bash

echo "Running Elasticsearch setup script..."
chmod +x /elasticsearch-setup/setup-elasticsearch.sh
/elasticsearch-setup/setup-elasticsearch.sh

echo "Starting Logstash..."
/usr/local/bin/docker-entrypoint ${@}