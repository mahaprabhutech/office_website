# MAHAPRABHU TECH INNOVATION PRIVATE LIMITED — Corporate Website

A modern corporate website and administration system built with a Laravel REST API and React.

## Included applications

| Folder | Purpose |
|---|---|
| `backend` | Laravel API, authentication, database, administration data management and uploads |
| `frontend` | Public corporate website and protected React admin panel |
| `docs` | Requirements, modules, database, API, workflows, installation, deployment and admin guide |

## Public modules

Home, About, Services, Projects, Technology, Team, Careers, Blog, Testimonials, Contact and Quotation Request.

## Admin modules

Dashboard, Services, Projects, Team, Careers, Job Applications, Blog, Enquiries, Quotations, Testimonials, Website Settings, Users and role-based access control.

## Brand implementation

The interface is designed around the supplied red, black and white company logo. The reusable design tokens are in `frontend/src/styles/theme.css`.

## Initial administrator

- Email: `admin@mahaprabhutech.com`
- Password: `ChangeMe@123`

Change this password immediately after the first login.


## Quick local start

On Windows, run `run-local-windows.bat`. On Linux/macOS, run `./run-local-linux.sh`.

For manual setup, follow `docs/06-INSTALLATION.md`.

## Package note

`vendor/` and `node_modules/` are intentionally excluded from the handover ZIP. They are generated dependency folders and should be installed locally using Composer and npm.
