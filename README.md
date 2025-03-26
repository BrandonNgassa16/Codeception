# API Test Suite

This repository contains automated tests for the Booking and Pet APIs using Codeception.

## Project Structure

- **`tests/Api/BookingCest.php`**: Contains test cases for the Booking API.
- **`tests/Pets/buddCest.php`**: Contains test cases for the Pet API.

---

## Booking API Tests (`BookingCest.php`)

### Test Cases

1. **`getAllBookings`**
   - Sends a `GET` request to retrieve all bookings.
   - Verifies the response code is `200`.
   - Ensures the response is in JSON format.
   - Validates the response matches the expected JSON structure.

2. **`createBooking`**
   - Sends a `POST` request to create a new booking.
   - Includes a payload with booking details (e.g., `firstname`, `lastname`, `totalprice`, etc.).
   - Verifies the response code is successful.
   - Ensures the response matches the expected JSON structure.
   - Stores the `bookingId` for use in other tests.

3. **`authenticateTheCreatedUser`**
   - Sends a `POST` request to authenticate a user.
   - Includes a payload with `username` and `password`.
   - Verifies the response code is `200`.
   - Ensures the response contains a valid `token`.
   - Stores the `token` for use in other tests.

4. **`updateBooking`**
   - Sends a `PUT` request to update an existing booking.
   - Uses the `bookingId` and `token` retrieved from previous tests.
   - Includes a payload with updated booking details.
   - Verifies the response code is `200`.
   - Ensures the response matches the expected JSON structure.

---

## Pet API Tests (`buddCest.php`)

### Test Cases

1. **`getPetById`**
   - Sends a `GET` request to retrieve a pet by its ID.
   - Verifies the response code is `200`.
   - Ensures the response is in JSON format.
   - Validates the response contains the expected pet details.

2. **`addNewPet`**
   - Sends a `POST` request to add a new pet.
   - Includes a payload with pet details (e.g., `id`, `name`, `status`).
   - Verifies the response code is `200`.
   - Ensures the response contains the newly added pet's details.

3. **`deletePet`**
   - Sends a `DELETE` request to remove a pet by its ID.
   - Verifies the response code is `200`.

4. **`uploadImage`**
   - Sends a `POST` request to upload an image for a specific pet.
   - Includes a file in the request payload.
   - Verifies the response code is `200`.
   - Ensures the response is in JSON format.

5. **`getPet`**
   - Sends a `GET` request to retrieve all pets.
   - Verifies the response code is `200`.
   - Ensures the response is in JSON format.

---

## Prerequisites

- PHP 7.4 or higher
- Composer
- Codeception installed globally or locally in the project

---

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/BrandonNgassa16/<repository-name>.git
   cd <repository-name>