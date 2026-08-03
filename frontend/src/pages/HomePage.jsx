import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../services/api';
import { fallbackPosts, fallbackProjects, fallbackServices } from '../data/fallback';
import SectionTitle from '../components/SectionTitle';
import ServiceCard from '../components/ServiceCard';
import ProjectCard from '../components/ProjectCard';
import '../styles/spiritual-purpose.css';

const purposePillars = [
  {
    number: '01',
    title: 'Spiritual Technology',
    text: 'Digital platforms for temples, spiritual organisations, devotional communities and service-based institutions.',
  },
  {
    number: '02',
    title: 'Animal Welfare',
    text: 'Technology that supports cattle care, stray-animal rescue, treatment coordination, shelter management and field response.',
  },
  {
    number: '03',
    title: 'Responsible Innovation',
    text: 'Secure, practical and inclusive solutions designed to create measurable social and business value.',
  },
];

const focusAreas = [
  'Temple, trust and spiritual organisation platforms',
  'Animal rescue, ambulance and treatment coordination',
  'Gaushala, shelter and medicine inventory systems',
  'Mobile applications for volunteers and field teams',
  'Government, NGO and social-impact dashboards',
  'Business websites, APIs and cloud deployment',
];

export default function HomePage() {
  const [data, setData] = useState({
    services: fallbackServices,
    projects: fallbackProjects,
    posts: fallbackPosts,
    testimonials: [],
    settings: {},
  });

  useEffect(() => {
    let active = true;

    api.get('/public/home')
      .then(({ data: response }) => {
        if (!active) return;

        setData((current) => ({
          ...current,
          ...response,
          settings: {
            ...current.settings,
            ...(response?.settings || {}),
          },
          services: response?.services?.length
            ? response.services
            : current.services,
          projects: response?.projects?.length
            ? response.projects
            : current.projects,
          posts: response?.posts?.length
            ? response.posts
            : current.posts,
          testimonials: response?.testimonials || current.testimonials,
        }));
      })
      .catch(() => {
        // Keep local fallback content when the API is unavailable.
      });

    return () => {
      active = false;
    };
  }, []);

  return (
    <>
      <section className="hero purpose-hero">
        <div className="hero-orbit hero-orbit--one" />
        <div className="hero-orbit hero-orbit--two" />

        <div className="container hero-grid">
          <div className="hero-copy">
            <span className="eyebrow">
              Spiritual Technology · Animal Welfare · Responsible Innovation
            </span>

            <h1>
              {data.settings.hero_title || (
                <>
                  Technology inspired by <em>service, compassion and purpose.</em>
                </>
              )}
            </h1>

            <p>
              {data.settings.hero_subtitle ||
                'We create secure digital platforms for spiritual organisations, animal-welfare teams, institutions, businesses and social-impact initiatives.'}
            </p>

            <div className="hero-actions">
              <Link className="button" to="/request-quote">
                Start a Purposeful Project
              </Link>

              <Link className="button button--ghost" to="/projects">
                Explore Our Work
              </Link>
            </div>

            <div className="hero-trust">
              <span>Spiritual Platforms</span>
              <span>Animal Rescue</span>
              <span>Laravel</span>
              <span>React</span>
              <span>Cloud</span>
            </div>
          </div>

          <div className="hero-visual">
            <div className="purpose-ring purpose-ring--one" />
            <div className="purpose-ring purpose-ring--two" />

            <div className="eye-mark">
              <img
                src="/images/brand-symbol.png"
                alt="Mahaprabhu Tech brand symbol"
              />
            </div>

            <div className="floating-card floating-card--top">
              <strong>Seva</strong>
              <span>Technology for service</span>
            </div>

            <div className="floating-card floating-card--bottom">
              <strong>Compassion</strong>
              <span>Digital support for animal welfare</span>
            </div>

            <div className="hero-code">
              <i />
              <i />
              <i />
              <p>PURPOSE → DESIGN → BUILD → IMPACT</p>
            </div>
          </div>
        </div>
      </section>

      <section className="stats-strip">
        <div className="container stats-grid">
          <div>
            <strong>{data.settings.projects_count || '10+'}</strong>
            <span>Purpose-driven projects</span>
          </div>

          <div>
            <strong>{data.settings.solutions_count || '6+'}</strong>
            <span>Technology services</span>
          </div>

          <div>
            <strong>3</strong>
            <span>Core impact areas</span>
          </div>

          <div>
            <strong>24/7</strong>
            <span>Digital availability</span>
          </div>
        </div>
      </section>

      <section className="section purpose-intro-section">
        <div className="container">
          <SectionTitle
            eyebrow="Our greater purpose"
            title="We use technology to serve people, spiritual communities and animals."
            text="MAHAPRABHU TECH INNOVATION PRIVATE LIMITED combines software engineering with compassion, responsibility and social service."
          />

          <div className="purpose-grid">
            {purposePillars.map((pillar) => (
              <article className="purpose-card" key={pillar.number}>
                <span>{pillar.number}</span>
                <h3>{pillar.title}</h3>
                <p>{pillar.text}</p>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="section section--soft">
        <div className="container impact-split">
          <div>
            <SectionTitle
              eyebrow="Technology for compassion"
              title="Digital systems that strengthen animal rescue and care."
              text="Our solutions can help teams receive cases, locate animals, assign ambulances, coordinate treatment, manage medicines and maintain transparent records."
            />

            <ul className="purpose-check-list">
              <li>Stray-animal and cattle rescue case management</li>
              <li>Ambulance dispatch and live location tracking</li>
              <li>Veterinary treatment and follow-up records</li>
              <li>Gaushala, shelter, staff and capacity management</li>
              <li>Medicine stock, batch and expiry monitoring</li>
            </ul>

            <Link className="text-link" to="/projects">
              View our social-impact projects →
            </Link>
          </div>

          <div className="impact-panel">
            <span className="impact-panel__label">Our belief</span>
            <blockquote>
              “Technology becomes meaningful when it protects life, supports
              service and helps communities act with compassion.”
            </blockquote>

            <div className="impact-panel__metric">
              <strong>People + Animals + Purpose</strong>
              <span>Connected through responsible digital systems</span>
            </div>
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionTitle
            eyebrow="What we build"
            title="Technology services designed around real needs and meaningful outcomes."
            text="From discovery and documentation to design, development, deployment and support, every stage follows a practical workflow."
          />

          <div className="card-grid card-grid--three">
            {data.services
              .slice(0, 6)
              .map((service) => (
                <ServiceCard key={service.id} service={service} />
              ))}
          </div>

          <div className="section-action">
            <Link className="text-link" to="/services">
              View all services →
            </Link>
          </div>
        </div>
      </section>

      <section className="section section--dark">
        <div className="container">
          <SectionTitle
            eyebrow="Our innovation portfolio"
            title="Products with purpose, clarity and scalable technology."
            text="We focus on platforms that improve spiritual engagement, animal welfare, institutional coordination, service access and business operations."
          />

          <div className="project-grid">
            {data.projects
              .slice(0, 4)
              .map((project) => (
                <ProjectCard key={project.id} project={project} />
              ))}
          </div>
        </div>
      </section>

      <section className="section">
        <div className="container focus-grid">
          <div>
            <SectionTitle
              eyebrow="Where we contribute"
              title="Focused solutions for organisations that want technology with values."
              text="We work with spiritual institutions, government departments, NGOs, animal-welfare groups, startups and growing businesses."
            />
          </div>

          <div className="focus-list">
            {focusAreas.map((area, index) => (
              <div key={area}>
                <b>{String(index + 1).padStart(2, '0')}</b>
                <span>{area}</span>
              </div>
            ))}
          </div>
        </div>
      </section>

      <section className="section section--soft">
        <div className="container process-grid">
          <div>
            <SectionTitle
              eyebrow="How we work"
              title="A transparent and responsible development process."
              text="Every project moves through clear checkpoints so purpose, scope, quality and delivery remain visible."
            />

            <Link className="button button--ghost" to="/contact">
              Discuss your requirement
            </Link>
          </div>

          <ol className="process-list">
            <li>
              <b>01</b>
              <div>
                <h3>Understand the Purpose</h3>
                <p>
                  Identify users, service goals, operational challenges and
                  expected social or business impact.
                </p>
              </div>
            </li>

            <li>
              <b>02</b>
              <div>
                <h3>Document the System</h3>
                <p>
                  Define modules, workflows, database structure, APIs,
                  integrations, security and milestones.
                </p>
              </div>
            </li>

            <li>
              <b>03</b>
              <div>
                <h3>Design & Build</h3>
                <p>
                  Create an accessible interface and a dependable, scalable
                  technical architecture.
                </p>
              </div>
            </li>

            <li>
              <b>04</b>
              <div>
                <h3>Test, Deploy & Improve</h3>
                <p>
                  Validate the product, train users, deploy securely and
                  continuously improve after launch.
                </p>
              </div>
            </li>
          </ol>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionTitle
            eyebrow="Latest thinking"
            title="Insights, updates and purpose-led technology stories."
          />

          <div className="blog-grid">
            {data.posts.slice(0, 3).map((post) => (
              <article className="blog-card" key={post.id}>
                <span>{post.category}</span>
                <h3>{post.title}</h3>
                <p>{post.excerpt}</p>
                <Link to={`/blog/${post.slug}`}>Read article →</Link>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="cta purpose-cta">
        <div className="container cta-inner">
          <div>
            <span className="eyebrow">Build technology that serves a greater purpose</span>
            <h2>
              Let us convert your spiritual, animal-welfare or business idea
              into a clear digital solution.
            </h2>
          </div>

          <Link className="button button--white" to="/request-quote">
            Request a Project Quote
          </Link>
        </div>
      </section>
    </>
  );
}
