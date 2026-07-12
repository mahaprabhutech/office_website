import { Link } from 'react-router-dom';

export default function ServiceCard({ service }) {
  return (
    <article className="service-card">
      <div className="service-number">{service.icon || String(service.id).padStart(2, '0')}</div>
      <h3>{service.title}</h3>
      <p>{service.summary}</p>
      <Link to={`/services/${service.slug}`}>Explore service <span>→</span></Link>
    </article>
  );
}
