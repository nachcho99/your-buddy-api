# Your Buddy Api

## Installation

1. **Install dependencies:**
   ```bash
   composer install
   ```

2. **Copy environment file:**
   ```bash
   cp .env.example .env
   ```

3. **Run migrations:**
   ```bash
   php artisan migrate
   ```

4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

5. **Start server:**
   ```bash
   php artisan serve
   ```

The application will be available at: `http://localhost:8000`

---

**Note:** Remember to configure your database in the `.env` file before running migrations.
