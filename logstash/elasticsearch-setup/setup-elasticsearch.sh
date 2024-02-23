#!/bin/bash

ELASTICSEARCH_URL="http://elasticsearch:9200"
INDEX_NAME="my-index"

while true; do
    if curl -s "$ELASTICSEARCH_URL" > /dev/null; then
        break
    else
        echo "Waiting for Elasticsearch..."
        sleep 1
    fi
done

curl -X PUT "$ELASTICSEARCH_URL/$INDEX_NAME" -H 'Content-Type: application/json' -d @/elasticsearch-setup/index-mapping.json
echo "Index creation complete."