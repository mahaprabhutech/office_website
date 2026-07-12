# 4. API Documentation

Local base URL: `http://127.0.0.1:8000/api`

## Public endpoints

| Method | Endpoint | Description |
|---|---|---|
| GET | `/public/home` | Homepage data |
| GET | `/public/services` | Active services |
| GET | `/public/services/{slug}` | Service details |
| GET | `/public/projects` | Active projects |
| GET | `/public/projects/{slug}` | Project details |
| GET | `/public/team` | Team profiles |
| GET | `/public/jobs` | Open jobs |
| GET | `/public/posts` | Published articles |
| GET | `/public/settings` | Public settings |
| POST | `/contact` | Submit enquiry |
| POST | `/quotations` | Submit quotation |
| POST | `/jobs/{job}/apply` | Submit job application |

## Login

`POST /auth/login`

```json
{
  "email": "admin@mahaprabhutech.com",
  "password": "ChangeMe@123"
}
```

Send the returned token as:

```http
Authorization: Bearer TOKEN
Accept: application/json
```

## Protected admin resources

`/admin/dashboard`, `/admin/services`, `/admin/projects`, `/admin/team-members`, `/admin/jobs`, `/admin/job-applications`, `/admin/job-applications/{id}/resume`, `/admin/blog-posts`, `/admin/testimonials`, `/admin/enquiries`, `/admin/quotations`, `/admin/users`, `/admin/settings`.
