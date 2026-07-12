# 12. Role and Permission Matrix

The API includes module-level role access. `super_admin` and `admin` can access every module. A `viewer` can read protected data but cannot change it.

| Module | Super Admin | Admin | Editor | HR | Sales | Viewer |
|---|---|---|---|---|---|---|
| Dashboard | Full | Full | View | View | View | View |
| Services, projects, team, blog, testimonials | Full | Full | Manage | No | No | View |
| Jobs and applications | Full | Full | No | Manage | No | View |
| Enquiries and quotations | Full | Full | No | No | Manage | View |
| Website settings | Full | Full | No | No | No | View |
| Users and roles | Full | Full | No | No | No | View |

## Recommended account practice

- Give every employee an individual account.
- Use `super_admin` only for company owners or system administrators.
- Use `admin` for trusted operational administrators.
- Deactivate accounts immediately when access is no longer required.
- Do not share the seeded administrator password.
