# EducaFree

EducaFree is a comprehensive educational platform designed to provide free access to quality educational resources. This project is a final assignment for a web development course, aiming to bridge the educational gap by offering a variety of learning materials to students globally.

> [!NOTE]  
> This project is a final course project for a web development course, designed to showcase the skills and knowledge acquired throughout the course. The goal is to provide a practical and impactful solution to real-world problems in the educational sector.

## Table of Contents
- [Introduction](#introduction)
- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)
- [License](#license)
- [Deployment](#deployment)
- [TODO List](#todo-list)

## Introduction
EducaFree is an open-source project developed as the final project for a web development course. It offers free educational resources, including interactive lessons, quizzes, and a community forum for students to collaborate and learn together.

## Features
- Interactive lessons
- Quizzes and assessments
- Community forum
- User-friendly interface

## Installation
To set up the project locally, follow these steps:

1. Clone the repository:
    ```bash
    git clone https://github.com/GarriguesN/EducaFree.git
    cd EducaFree
    ```

2. Install dependencies:
    ```bash
    npm install
    composer install
    ```

3. Set up environment variables:
    - Create a `.env` file based on the `.env.example` provided.

4. Run the application:
    ```bash
    npm start
    ```

## Deployment
To deploy the application using Docker, follow these steps:

1. Build and run the Docker containers:
    ```bash
    docker-compose up --build
    ```

2. The application will be accessible at `http://localhost:3000`.

## TODO List

### Step 1: Clear Cache and Set Permissions
In the root directory of your project, run the following commands to clear cache and set the correct permissions:

```bash
# Change owner and group to www-data for all files and directories
chown -R www-data:www-data *

# Add the user to the www-data group
usermod -a -G www-data ubuntu

# Set file permissions to 644 and directory permissions to 755
find /var/www/html/EducaFree -type f -exec chmod 644 {} \;
find /var/www/html/EducaFree -type d -exec chmod 755 {} \;

# Create storage link and set permissions
php artisan storage:link

# Set permissions for storage directories
chmod -R 775 storage/app/public
chmod -R 775 public/storage

# Change owner and group to www-data for storage directories
chown -R www-data:www-data storage/app/public
chown -R www-data:www-data public/storage

# Install vite globally
npm install -g vite

# Run development build
npm run dev

# Run production build
npm run build
```

## Usage
After installation, you can access the application at `http://localhost:3000`. Use the platform to explore and engage with the educational content provided.

## Contributing
Contributions are welcome! Please read the [CONTRIBUTING.md](CONTRIBUTING.md) file for guidelines on how to contribute to this project.

## License
This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
