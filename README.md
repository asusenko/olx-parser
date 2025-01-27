# OLX Price Tracker

OLX Price Tracker is a Laravel-based service that allows users to monitor price changes on OLX listings. Users can subscribe to specific listings and receive email notifications when the price changes. The service also supports subscription management and ensures efficient tracking by avoiding redundant price checks for the same listing.

---

## Features

1. **Subscribe to Price Changes**:
   - Users can subscribe to OLX listings using their email address and the listing URL.

2. **Email Notifications**:
   - Users are notified via email when the price of a subscribed listing changes.

3. **Subscription Management**:
   - Check subscription status for a specific listing.
   - Delete subscriptions.

4. **Efficient Price Tracking**:
   - Avoid redundant price checks for the same listing, even if multiple users are subscribed.

5. **Testing**:
   - Comprehensive tests ensure the reliability of the service, with over 70% test coverage.

6. **Docker Support**:
   - The service runs in Docker containers for easy deployment and scalability.

7. **User Email Verification**:
   - Ensures valid email addresses are used for subscriptions.

---

## API Endpoints

### Subscribe to a Listing
**URL:** `/api/subscribe`  
**Method:** `POST`  
**Parameters:**
- `email` (required): User's email address.
- `url_link` (required): URL of the OLX listing.

**Response:**
- `201 Created`: Subscription successful.
- `200 OK`: Already subscribed to the listing.

### Check Subscription
**URL:** `/api/subscription`  
**Method:** `GET`  
**Parameters:**
- `email` (required): User's email address.
- `url_link` (required): URL of the OLX listing.

**Response:**
- `{ "exists": true }`: Subscription exists.
- `{ "exists": false }`: Subscription does not exist.

### Delete Subscription
**URL:** `/api/subscription`  
**Method:** `DELETE`  
**Parameters:**
- `email` (required): User's email address.
- `url_link` (required): URL of the OLX listing.

**Response:**
- `200 OK`: Subscription deleted successfully.
- `404 Not Found`: User or subscription not found.

---

## Database Schema

### `links` Table
| Column       | Type         | Description                      |
|--------------|--------------|----------------------------------|
| `id`         | BIGINT       | Primary key.                    |
| `url_link`   | VARCHAR(255) | URL of the listing.             |
| `last_price` | DECIMAL      | Last tracked price of the item. |
| `created_at` | TIMESTAMP    | Creation timestamp.             |
| `updated_at` | TIMESTAMP    | Last update timestamp.          |

### `user_link` Table
| Column       | Type         | Description                      |
|--------------|--------------|----------------------------------|
| `id`         | BIGINT       | Primary key.                    |
| `user_id`    | BIGINT       | Foreign key to `users`.         |
| `link_id`    | BIGINT       | Foreign key to `links`.         |
| `created_at` | TIMESTAMP    | Creation timestamp.             |
| `updated_at` | TIMESTAMP    | Last update timestamp.          |

### `users` Table
| Column          | Type         | Description                      |
|------------------|--------------|----------------------------------|
| `id`            | BIGINT       | Primary key.                    |
| `email`         | VARCHAR(255) | User's email address.           |
| `password`      | VARCHAR(255) | User's hashed password.         |
| `email_verified_at` | TIMESTAMP | Email verification timestamp.  |
| `created_at`    | TIMESTAMP    | Creation timestamp.             |
| `updated_at`    | TIMESTAMP    | Last update timestamp.          |

---


### API Documentation

#### **POST /api/subscribe**
- **Description:** Subscribe to price change notifications for a specific OLX listing.
- **Parameters:**
  - `email`: User's email address (required).
  - `url_link`: URL of the OLX listing (required).
- **Responses:**
  - `201 Created`: Subscription was successfully created.
  - `200 OK`: The user is already subscribed.

#### **GET /api/subscription**
- **Description:** Check if a user is subscribed to a specific listing.
- **Parameters:**
  - `email`: User's email address (required).
  - `url_link`: URL of the OLX listing (required).
- **Responses:**
  - `200 OK`: Subscription status.
    - `{ "exists": true }` if subscribed.
    - `{ "exists": false }` if not subscribed.

#### **DELETE /api/subscription**
- **Description:** Delete a user's subscription for a specific listing.
- **Parameters:**
  - `email`: User's email address (required).
  - `url_link`: URL of the OLX listing (required).
- **Responses:**
  - `200 OK`: Subscription deleted successfully.
  - `404 Not Found`: User or subscription not found.
