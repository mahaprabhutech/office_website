import { useEffect, useMemo, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import api from '../services/api';
import { fallbackProjects } from '../data/fallback';
import { getProductProfile } from '../data/productProfiles';
import Loading from '../components/Loading';
import '../styles/product-portfolio.css';

function mediaUrl(value) {
  if (!value) return '';
  if (/^https?:\/\//i.test(value) || value.startsWith('/')) return value;
  return `/storage/${String(value).replace(/^storage\//, '')}`;
}

function list(value) {
  if (Array.isArray(value)) return value.filter(Boolean);
  if (!value) return [];
  if (typeof value === 'string') {
    try {
      const parsed = JSON.parse(value);
      if (Array.isArray(parsed)) return parsed.filter(Boolean);
    } catch {
      return value.split(/\r?\n/).map((item) => item.trim()).filter(Boolean);
    }
  }
  return [];
}

function number(value) {
  return String(value + 1).padStart(2, '0');
}

export default function ProjectDetailPage() {
  const { slug } = useParams();
  const fallback = fallbackProjects.find((item) => item.slug === slug);
  const [project, setProject] = useState(fallback || null);
  const [loading, setLoading] = useState(!fallback);

  useEffect(() => {
    let active = true;
    setLoading(!fallback);

    api.get(`/public/projects/${slug}`)
      .then(({ data }) => {
        if (!active) return;
        setProject({ ...(fallback || {}), ...data });
      })
      .catch(() => {
        if (active) setProject(fallback || null);
      })
      .finally(() => {
        if (active) setLoading(false);
      });

    return () => { active = false; };
  }, [slug]); // eslint-disable-line react-hooks/exhaustive-deps

  const profile = useMemo(() => getProductProfile(slug), [slug]);

  if (loading) return <Loading />;
  if (!project && !profile) return <div className="empty-state">Project not found.</div>;

  const current = { ...(project || {}), slug, title: project?.title || (slug === 'gaumitra' ? 'GauMitra' : 'Jeev Sathi') };
  const logo = mediaUrl(current.logo_image || current.cover_image || profile?.logo);
  const features = list(current.features);
  const technologies = list(current.technologies);
  const audiences = list(current.audiences);
  const workflow = list(current.workflow).length ? list(current.workflow) : (profile?.workflow || []);
  const roadmap = list(current.roadmap);
  const security = list(current.security_features).length ? list(current.security_features) : (profile?.security || []);
  const outcomes = list(current.impact_points).length ? list(current.impact_points) : (profile?.outcomes || []);
  const planLines = list(current.project_plan);
  const gallery = Array.isArray(current.images) ? current.images : [];
  const productType = current.product_type || profile?.productType || current.category || 'Digital Product';
  const tagline = current.tagline || profile?.tagline || current.summary;
  const heroHighlights = profile?.heroHighlights || [
    { value: '01', label: current.category || 'Digital platform' },
    { value: '02', label: current.project_status || 'In Development' },
    { value: '03', label: `${features.length || 'Multiple'} core capabilities` },
    { value: '04', label: 'Scalable implementation plan' },
  ];

  const stakeholderCards = audiences.length
    ? audiences.map((item, index) => ({
        title: profile?.stakeholders?.[index]?.title || `Stakeholder ${number(index)}`,
        text: item,
      }))
    : (profile?.stakeholders || []);

  const roadmapCards = roadmap.length
    ? roadmap.map((item, index) => ({
        phase: `Phase ${index + 1}`,
        title: item.split('—')[0]?.trim() || `Stage ${index + 1}`,
        text: item.split('—').slice(1).join('—').trim() || item,
      }))
    : (profile?.roadmap || []);

  const externalLinks = [
    current.website_url && { label: 'Open website', href: current.website_url },
    current.android_url && { label: 'Android app', href: current.android_url },
    current.ios_url && { label: 'iOS app', href: current.ios_url },
    current.brochure && { label: 'View brochure', href: mediaUrl(current.brochure) },
  ].filter(Boolean);

  return (
    <div className={`product-detail product-detail--${slug}`}>
      <section className={`product-hero product-hero--${slug}`}>
        <div className="product-hero__glow product-hero__glow--one" />
        <div className="product-hero__glow product-hero__glow--two" />
        <div className="container product-hero__grid">
          <div className="product-hero__copy">
            <Link to="/projects" className="product-back-link">← Products & projects</Link>
            <span className="product-kicker">{profile?.eyebrow || productType}</span>
            <h1>{current.title}</h1>
            <p className="product-hero__tagline">{tagline}</p>
            <p className="product-hero__summary">{current.summary}</p>

            <div className="product-hero__meta">
              <span className="status-pill">{current.project_status || 'In Development'}</span>
              <span>{productType}</span>
            </div>

            <div className="product-hero__actions">
              <a className="button" href="#features">Explore features</a>
              <a className="button button--ghost-dark" href="#roadmap">View project plan</a>
            </div>

            {externalLinks.length > 0 && (
              <div className="product-hero__external">
                {externalLinks.map((item) => (
                  <a key={item.label} href={item.href} target="_blank" rel="noreferrer">{item.label} ↗</a>
                ))}
              </div>
            )}
          </div>

          <div className="product-hero__visual">
            <div className="product-hero__visual-card">
              {logo ? <img src={logo} alt={`${current.title} product logo`} /> : <strong>{current.title}</strong>}
            </div>
            <div className="product-hero__mini product-hero__mini--top">
              <b>{heroHighlights[0]?.value}</b><span>{heroHighlights[0]?.label}</span>
            </div>
            <div className="product-hero__mini product-hero__mini--bottom">
              <b>{heroHighlights[1]?.value}</b><span>{heroHighlights[1]?.label}</span>
            </div>
          </div>
        </div>
      </section>

      <section className="product-stat-strip">
        <div className="container product-stat-grid">
          {heroHighlights.map((item) => (
            <div key={`${item.value}-${item.label}`}>
              <strong>{item.value}</strong>
              <span>{item.label}</span>
            </div>
          ))}
        </div>
      </section>

      <section className="section product-overview" id="overview">
        <div className="container product-section-heading">
          <span className="eyebrow">Product overview</span>
          <h2>Built around a real problem, not just a list of screens.</h2>
        </div>

        <div className="container product-problem-grid">
          <article className="product-narrative-card product-narrative-card--dark">
            <span>01 · The problem</span>
            <h3>What this product is designed to improve</h3>
            <p>{current.problem_statement || profile?.problem || current.description || current.summary}</p>
          </article>
          <article className="product-narrative-card">
            <span>02 · The solution</span>
            <h3>How {current.title} approaches it</h3>
            <p>{current.solution_overview || profile?.solution || current.description || current.summary}</p>
          </article>
        </div>
      </section>

      <section className="section section--soft" id="features">
        <div className="container product-section-heading product-section-heading--split">
          <div>
            <span className="eyebrow">Platform capabilities</span>
            <h2>Detailed modules designed around the user journey.</h2>
          </div>
          <p>Each capability connects to the same product workflow so users do not have to manage important information in disconnected tools.</p>
        </div>

        {profile?.featureGroups ? (
          <div className="container product-feature-grid">
            {profile.featureGroups.map((group) => (
              <article className="product-feature-card" key={group.number}>
                <div className="product-feature-card__head">
                  <b>{group.number}</b>
                  <div><h3>{group.title}</h3><p>{group.description}</p></div>
                </div>
                <ul>
                  {group.items.map((item) => <li key={item}>{item}</li>)}
                </ul>
              </article>
            ))}
          </div>
        ) : (
          <div className="container product-feature-grid product-feature-grid--simple">
            {features.map((feature, index) => (
              <article className="product-feature-card" key={feature}>
                <div className="product-feature-card__head"><b>{number(index)}</b><div><h3>{feature}</h3></div></div>
              </article>
            ))}
          </div>
        )}

        {profile?.featureGroups && features.length > 0 && (
          <div className="container product-capability-list">
            <span>Configured core capabilities</span>
            <div>{features.map((feature) => <b key={feature}>{feature}</b>)}</div>
          </div>
        )}
      </section>

      <section className="section product-workflow-section">
        <div className="container product-section-heading">
          <span className="eyebrow">End-to-end workflow</span>
          <h2>Easy to understand from first action to final outcome.</h2>
        </div>
        <div className="container product-workflow">
          {workflow.map((step, index) => (
            <article key={`${index}-${step}`}>
              <b>{number(index)}</b>
              <p>{step}</p>
            </article>
          ))}
        </div>
      </section>

      {stakeholderCards.length > 0 && (
        <section className="section section--dark product-audience-section">
          <div className="container product-section-heading">
            <span className="eyebrow">Who uses it</span>
            <h2>Different users, one connected service journey.</h2>
          </div>
          <div className="container product-audience-grid">
            {stakeholderCards.map((item, index) => (
              <article key={`${item.title}-${index}`}>
                <span>{number(index)}</span>
                <h3>{item.title}</h3>
                <p>{item.text}</p>
              </article>
            ))}
          </div>
        </section>
      )}

      <section className="section product-roadmap-section" id="roadmap">
        <div className="container product-section-heading product-section-heading--split">
          <div>
            <span className="eyebrow">Project plan & roadmap</span>
            <h2>A phased path from foundation to scalable operations.</h2>
          </div>
          <p>{current.project_plan || 'The product is structured in phases so the core user journey can be validated before adding wider operational integrations and scale.'}</p>
        </div>

        <div className="container product-roadmap">
          {roadmapCards.map((item, index) => (
            <article key={`${item.phase}-${index}`}>
              <span>{item.phase}</span>
              <b>{String(index + 1).padStart(2, '0')}</b>
              <h3>{item.title}</h3>
              <p>{item.text}</p>
            </article>
          ))}
        </div>

        {!profile?.roadmap && planLines.length > 0 && (
          <div className="container product-plan-lines">
            {planLines.map((item) => <div key={item}>{item}</div>)}
          </div>
        )}
      </section>

      <section className="section section--soft product-architecture-section">
        <div className="container product-architecture-grid">
          <div>
            <span className="eyebrow">Technology architecture</span>
            <h2>Designed as connected layers rather than isolated features.</h2>
            <p>The exact deployment can evolve with scale, but the architecture keeps user experience, application workflows, operational data, integrations and security responsibilities clearly separated.</p>

            <div className="tech-tags product-tech-tags">
              {technologies.map((technology) => <span key={technology}>{technology}</span>)}
            </div>
          </div>

          <div className="product-architecture-stack">
            {(profile?.architecture || []).map((layer, index) => (
              <article key={layer.label}>
                <b>{number(index)}</b>
                <div><h3>{layer.label}</h3><p>{layer.value}</p></div>
              </article>
            ))}
            {!profile?.architecture && technologies.map((technology, index) => (
              <article key={technology}><b>{number(index)}</b><div><h3>{technology}</h3><p>Part of the project technology stack.</p></div></article>
            ))}
          </div>
        </div>
      </section>

      <section className="section product-trust-section">
        <div className="container product-trust-grid">
          <div className="product-trust-card">
            <span className="eyebrow">Security & trust</span>
            <h2>Operational data should remain protected, scoped and recoverable.</h2>
            <ul>{security.map((item) => <li key={item}>{item}</li>)}</ul>
          </div>
          <div className="product-trust-card product-trust-card--impact">
            <span className="eyebrow">Expected impact</span>
            <h2>What better coordination can enable.</h2>
            <ul>{outcomes.map((item) => <li key={item}>{item}</li>)}</ul>
          </div>
        </div>
      </section>

      {gallery.length > 0 && (
        <section className="section section--soft">
          <div className="container product-section-heading">
            <span className="eyebrow">Product gallery</span>
            <h2>Interface and project visuals.</h2>
          </div>
          <div className="container product-gallery">
            {gallery.map((image, index) => (
              <figure key={image.id || `${image.image}-${index}`}>
                <img src={mediaUrl(image.image)} alt={image.caption || `${current.title} preview ${index + 1}`} />
                {image.caption && <figcaption>{image.caption}</figcaption>}
              </figure>
            ))}
          </div>
        </section>
      )}

      <section className="product-detail-cta">
        <div className="container product-detail-cta__inner">
          <div>
            <span>{current.title} · {productType}</span>
            <h2>Need a similar platform for your organisation or programme?</h2>
            <p>We can convert your operational requirement into modules, workflows, APIs, mobile/web interfaces, security controls and a practical implementation roadmap.</p>
          </div>
          <div className="product-detail-cta__actions">
            <Link className="button button--white" to="/request-quote">Request a project quote</Link>
            <Link className="button button--ghost-dark" to="/contact">Talk to our team</Link>
          </div>
        </div>
      </section>
    </div>
  );
}
