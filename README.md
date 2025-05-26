# Student Feedback Platform

A platform for students to provide anonymous feedback to teachers and for teachers to manage courses and view feedback analytics.

## Features

- User Management (Admin, Teachers, Students)
- Course Management
- Anonymous Student Feedback
- Feedback Analytics
- File Upload Support (Student Pictures & Documents)

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
