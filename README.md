# Fraud Detector Microservice

This is the Fraud Detector microservice for the ShipAnything platform, handling real-time fraud detection and risk assessment. **This service is protected by the Auth Gateway and requires a valid Bearer token for API access.**

## Features

-   Real-time fraud detection and prevention
-   Risk scoring and assessment algorithms
-   Machine learning-based pattern analysis
-   Transaction monitoring and anomaly detection
-   User behavior analysis and threat detection

## Authentication

**All API endpoints (except health check) are protected by the NGINX API Gateway and require a valid Bearer token.**

The authentication flow works as follows:

1. Client sends request to `http://fraud.shipanything.test/api/*` with Bearer token
2. NGINX API Gateway intercepts and validates the token with the auth service
3. If valid, NGINX forwards the request with user context headers to this service
4. This service processes the request with authenticated user context

**Example API call:**

```bash
curl -X POST http://fraud.shipanything.test/api/fraud/check \
  -H "Authorization: Bearer YOUR_ACCESS_TOKEN" \
  -H "Content-Type: application/json" \
  -d '{"transaction_id": "txn_123", "amount": 100.00}'
```

**To get an access token, register/login via the Auth service:**

```bash
# Login to get token
curl -X POST http://auth.shipanything.test/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email": "your@email.com", "password": "yourpassword"}'
```

## API Endpoints

### Public Endpoints (No Authentication Required)

-   `GET /health` - Service health check

### Protected Endpoints (Require Bearer Token)

-   `POST /api/fraud/check` - Check transaction for fraud
-   `GET /api/fraud/reports` - Get user's fraud reports
-   `GET /api/fraud/risk-score` - Get user's current risk score
-   `POST /api/fraud/report` - Report suspicious activity
-   `GET /api/fraud/alerts` - Get fraud alerts for user

### Internal Test Endpoints (Container Network Only)

-   `GET /api/test/dbs` - Database connectivity test
-   `GET /api/test/rabbitmq` - RabbitMQ connectivity test
-   `GET /api/test/kafka` - Kafka connectivity test
-   `GET /api/test/auth-status` - Authentication status check

## User Context

**This service automatically receives user context from the NGINX API Gateway:**

-   User ID is available in controllers via `$request->attributes->get('user_id')`
-   User email via `$request->attributes->get('user_email')`
-   All fraud data is automatically filtered by authenticated user
-   Enhanced security for sensitive fraud detection operations

**Example usage in controller:**

```php
public function checkFraud(Request $request)
{
    $userId = $request->attributes->get('user_id');
    $userEmail = $request->attributes->get('user_email');

    // Perform fraud check for the authenticated user
    $riskScore = $this->calculateRiskScore($request->all(), $userId);

    return response()->json(['risk_score' => $riskScore]);
}
```

## Event-Driven Integration

The fraud detector integrates with other services via Kafka events:

-   Listens for payment events from payments service
-   Listens for booking events from booking service
-   Publishes fraud alerts to all relevant services

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
