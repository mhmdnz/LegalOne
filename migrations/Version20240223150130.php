<?php

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

class Version20240223150130 extends AbstractMigration
{
    const ELASTIC_URL = 'http://elasticsearch:9200';
    const ELASTIC_INDEX = 'my-index';
    const INDEX_MAPPING_PATH = '/var/www/html/LegalOne/logstash/elasticsearch-setup/index-mapping.json';

    public function getDescription() : string
    {
        return 'Executes curl command to set up Elasticsearch index mapping.';
    }

    public function up(Schema $schema) : void
    {
        $elasticsearchUrl = self::ELASTIC_URL;
        $indexName = self::ELASTIC_INDEX;
        $indexMappingPath = self::INDEX_MAPPING_PATH;

        $curlCommand = sprintf(
            "curl -X PUT '%s/%s' -H 'Content-Type: application/json' -d @%s",
            $elasticsearchUrl,
            $indexName,
            $indexMappingPath
        );

        exec($curlCommand);
    }

    public function down(Schema $schema) : void
    {
        $elasticsearchUrl = self::ELASTIC_URL;
        $command = "curl -X DELETE '{$elasticsearchUrl}/_all'";

        exec($command);
    }
}