import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../services/api';
import { fallbackPosts, fallbackProjects, fallbackServices } from '../data/fallback';
import SectionTitle from '../components/SectionTitle';
import ServiceCard from '../components/ServiceCard';
import ProjectCard from '../components/ProjectCard';

export default function HomePage() {
  const [data, setData] = useState({
    services: fallbackServices,
    projects: fallbackProjects,
    posts: fallbackPosts,
    testimonials: [],
    settings: {},
  });

  useEffect(() => {
    api.get('/public/home').then(({ data }) => setData(data)).catch(() => {});
  }, []);

  return (
    <>
      <section className="hero">
        <div className="hero-orbit hero-orbit--one" />
        <div className="hero-orbit hero-orbit--two" />
        <div className="container hero-grid">
          <div className="hero-copy">
            <span className="eyebrow">Digital Innovation · Odisha · India</span>
            <h1>{data.settings.hero_title || <>Technology that creates <em>meaningful progress.</em></>}</h1>
            <p>{data.settings.hero_subtitle || 'We develop secure websites, mobile applications and digital platforms for businesses, institutions and social-impact initiatives.'}</p>
            <div className="hero-actions">
              <Link className="button" to="/request-quote">Start a Project</Link>
              <Link className="button button--ghost" to="/projects">Explore Our Work</Link>
            </div>
            <div className="hero-trust"><span>Laravel</span><span>React</span><span>React Native</span><span>Cloud</span></div>
          </div>
          <div className="hero-visual">
            <div className="eye-mark"><img src="/images/brand-symbol.png" alt="Mahaprabhu Tech brand symbol" /></div>
            <div className="floating-card floating-card--top"><strong>Strategy</strong><span>Clear roadmaps</span></div>
            <div className="floating-card floating-card--bottom"><strong>Engineering</strong><span>Reliable products</span></div>
            <div className="hero-code"><i /><i /><i /><p>IDEA → DESIGN → BUILD → SCALE</p></div>
          </div>
        </div>
      </section>

      <section className="stats-strip">
        <div className="container stats-grid">
          <div><strong>{data.settings.projects_count || '10+'}</strong><span>Projects planned</span></div>
          <div><strong>{data.settings.solutions_count || '6+'}</strong><span>Technology services</span></div>
          <div><strong>100%</strong><span>Requirement focused</span></div>
          <div><strong>24/7</strong><span>Digital availability</span></div>
        </div>
      </section>

      <section className="section">
        <div className="container">
          <SectionTitle eyebrow="What we build" title="Technology services designed around real business needs." text="From idea and documentation to design, development and deployment, every stage follows a practical workflow." />
          <div className="card-grid card-grid--three">
            {data.services.slice(0, 6).map((service) => <ServiceCard key={service.id} service={service} />)}
          </div>
          <div className="section-action"><Link className="text-link" to="/services">View all services →</Link></div>
        </div>
      </section>

      <section className="section section--dark">
        <div className="container">
          <SectionTitle eyebrow="Our innovation portfolio" title="Products with purpose, clarity and scalable technology." text="We focus on digital platforms that improve coordination, service access and business operations." />
          <div className="project-grid">{data.projects.slice(0, 4).map((project) => <ProjectCard key={project.id} project={project} />)}</div>
        </div>
      </section>

      <section className="section">
        <div className="container process-grid">
          <div>
            <SectionTitle eyebrow="How we work" title="A transparent development process." text="Every project moves through clear checkpoints so scope, quality and delivery remain visible." />
            <Link className="button button--ghost" to="/contact">Discuss your requirement</Link>
          </div>
          <ol className="process-list">
            <li><b>01</b><div><h3>Discover</h3><p>Understand users, goals, risks and integrations.</p></div></li>
            <li><b>02</b><div><h3>Document</h3><p>Prepare modules, workflows, database, APIs and milestones.</p></div></li>
            <li><b>03</b><div><h3>Design & Build</h3><p>Create a consistent interface and reliable architecture.</p></div></li>
            <li><b>04</b><div><h3>Test & Scale</h3><p>Validate, deploy, monitor and improve after launch.</p></div></li>
          </ol>
        </div>
      </section>

      <section className="section section--soft">
        <div className="container">
          <SectionTitle eyebrow="Latest thinking" title="Insights, updates and company news." />
          <div className="blog-grid">
            {data.posts.slice(0, 3).map((post) => (
              <article className="blog-card" key={post.id}>
                <span>{post.category}</span><h3>{post.title}</h3><p>{post.excerpt}</p><Link to={`/blog/${post.slug}`}>Read article →</Link>
              </article>
            ))}
          </div>
        </div>
      </section>

      <section className="cta">
        <div className="container cta-inner">
          <div><span className="eyebrow">Have a digital product in mind?</span><h2>Let us convert your requirement into a clear technology plan.</h2></div>
          <Link className="button button--white" to="/request-quote">Request a Project Quote</Link>
        </div>
      </section>
    </>
  );
}
