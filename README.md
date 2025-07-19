# Fraud Detector Microservice

This is the Fraud Detector microservice for the ShipAnything platform, handling real-time fraud detection and risk assessment.

## Features

-   Real-time fraud detection
-   Risk scoring and assessment
-   Machine learning-based analysis
-   Transaction monitoring

## Endpoints

-   `GET /health` - Health check
-   `GET /api/test/dbs` - Database connectivity test
-   `GET /api/test/rabbitmq` - RabbitMQ connectivity test
-   `GET /api/test/kafka` - Kafka connectivity test

## Environment Variables

-   `DB_HOST` - PostgreSQL host (`fraud-postgres`)
-   `DB_DATABASE` - Database name (`fraud_db`)
-   `DB_USERNAME` - Database user (`fraud_user`)
-   `DB_PASSWORD` - Database password (`fraud_password`)
-   `REDIS_HOST` - Redis host (`fraud-redis`)
-   `RABBITMQ_HOST` - RabbitMQ host (`fraud-rabbitmq`)
-   `RABBITMQ_USER` - RabbitMQ user (`fraud_user`)
-   `RABBITMQ_PASSWORD` - RabbitMQ password (`fraud_password`)
-   `KAFKA_BROKERS` - Kafka brokers list (`kafka:29092`)

## Database Connection (Development)

**PostgreSQL:**

-   Host: `localhost`
-   Port: `5437`
-   Database: `fraud_db`
-   Username: `fraud_user`
-   Password: `fraud_password`

**Redis:**

-   Host: `localhost`
-   Port: `6384`

**RabbitMQ Management UI:**

-   URL: http://localhost:15676
-   Username: `fraud_user`
-   Password: `fraud_password`

## Docker Compose Ports

-   **Application**: 8085
-   **PostgreSQL**: 5437
-   **Redis**: 6384
-   **RabbitMQ AMQP**: 5676
-   **RabbitMQ Management**: 15676

## Development

This service is part of the larger ShipAnything microservices platform. See the main repository README for setup and deployment instructions.

### Running Commands

```bash
# Navigate to the docker folder
cd microservices/fraud-detector-app/docker

# Run artisan commands
./cmd.sh php artisan migrate
./cmd.sh php artisan make:controller FraudController
./cmd.sh composer install
```
