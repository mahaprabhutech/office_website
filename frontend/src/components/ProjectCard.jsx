import { Link } from 'react-router-dom';
import { getProductProfile, isFlagshipProduct } from '../data/productProfiles';
import '../styles/product-portfolio.css';

function mediaUrl(value) {
  if (!value) return '';
  if (/^https?:\/\//i.test(value) || value.startsWith('/')) return value;
  return `/storage/${String(value).replace(/^storage\//, '')}`;
}

export default function ProjectCard({ project }) {
  const profile = getProductProfile(project.slug);
  const flagship = isFlagshipProduct(project.slug);
  const visual = mediaUrl(project.logo_image || project.cover_image || profile?.logo);
  const technologies = Array.isArray(project.technologies) ? project.technologies.slice(0, 3) : [];

  return (
    <article className={`project-card product-card ${flagship ? 'product-card--flagship' : ''}`}>
      <div className="project-card__visual product-card__visual">
        <span className="product-card__category">{project.product_type || project.category}</span>
        {visual ? (
          <img className="product-card__logo" src={visual} alt={`${project.title} logo`} />
        ) : (
          <strong>{project.title.slice(0, 1)}</strong>
        )}
        <div className="product-card__visual-label">{flagship ? 'Mahaprabhu Tech Product' : 'Portfolio Project'}</div>
      </div>

      <div className="project-card__body product-card__body">
        <div className="product-card__meta">
          <span className="status-pill">{project.project_status || 'In Development'}</span>
          <span className="product-card__kind">{project.category}</span>
        </div>
        <h3>{project.title}</h3>
        <p className="product-card__tagline">{project.tagline || project.summary}</p>
        {project.tagline && <p>{project.summary}</p>}

        {technologies.length > 0 && (
          <div className="product-card__tech">
            {technologies.map((item) => <span key={item}>{item}</span>)}
          </div>
        )}

        <Link className="product-card__link" to={`/projects/${project.slug}`}>
          {flagship ? 'Explore product' : 'View project'} <span aria-hidden="true">→</span>
        </Link>
      </div>
    </article>
  );
}
