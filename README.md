# JOJOBI Laravel E-commerce Website

JOJOBI is a Laravel-based e-commerce platform designed to facilitate easy online buying and selling. This robust platform offers a suite of features that streamline the process of setting up and managing an online store, making it an ideal choice for businesses of all sizes.

## Key Features

- **Responsive Design**: Ensures an optimal shopping experience across all devices, including desktops, tablets, and smartphones.
- **Secure Payment Gateways**: Provides safe and reliable payment processing to protect both merchants and customers.
- **Effective Inventory Management**: Simplifies the tracking and management of stock levels, orders, and product listings.
- **Customizable Storefront**: Allows businesses to personalize their online store to reflect their brand and attract customers.
- **Optimized Admin Panel**: Streamlined dashboard for efficient store management and control.

## Benefits

- **Easy Setup and Management**: JOJOBI is user-friendly, making it simple to set up and maintain an online store without extensive technical knowledge.
- **Enhanced User Engagement**: The intuitive design and smooth functionality encourage customers to explore and shop, increasing engagement and satisfaction.
- **Boosted Revenue**: By providing a seamless shopping experience, JOJOBI helps businesses attract and retain customers, driving sales growth.

## Installation

To install and set up the JOJOBI e-commerce platform, follow these steps:

1. **Install Laravel**:

   ```bash
   composer create-project laravel/laravel example-app
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   npm run dev
   ```
3. **Install Laravel Breeze**
   Laravel Breeze is a minimal, simple implementation of all of Laravel's authentication features, including login, registration, password reset, email verification, and password confirmation. In addition, Breeze includes a simple "profile" page where the user may update their name, email address, and password.
   ![alt text](https://laravel.com/img/docs/breeze-register.png)

   **Installation**

   ```bash
   composer require laravel/breeze --dev

   php artisan breeze:install

   php artisan migrate
   npm install
   npm run dev
   or npm build
   ```

4. **Set Up Register and Login**:
   keep changing the JOJOBI\app\Http\Controllers\Auth\RegisteredUserController.php

5. **Configure Admin_Template**:
   Download Admin Template, then run:

   ```bash
   https://github.com/DrkD3vil/JOJOBI-Laravel-Ecommerce-website/tree/main/Admin_Template
   ```

   Add Template in public directory like

   ```bash
   JOJOBI\public\adminfile
   ```

   Now, copy JOJOBI\public\adminfile\index.html to JOJOBI\resources\views\admin\index.blade.php
   After copying the template modify css and js files like this:

   ```bash
    <link rel="stylesheet" href="{{ asset('/adminfile/css/font.css') }}">
    <script src="{{ asset('/adminfile/vendor/jquery/jquery.min.js') }}"></script>
   ```

   in website :
   ![alt text](https://i.ibb.co/qNHmjrR/Screenshot-14-8-2024-112156-127-0-0-1.jpg)

6. **Serve the Application**:

   ```bash
   php artisan serve
   ```

7. **Access the Platform**:
   Open your web browser and go to `http://localhost:8000` to access the JOJOBI e-commerce platform.

## Contribution

We welcome contributions to enhance the JOJOBI platform. Please fork the repository and create a pull request with your changes. For major changes, please open an issue first to discuss what you would like to change.

## License

This project is licensed under the MIT License. See the `LICENSE` file for more details.

## Contact

For questions or support, please contact us at bijoydevpro@icloud.com

---

Thank you for choosing JOJOBI for your e-commerce needs. We hope our platform helps you create a successful and profitable online store!

## Steps to Workflow

**Step 1: Add Product Category**
in web.php file add product category wirh admin authorization
Route::middleware(['auth', 'admin'])->group(function () {
   'view_category',
   'add_category',
   'search_category',
   'edit_category/{uuid}',
   'update_category/{uuid}',
   'delete_category/{uuid}',
   'preview-pdf',
   'download-pdf'
});

## Images
**category images**
![alt text](https://i.ibb.co/QCFj3M3/category.jpg)
