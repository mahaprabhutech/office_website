# React Corporate Website and Admin Panel

This React application provides:

- Responsive public corporate website
- Home, About, Services, Projects, Team, Careers, Blog, Contact and Quotation pages
- Protected administration interface
- Service, project, team, career, article and testimonial content management
- Enquiry follow-up management
- Website settings
- API fallback content so the public design can still be previewed before the Laravel API is started

## Start

```bash
npm install
cp .env.example .env
npm run dev
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
npm run dev
```

The default API URL is `http://127.0.0.1:8000/api`.

## Production build

```bash
npm run build
```

Upload the generated `dist/` files to the public web root, or deploy them using your preferred static hosting service.

## Branding

Brand variables are stored in `src/styles/theme.css` and the supplied logo files are under `public/images/`.
