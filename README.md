# LegalOne Project README

## Access Links
- [Technical Stack](#technical-stack)
- [Installations](#installations)
- [Testing](#testing)
- [Technical Aspects](#technical-aspects)

## Technical Stack
LegalOne's technical stack is meticulously selected for its powerful functionality and reliability, ensuring the application performs optimally for counting and aggregating statistics from log files.

- **PHP 8**: Offers significant performance improvements and new features over previous versions, enhancing the backend development process with increased speed and security measures.

- **Symfony 6**: A modern PHP framework that provides a structured foundation for building robust applications, chosen for its extensive feature set and flexibility.

- **Logstash**: Part of the Elastic Stack, used for processing and forwarding logs. It's employed to aggregate and parse the log files, preparing them for analysis in Elasticsearch.

- **Elasticsearch**: A powerful search and analytics engine that allows for quick searching, analyzing, and visualizing of the log data aggregated by Logstash.

- **Nginx**: A high-performance web server used to deliver the application's content quickly and efficiently. It also handles reverse proxy functionality, SSL termination, and more.

## Installations
### Prerequisites
- Docker Desktop for your OS.
- Ensure no services are running on port 8080.

### Steps
1. Clone the project:
   git clone https://github.com/mhmdnz/LegalOne.git
   cd LegalOne
2. Run the Docker containers:
   docker-compose up --build -d

### Accessing the Project
- Navigate to [http://localhost:8080](http://localhost:8080).

### Important After First Run
Wait approximately 2 minutes for the PHP container to execute `composer install` before sending requests.

## Testing
Run internal unit and feature tests with the following command:
   - `docker exec -it php php /var/www/html/LegalOne/bin/phpunit`

## Technical Aspects

### Nginx Configuration
The Nginx configuration, located within `nginx/default.conf`, is fully customizable to meet your specific requirements. A notable customization is the allowance of CORS for GET and DELETE requests. This adjustment enhances the interaction with Swagger documentation, offering a smoother testing experience by enabling cross-origin API requests directly from the Swagger UI.

### Elasticsearch Customization
Logstash typically generates a default index for the processed logs. However, due to the unique format of the log file provided for this project — specifically, the string format for timestamps — a custom index was necessary to accurately parse and store log data. The configuration for this custom index, named "my-index", can be found in `/logstash/index-mapping.json`. This index configuration plays a crucial role in the project's log processing pipeline, ensuring that both Logstash and the PHP container (during migrations) utilize the same index structure for consistent data handling.

It's important to note that "my-index" serves as a central element in the project's data architecture. As such, modifications to this index configuration should be undertaken with caution. Altering the index structure may impact the project's ability to correctly process and analyze log data, potentially affecting both the ingestion process by Logstash and the migration operations performed by the PHP container.

### Software Development Process
- The project follows Test-Driven Development (TDD) practices and is fully dockerized for ease of development and deployment.

### Documentation
- API documentation available at `project path/wiki/api.yaml`.
- Supports direct API requests via Swagger for convenient testing.

## API Overview

LegalOne provides two primary APIs designed for efficient log data management and analysis:

### 1. Count API (`GET /count`)

This API allows for querying aggregated log data, enabling users to filter results based on specific criteria. It is particularly useful for analyzing logs based on service names, date ranges, and status codes.

- **Endpoint**: `GET http://localhost:8080/count`
- **Parameters**:
   - `serviceNames`: Specify one or more service names to filter the logs. Multiple service names can be included by repeating the parameter.
   - `startDate` and `endDate`: Define the date range for the logs you wish to analyze, in the format `YYYY-MM-DD HH:MM:SS`.
   - `statusCode`: Filter logs by HTTP status code.

- **Example Request**:
  - `http://localhost:8080/count?serviceNames=USER-SERVICE&serviceNames=Invoice&startDate=2018-08-01 10:10:10&endDate=2019-01-01 10:10:10&statusCode=201`

### 2. Delete API (`DELETE /delete`)

Use this API to remove all Elasticsearch indices, effectively resetting the log data storage. This operation is critical for maintaining the database's efficiency or preparing the system for new log data.

- **Endpoint**: `DELETE localhost:9200/my-index`
- **Function**: Removes all Elasticsearch indices to clear stored log data.

- **Usage Note**: After executing the delete operation, it is necessary to run migrations to restore the database structure and prepare it for new data ingestion.

### Post-Deletion Migrations

To ensure the system functions correctly after deleting indices, perform migrations.

### Migrations
After deleting indices, use the following commands for migrations:
- Migrate: `docker exec -it php php bin/console doctrine:migrations:migrate --no-interaction`
- Rollback: `docker exec -it php php bin/console doctrine:migrations:migrate prev --no-interaction`

### Adding More Logs
- Modify `/logstash/logs.log` to add more logs.
- Logstash configuration is near real-time; new lines added to the log file are automatically processed without needing to restart Docker.

For any questions, please reach out to mhmd_nzri@yahoo.com.
