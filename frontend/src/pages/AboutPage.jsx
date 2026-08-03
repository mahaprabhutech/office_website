import { Link } from 'react-router-dom';
import PageHero from '../components/PageHero';
import SectionTitle from '../components/SectionTitle';
import '../styles/spiritual-purpose.css';

const values = [
  {
    number: '01',
    title: 'Seva',
    text: 'We see technology as a means to support service, dignity and meaningful action.',
  },
  {
    number: '02',
    title: 'Compassion',
    text: 'We design with care for people, animals, volunteers, field teams and communities.',
  },
  {
    number: '03',
    title: 'Integrity',
    text: 'We communicate clearly, protect data and build responsibly.',
  },
  {
    number: '04',
    title: 'Innovation',
    text: 'We turn practical challenges into simple, scalable and useful digital systems.',
  },
  {
    number: '05',
    title: 'Inclusion',
    text: 'We make technology understandable and accessible for users at every level.',
  },
  {
    number: '06',
    title: 'Impact',
    text: 'We measure success by the real improvement our solutions create.',
  },
];

export default function AboutPage() {
  return (
    <>
      <PageHero
        eyebrow="About our company"
        title="A spiritual software company building technology for service, compassion and progress."
        text="MAHAPRABHU TECH INNOVATION PRIVATE LIMITED develops digital products for spiritual organisations, animal-welfare initiatives, institutions, businesses and communities."
      />

      <section className="section">
        <div className="container about-story-grid">
          <div>
            <SectionTitle
              eyebrow="Who we are"
              title="Technology guided by values and grounded in practical execution."
            />

            <p>
              MAHAPRABHU TECH INNOVATION PRIVATE LIMITED is an Odisha-based
              technology company with a purpose beyond software delivery. We
              believe digital innovation should strengthen service, improve
              coordination and protect life.
            </p>

            <p>
              Our company brings together spiritual values, social
              responsibility and modern software engineering. We create
              websites, mobile applications, administration panels, APIs,
              cloud systems and digital platforms that are secure,
              user-friendly and ready to scale.
            </p>

            <p>
              We have a special commitment to technology for temples,
              spiritual organisations, gaushalas, veterinary services,
              animal-rescue teams, NGOs and public-service initiatives.
            </p>
          </div>

          <div className="brand-panel purpose-brand-panel">
            <img
              src="/images/brand-symbol.png"
              alt="Mahaprabhu Tech brand symbol"
            />

            <strong>
              Build with clarity.
              <br />
              Serve with compassion.
              <br />
              <em>Innovate with purpose.</em>
            </strong>

            <p>
              Our identity represents awareness, responsibility and a focused
              vision for meaningful digital progress.
            </p>
          </div>
        </div>
      </section>

      <section className="section section--soft">
        <div className="container">
          <SectionTitle
            eyebrow="Our foundation"
            title="Vision, mission and purpose."
            text="These principles guide what we build, how we work and the impact we want to create."
          />

          <div className="value-grid purpose-foundation-grid">
            <article>
              <span>01</span>
              <h3>Vision</h3>
              <p>
                To become a trusted spiritual and social-impact technology
                company that uses innovation to improve services, protect
                animals and strengthen communities.
              </p>
            </article>

            <article>
              <span>02</span>
              <h3>Mission</h3>
              <p>
                To build secure, documented and user-friendly digital
                solutions for spiritual institutions, animal-welfare
                organisations, government, NGOs and businesses.
              </p>
            </article>

            <article>
              <span>03</span>
              <h3>Purpose</h3>
              <p>
                To make technology a practical instrument of seva,
                compassion, transparency and responsible development.
              </p>
            </article>
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container impact-split">
          <div>
            <SectionTitle
              eyebrow="Our commitment to animal welfare"
              title="Helping rescue teams respond faster and care systems work better."
              text="Stray and injured animals often depend on timely reporting, accurate location, coordinated transport, medicine availability and transparent follow-up."
            />

            <p>
              We design connected systems that can bring citizens, veterinary
              teams, ambulances, shelters, gaushalas, district administrators
              and government departments onto one coordinated digital
              platform.
            </p>

            <ul className="purpose-check-list">
              <li>Citizen reporting with photo, location and case details</li>
              <li>Nearest-team assignment and ambulance tracking</li>
              <li>Treatment history and recovery follow-up</li>
              <li>Medicine, stock and veterinary facility management</li>
              <li>District-wise dashboards, analytics and accountability</li>
            </ul>
          </div>

          <div className="impact-panel impact-panel--light">
            <span className="impact-panel__label">Why it matters</span>

            <h3>Compassion needs coordination.</h3>

            <p>
              A good digital system reduces delay, improves communication and
              helps every responsible person understand the next action.
            </p>

            <div className="impact-panel__metric">
              <strong>Rescue → Treatment → Recovery</strong>
              <span>A transparent journey supported by technology</span>
            </div>
          </div>
        </div>
      </section>

      <section className="section section--dark">
        <div className="container">
          <SectionTitle
            eyebrow="What makes us different"
            title="We combine spiritual purpose with professional technology execution."
            text="Our approach is not limited to design or coding. We understand the service model, document the workflow and build for real-world use."
          />

          <div className="purpose-difference-grid">
            <article>
              <h3>Purpose-first thinking</h3>
              <p>
                We begin by understanding whom the system will serve and what
                meaningful change it should create.
              </p>
            </article>

            <article>
              <h3>Field-ready workflows</h3>
              <p>
                We design for staff, volunteers, administrators and users who
                need simple actions, clear status and reliable records.
              </p>
            </article>

            <article>
              <h3>Secure engineering</h3>
              <p>
                We use structured architecture, role-based access, validation,
                backups and responsible data practices.
              </p>
            </article>

            <article>
              <h3>Long-term support</h3>
              <p>
                We plan deployment, training, maintenance, monitoring and
                future expansion from the beginning.
              </p>
            </article>
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionTitle
            eyebrow="Our values"
            title="The principles behind every solution."
          />

          <div className="purpose-values-grid">
            {values.map((value) => (
              <article key={value.number}>
                <span>{value.number}</span>
                <h3>{value.title}</h3>
                <p>{value.text}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="section section--soft">
        <div className="container about-closing">
          <div>
            <span className="eyebrow">Our promise</span>
            <h2>
              We will build responsibly, communicate transparently and keep
              the project purpose visible at every stage.
            </h2>
          </div>

          <div className="about-closing__actions">
            <Link className="button" to="/request-quote">
              Share Your Project Idea
            </Link>

            <Link className="button button--ghost" to="/contact">
              Contact Our Team
            </Link>
          </div>
        </div>
      </section>
    </>
  );
}
