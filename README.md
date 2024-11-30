

## Approach and Assumptions

1. Model Relationships:

- Customers, Agents, and Calls have relationships defined in accordance with Laravel conventions.
- Customers have a one-to-many relationship with Calls.
- Agents have a one-to-many relationship with Calls and Customers.

2. Backend Filtering:

- Query filters for Agent and date range are implemented in the controller.
- Pagination ensures efficient handling of large datasets.

3. Frontend:

- Blade template for displaying calls with pagination links.
- Optional dynamic filtering via JavaScript for extensibility.

4. Optimizations:

- Eager loading (with method) minimizes database queries.
- Indexing database columns used in filters (e.g., agent_id, created_at).

5. Added some data for a testing.

## Installation

1. Unzip archive
2. Set data connection for your database in .env file
3. Open terminal go to unpack directory and run commands:
- php artisan migrate 
- php artisan db:seed
- php artisan serve
4. Open your browser /reports/calls
