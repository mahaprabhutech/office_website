# 13. Testing and Handover Checklist

## Included verification

- React production build command: `npm run build`
- PHP syntax check for all backend PHP files
- Public API fallback data for early UI preview
- Seed data for services, projects, article, testimonial and administrator

## Functional acceptance checklist

### Public website

- Home page loads on mobile and desktop.
- All navigation links work.
- Service and project detail pages open.
- Contact and quotation forms save records.
- Job application accepts PDF/DOC/DOCX resume files.
- Legal pages open from the footer.

### Admin panel

- Administrator can log in and log out.
- Dashboard counts load.
- Content can be created, edited and deleted.
- Enquiry status and notes can be updated.
- Quotation estimate and status can be updated.
- Job application status can be updated and resume downloaded.
- Website settings save correctly.
- Role restrictions return HTTP 403 for unauthorised module changes.

### Production

- `.env` secrets are not committed.
- HTTPS is enabled.
- CORS only allows the production frontend domain.
- Storage link and directory permissions are correct.
- Mail delivery is configured and tested.
- Daily database and file backups are enabled.
- Default administrator password is changed.

## Handover items

- Source-code ZIP
- Database migrations and seed data
- Environment examples
- Deployment document
- API document
- Admin guide
- Brand assets and UI guide
- Final production credentials supplied through a secure channel
