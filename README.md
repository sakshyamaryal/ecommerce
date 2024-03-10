# Simple E-Commerce Site with Laravel
    Introduction
    This is a simple e-commerce site developed using Laravel, where admins can manage products and their stock availability, and customers can buy the available products.

# Installation
    Clone the repository to your local machine:
    git clone <repository-url>
    Navigate to the project directory:
    cd <project-directory> (cd ecommerce)

# Install dependencies using Composer:
    composer install
    Copy the .env.example file to create a new .env file:

    cp .env.example .env
    
# Generate an application key:
    php artisan key:generate
# Database Setup
    Create a new database for the project.
    Update the .env file with your database credentials:
    
    <!-- connection  -->

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=ecommerce
    DB_USERNAME=root
    DB_PASSWORD=

    <!-- connection end  -->

    Run database migrations to create the necessary tables:
    
    
# Usage
    php artisan migrate

    To access the admin dashboard, go to /admin and login using your admin credentials.
    Admins can manage products by adding, editing, or deleting them.
    Customers can browse available products and add them to their cart.
    Customers can proceed to checkout to complete their purchase.
    Features


# Technologies Used
    Laravel
    MySQL
    Bootstrap
    HTML/CSS
    Contributing
    Contributions are welcome! Feel free to open issues or submit pull requests.

# License
    This project is Not-open-source and available under the MIT License.

# Author
    Sakshyam Aryal