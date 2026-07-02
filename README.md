# Schoolar Feedback Platform

A platform for students to provide anonymous feedback to teachers, for teachers to manage courses and view feedback analytics, and for admins to manage users, roles, and permissions.

**Programming Language:** PHP (Laravel Framework)

**Multilingual:** Supports English, French, and Arabic.

## Features

- User Management (Admin, Teachers, Students)
- Course Management
- Anonymous Student Feedback
- Feedback Analytics
- File Upload Support (Student Pictures & Documents)
- Role-based Permissions System
- Multilingual Interface (EN, FR, AR)
- Feedbacks can be submitted as Anonymous or Shown, and this status is visible and filterable in the dashboard and feedback management.

## Permissions & Roles

The platform uses a role-based permissions system. Each role can be assigned specific permissions for different models:

| Model       | Permissions                                                                 |
|-------------|------------------------------------------------------------------------------|
| Students    | add_student, access_students, edit_student, delete_student                   |
| Users       | add_user, access_users, edit_user, delete_user                               |
| Courses     | add_course, access_courses, edit_course, delete_course                       |
| Teachers    | add_teacher, access_teachers, edit_teacher, delete_teacher                   |
| Roles       | add_role, access_roles, edit_role, delete_role                               |
| Feedbacks   | access_feedbacks, delete_feedback                                            |
| Departments | add_department, access_departments, edit_department, delete_department       |

**Note:** Feedbacks can be either **Anonymous** or **Shown**. The anonymity status is displayed in both the dashboard and feedback management, and you can filter feedbacks by this status.

- **add_X**: Create a new X
- **access_X**: View/list X
- **edit_X**: Edit/update X
- **delete_X**: Delete X

## Requirements

- PHP >= 7.4
- MySQL >= 5.7
- Composer
- Web Server (Apache/Nginx)

## Installation

1. Clone the repository:
```bash
git clone https://github.com/your-username/student-feedback-platform.git
cd student-feedback-platform
```

2. Install dependencies:
```bash
composer install
```

3. Create a MySQL database and import the schema:
```bash
mysql -u root -p
CREATE DATABASE schoolar;
exit;
mysql -u root -p schoolar < database.sql
```

4. Copy `.env.example` to `.env` and configure your environment:
```bash
cp .env.example .env
```

5. Update the `.env` file with your database credentials and JWT secret key.

6. Create upload directories:
```bash
mkdir -p uploads/pictures uploads/baccaloriat
chmod -R 755 uploads
```

7. Configure your web server to point to the `public` directory.

## Docker Setup

You can run the app with Docker instead of installing PHP, Composer, Node, and MySQL locally.

1. Build and start the containers:
```bash
docker compose up --build
```

2. Open the app:
```text
http://localhost:8000
```

The Docker setup starts:

- `app`: PHP 8.3 FPM with Composer dependencies installed
- `nginx`: web server pointing to Laravel's `public` directory
- `mysql`: MySQL 8.4 with a persisted `schoolar` database
- `jenkins`: Jenkins LTS for CI jobs
- `sonarqube`: SonarQube Community for code quality analysis
- `sonar_db`: PostgreSQL database used by SonarQube

The app uses `.env.docker` inside Docker. If you imported an existing database, keep automatic migrations disabled:
```env
RUN_MIGRATIONS=false
```

### Jenkins

Jenkins is available at:
```text
http://localhost:8080
```

Start Jenkins with the rest of the project:
```bash
docker compose up -d --build
```

Get the first admin password:
```bash
docker compose exec jenkins cat /var/jenkins_home/secrets/initialAdminPassword
```

This repository includes a `Jenkinsfile` that installs Composer dependencies, installs Node dependencies, builds Vite assets, runs Laravel tests, and sends analysis to SonarQube.

### SonarQube

SonarQube is available at:
```text
http://localhost:9000
```

Default login:
```text
Username: admin
Password: admin
```

On first login, SonarQube asks you to change the admin password.

Create a project/token:

1. Open SonarQube at `http://localhost:9000`.
2. Create a local project with project key:
```text
schoolar
```
3. Generate a token for analysis.
4. In Jenkins, add a credential:
```text
Kind: Secret text
Secret: <your SonarQube token>
ID: sonarqube-token
Description: SonarQube token for Schoolar
```

The SonarQube scanner configuration lives in `sonar-project.properties`.

If SonarQube restarts with an H2 database error after changing versions, reset only the SonarQube volumes. Do not use `docker compose down -v` unless you also want to delete the MySQL database volume.
```bash
docker compose stop sonarqube
docker volume rm schoolar_sonarqube_data schoolar_sonarqube_extensions schoolar_sonarqube_logs
docker compose up -d sonarqube sonar_db
```

Useful commands:
```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan test
docker compose up -d --build jenkins sonarqube
docker compose down
docker compose down -v
```

## API Documentation

### Authentication

All API endpoints except login require JWT authentication. Include the token in the Authorization header:
```
Authorization: Bearer <your-token>
```

### Endpoints

#### Students

- `GET /api/students` - List all students (Admin/Teacher only)
- `GET /api/students/{id}` - Get student details (Admin/Teacher only)
- `POST /api/students` - Create new student (Admin only)
- `PUT /api/students/{id}` - Update student (Admin only)
- `DELETE /api/students/{id}` - Delete student (Admin only)

#### Courses

- `GET /api/courses` - List all courses
- `GET /api/courses/{id}` - Get course details
- `POST /api/courses` - Create new course (Admin/Teacher only)
- `PUT /api/courses/{id}` - Update course (Admin/Teacher only)
- `DELETE /api/courses/{id}` - Delete course (Admin/Teacher only)
- `POST /api/courses/{id}/enroll` - Enroll student in course (Admin/Teacher only)
- `POST /api/courses/{id}/unenroll` - Unenroll student from course (Admin/Teacher only)
- `GET /api/courses/{id}/students` - List enrolled students (Admin/Teacher only)

#### Feedback

- `GET /api/feedback` - List feedback (filtered by role)
- `GET /api/feedback/{id}` - Get feedback details
- `POST /api/feedback` - Submit feedback (Student only)
- `PUT /api/feedback/{id}` - Update feedback (Student only)
- `DELETE /api/feedback/{id}` - Delete feedback (Admin/Student only)
- `GET /api/courses/{id}/feedback/stats` - Get feedback statistics (Admin/Teacher only)

### Request Examples

#### Create Student
```json
POST /api/students
{
    "firstname": "John",
    "lastname": "Doe",
    "email": "john@example.com",
    "password": "secure123",
    "student_number": "2024001",
    "group_id": 1,
    "date_of_birth": "2000-01-01"
}
```

#### Submit Feedback
```json
POST /api/feedback
{
    "course_id": 1,
    "content": "Great course content and teaching style!",
    "is_anonymous": true
}
```

## Security

- All passwords are hashed using PHP's password_hash()
- JWT tokens are used for API authentication
- File uploads are validated for type and size
- CORS headers are configured for API access
- Input validation is performed on all endpoints

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the LICENSE file for details.
