# ⚙️ Installation

To set up KafMueen on your local environment, please ensure you have PHP, Composer, and MySQL installed.

1. **Clone the Repository**

    ```bash
    git clone https://github.com/Aseel-Aburumman/Relief-Organizations.git
    cd Relief-Organizations
    ```

2. **Install Dependencies**  
   Run the following command to install Laravel and its dependencies:

    ```bash
    composer install

    ```

3. **Environment Setup**  
   Duplicate `.env.example` as `.env` and configure your database settings:

    ```plaintext
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ocu-gaza
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. **Generate Application Key**  
   This key secures your application:

    ```bash
    php artisan key:generate
    ```

5. **Database Migration and Seeding**  
   Run the migrations to set up the database tables and initial data:

    ```bash
    php artisan migrate --seed
    ```

6. **Start the Application**  
   Launch the Laravel development server:

    ```bash
    php artisan serve
    ```

    is now live on [http://localhost:8000](http://localhost:8000)!

---

# 🎉 Get Started
