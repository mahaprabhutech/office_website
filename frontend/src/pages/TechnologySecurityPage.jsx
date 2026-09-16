import PageHero from '../components/PageHero';
import SectionTitle from '../components/SectionTitle';
import '../styles/technology-security.css';

const gpsSteps = [
  { number: '01', title: 'Case', text: 'An emergency animal-welfare case is registered in the approved system.' },
  { number: '02', title: 'Assign', text: 'An ambulance is selected and linked with the active case and trip.' },
  { number: '03', title: 'GPS', text: 'The approved vehicle GPS device sends live location and movement data.' },
  { number: '04', title: 'Secure API', text: 'The server validates the registered device and receives the location securely.' },
  { number: '05', title: 'Dashboard', text: 'Authorized teams see the latest position, case and trip status on the live dashboard.' },
];

const capturedData = [
  ['Ambulance & Device', 'Vehicle number, ambulance ID, GPS IMEI/device ID, district, facility and assigned driver.'],
  ['Live GPS', 'Latitude/longitude, speed, heading, device or ignition status, GPS time and last update.'],
  ['Emergency Case', 'Case ID with dispatch, en-route, arrival, rescue/transport and completion timestamps.'],
  ['Trip Evidence', 'Route history, start/end, kilometres travelled, stale/offline periods and movement history.'],
  ['Medical Admin', 'Fleet map, availability, active cases, district/facility filters, latest GPS and trip status.'],
];

const gpsResponsibilities = [
  ['GPS Device Control', 'Map each approved GPS device to the correct ambulance, district and medical facility, and coordinate connectivity with the GPS provider.'],
  ['API & Dashboard', 'Operate the GPS ingestion API, validate device/location data, maintain current and historical positions, and keep authorized dashboards available.'],
  ['Live Monitoring', 'Watch GPS freshness, stale/offline vehicles, invalid coordinates and system/API failures, with incident logging and escalation.'],
  ['Security & Backup', 'Apply role-based access, HTTPS/TLS, protected credentials and audit logging, with automated backups and restoration testing.'],
  ['Technical Support', 'Receive integration issues, diagnose them, coordinate with network/GPS vendors where required, and verify closure.'],
  ['MIS & Reporting', 'Provide authorized reporting on trips, response time, GPS availability, kilometres travelled, offline duration and unresolved technical issues.'],
];

const securityControls = [
  ['Role-based access', 'Administrative, operational, support and development access is limited according to assigned responsibility and need-to-know.'],
  ['Strong account protection', 'Privileged accounts use individual access, MFA where supported, periodic review and prompt revocation when access is no longer required.'],
  ['Encryption & secret handling', 'HTTPS/TLS protects data in transit. Passwords are not stored in plain text, and API/database credentials stay outside source code in protected environment or secret controls.'],
  ['Application & API security', 'Production and development are separated. Public APIs use authentication, authorization, validation and rate limiting appropriate to the service.'],
  ['Database protection', 'Sensitive database access is restricted. Where Supabase is used with direct client access, Row Level Security policies are enabled and tested as required by the architecture.'],
  ['Monitoring & audit trail', 'Authentication, privileged actions, critical changes, backup failures and major application errors are logged where technically feasible and reviewed for unusual activity.'],
];

const recoveryItems = [
  ['Automated database recovery', 'Daily backup and/or Point-in-Time Recovery is used where the active platform and project plan support it.'],
  ['Separate file protection', 'Critical uploaded files/object storage use a separate copy, versioning or scheduled backup because database recovery alone may not restore deleted file objects.'],
  ['Off-account copy', 'Critical production data has a logically separate encrypted disaster-recovery copy, with a policy target of at least monthly generations.'],
  ['Restore testing', 'Representative database/file restoration is tested at least quarterly for critical systems and the result is documented.'],
];

const incidentSteps = [
  ['Detect & Record', 'Record the affected system, time, symptoms, reporter and initial severity.'],
  ['Contain', 'Restrict compromised accounts, keys, endpoints or services while preserving required logs/evidence.'],
  ['Assess', 'Determine affected data, failure or attack path, business impact and whether restoration is required.'],
  ['Recover', 'Restore from a verified clean recovery point, rotate exposed credentials, correct the root cause and validate the service.'],
  ['Notify & Review', 'Notify the relevant client/department or authorities when required, then document root cause and preventive actions.'],
];

export default function TechnologySecurityPage() {
  return (
    <>
      <PageHero
        eyebrow="Technology operations & protection"
        title="GPS-verified operations and layered data protection."
        text="See how Mahaprabhu Tech Innovation Private Limited manages animal-ambulance GPS tracking and the security, backup and recovery controls used for company-managed digital systems."
      />

      <section className="tech-docbar">
        <div className="container tech-docbar__inner">
          <div>
            <strong>Official company plans</strong>
            <span>Read the complete workflow and security documents used as the basis for this page.</span>
          </div>
          <div className="tech-docbar__actions">
            <a className="button button--small" href="/documents/gps-ambulance-workflow.pdf" target="_blank" rel="noreferrer">
              GPS Workflow PDF
            </a>
            <a className="button button--small button--ghost" href="/documents/data-security-backup-plan-2026.pdf" target="_blank" rel="noreferrer">
              Data Security Plan PDF
            </a>
          </div>
        </div>
      </section>

      <section className="section" id="gps-tracking">
        <div className="container">
          <SectionTitle
            eyebrow="GPS ambulance tracking"
            title="How GPS works in our company-managed system."
            text="The approved GPS device, emergency case, ambulance, trip and Medical Admin dashboard remain linked from dispatch through completion."
          />

          <div className="gps-workflow" aria-label="GPS ambulance tracking workflow">
            {gpsSteps.map((step, index) => (
              <article className="gps-step" key={step.number}>
                <div className="gps-step__top">
                  <span>{step.number}</span>
                  {index < gpsSteps.length - 1 && <b aria-hidden="true">→</b>}
                </div>
                <h3>{step.title}</h3>
                <p>{step.text}</p>
              </article>
            ))}
          </div>

          <div className="gps-status-strip">
            <strong>Operational journey</strong>
            <span>EN ROUTE → ARRIVED → RESCUE / TREATMENT → TRANSPORT (IF REQUIRED) → COMPLETED</span>
          </div>

          <div className="tech-note">
            <strong>Control boundary:</strong> GPS location verifies vehicle movement. Rescue decisions and case-status actions remain with authorized officials and staff. Registered GPS devices are mapped to approved ambulances; unknown device IDs can be rejected or flagged. A 180-second stale threshold is recommended for highlighting delayed GPS updates.
          </div>
        </div>
      </section>

      <section className="section section--soft">
        <div className="container">
          <SectionTitle
            eyebrow="Operational visibility"
            title="What the GPS system captures."
            text="The system combines live movement with case and trip records so authorized teams can review operations and produce traceable MIS."
          />

          <div className="tech-card-grid tech-card-grid--five">
            {capturedData.map(([title, text], index) => (
              <article className="tech-info-card" key={title}>
                <span>{String(index + 1).padStart(2, '0')}</span>
                <h3>{title}</h3>
                <p>{text}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="section section--dark">
        <div className="container">
          <SectionTitle
            eyebrow="Company management"
            title="How Mahaprabhu Tech manages the technology layer."
            text="The company role covers platform operation, GPS integration, monitoring, security, backup, technical support and authorized reporting."
          />

          <div className="responsibility-grid">
            {gpsResponsibilities.map(([title, text]) => (
              <article key={title}>
                <h3>{title}</h3>
                <p>{text}</p>
              </article>
            ))}
          </div>

          <div className="daily-cycle">
            <h3>Daily operating cycle</h3>
            <div>
              <span><b>Morning</b> Verify server/API, GPS feed, backup success and offline vehicles.</span>
              <span><b>During operations</b> Monitor live locations, case-linked trips and GPS exceptions.</span>
              <span><b>Incident</b> Log → diagnose → coordinate/escalate → resolve → verify closure.</span>
              <span><b>End of day</b> Verify completed trips, GPS exceptions and backup status.</span>
              <span><b>Periodic</b> Submit authorized MIS and test backup restoration.</span>
            </div>
          </div>
        </div>
      </section>

      <section className="section" id="data-security">
        <div className="container">
          <SectionTitle
            eyebrow="Data security"
            title="How we protect company-managed data."
            text="Our security plan uses layered access, encryption, application controls, monitoring, backups and tested recovery procedures to protect confidentiality, integrity and availability."
          />

          <div className="security-grid">
            {securityControls.map(([title, text], index) => (
              <article className="security-card" key={title}>
                <span>{String(index + 1).padStart(2, '0')}</span>
                <div>
                  <h3>{title}</h3>
                  <p>{text}</p>
                </div>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="section section--soft">
        <div className="container recovery-grid">
          <div>
            <SectionTitle
              eyebrow="Backup & disaster recovery"
              title="Backups are useful only when recovery is proven."
              text="Our plan follows a 3-2-1-oriented approach where practical: multiple copies of critical data, more than one storage location or class, and a logically separate recovery copy for major incidents."
            />

            <div className="recovery-list">
              {recoveryItems.map(([title, text]) => (
                <article key={title}>
                  <h3>{title}</h3>
                  <p>{text}</p>
                </article>
              ))}
            </div>
          </div>

          <aside className="recovery-targets">
            <span className="recovery-targets__eyebrow">Critical-system policy targets</span>
            <div>
              <strong>≤ 4 hours</strong>
              <span>Target RPO where platform capabilities permit; otherwise the latest successful scheduled backup.</span>
            </div>
            <div>
              <strong>≤ 8 hours</strong>
              <span>Target RTO after infrastructure access is available, subject to incident severity and external-provider availability.</span>
            </div>
            <div>
              <strong>Quarterly</strong>
              <span>Sample restore testing for critical databases/files, with issues and corrective actions recorded.</span>
            </div>
          </aside>
        </div>
      </section>

      <section className="section supabase-section">
        <div className="container">
          <SectionTitle
            eyebrow="Supabase protection process"
            title="Primary data, recovery paths and separate object protection."
            text="Where a project uses Supabase, database recovery, replication and object-storage protection are treated as separate layers. Read replicas can improve availability or read performance, but are not treated as a replacement for backups."
          />

          <div className="architecture-flow" aria-label="Supabase data protection architecture">
            <div className="architecture-node architecture-node--app">
              <small>Applications</small>
              <strong>Mobile / Web / Admin / API</strong>
            </div>
            <span className="architecture-arrow" aria-hidden="true">→</span>
            <div className="architecture-node architecture-node--primary">
              <small>Primary database</small>
              <strong>Postgres read + write</strong>
            </div>
            <span className="architecture-arrow" aria-hidden="true">→</span>
            <div className="architecture-node architecture-node--replica">
              <small>Read replica(s)</small>
              <strong>Asynchronous read-only copy</strong>
            </div>
          </div>

          <div className="architecture-flow architecture-flow--secondary">
            <div className="architecture-node">
              <small>Storage buckets</small>
              <strong>Files / object data</strong>
            </div>
            <span className="architecture-arrow" aria-hidden="true">→</span>
            <div className="architecture-node">
              <small>Separate object protection</small>
              <strong>Copy / versioning / scheduled backup</strong>
            </div>
            <span className="architecture-arrow" aria-hidden="true">→</span>
            <div className="architecture-node">
              <small>Disaster recovery</small>
              <strong>Encrypted off-account export / recovery copy</strong>
            </div>
          </div>

          <p className="architecture-caption">
            Provider-managed backup or PITR is used according to the active project capabilities. If provider retention is shorter than the company policy target, additional encrypted exports or off-account copies are maintained for the required period.
          </p>
        </div>
      </section>

      <section className="section section--dark">
        <div className="container">
          <SectionTitle
            eyebrow="Incident response"
            title="A clear process from detection to verified recovery."
            text="Security and recovery events are handled through a documented sequence so actions can be traced, reviewed and improved."
          />

          <ol className="incident-timeline">
            {incidentSteps.map(([title, text], index) => (
              <li key={title}>
                <span>{index + 1}</span>
                <div>
                  <h3>{title}</h3>
                  <p>{text}</p>
                </div>
              </li>
            ))}
          </ol>

          <div className="security-disclosure">
            <strong>Transparency note</strong>
            <p>
              This page summarizes company security controls and policy targets. It does not represent ISO, SOC or another external certification unless a separate valid certificate has been issued.
            </p>
          </div>
        </div>
      </section>

      <section className="tech-final-cta">
        <div className="container tech-final-cta__inner">
          <div>
            <span className="eyebrow">Need the complete documents?</span>
            <h2>Review our detailed GPS workflow and Data Security &amp; Backup Plan.</h2>
          </div>
          <div>
            <a className="button button--white" href="/documents/gps-ambulance-workflow.pdf" target="_blank" rel="noreferrer">Open GPS Plan</a>
            <a className="button button--ghost-dark" href="/documents/data-security-backup-plan-2026.pdf" target="_blank" rel="noreferrer">Open Security Plan</a>
          </div>
        </div>
      </section>
    </>
  );
}
