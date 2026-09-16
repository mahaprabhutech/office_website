MAHAPRABHU TECH - GPS & DATA SECURITY WEBSITE UPDATE
===================================================

This ZIP contains ONLY the files required for this update.

WHAT IS ADDED
- New public page: /technology-security
- GPS animal ambulance workflow section
- GPS data captured and company management responsibilities
- Daily GPS operating cycle and 180-second stale recommendation
- Data security controls: RBAC, MFA where supported, HTTPS/TLS, secrets protection, API security, monitoring/audit logs
- Backup and disaster recovery summary with RPO/RTO policy targets
- Supabase backup/replication/object-copy architecture summary
- Incident response process
- Official GPS workflow PDF and Data Security & Backup Plan PDF as public documents
- New "Technology" link in the website header
- New "GPS & Data Security" link in the footer

FILES TO COPY
Copy the included "frontend" folder over your existing project's frontend folder, preserving the paths.

New files:
frontend/src/pages/TechnologySecurityPage.jsx
frontend/src/styles/technology-security.css
frontend/public/documents/gps-ambulance-workflow.pdf
frontend/public/documents/data-security-backup-plan-2026.pdf

Updated files:
frontend/src/App.jsx
frontend/src/components/Header.jsx
frontend/src/components/Footer.jsx

AFTER COPYING
From the frontend directory run:
  npm install
  npm run build

Then deploy the generated dist folder using your normal production deployment process.
