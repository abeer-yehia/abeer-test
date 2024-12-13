# Abeer Test Application

## Prerequisites
- PHP (version 11)
- Composer
- Node.js (version v20.17.0) and npm
- MySQL 


## Installation Instructions
  **Clone the Repository:**
   ```bash
   git clone https://github.com/abeer-yehia/abeer-test.git
   cd abeer-test
 
   composer install
   npm install
   cp .env.example .env 
   change DB_DATABASE value to abeer-test
   php artisan key:generate
   npm run dev
   php artisan serve

   The application will be accessible at http://127.0.0.1:8000