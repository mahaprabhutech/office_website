import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import api from '../services/api';
import { fallbackServices } from '../data/fallback';
import Loading from '../components/Loading';

export default function ServiceDetailPage() {
  const { slug } = useParams();
  const [item, setItem] = useState(fallbackServices.find((x) => x.slug === slug));
  const [loading, setLoading] = useState(!item);

  useEffect(() => {
    api.get(`/public/services/${slug}`).then((r) => setItem(r.data)).catch(() => {}).finally(() => setLoading(false));
  }, [slug]);

  if (loading) return <Loading />;
  if (!item) return <div className="empty-state">Service not found.</div>;

  return (
    <>
      <section className="detail-hero">
        <div className="container"><span className="eyebrow">Technology service</span><h1>{item.title}</h1><p>{item.summary}</p><Link className="button" to="/request-quote">Request this service</Link></div>
      </section>
      <section className="section">
        <div className="container detail-grid">
          <div><h2>Service overview</h2><p>{item.description || item.summary}</p><h2>What you receive</h2><ul className="check-list">{(item.benefits || []).map((x) => <li key={x}>{x}</li>)}</ul></div>
          <aside className="detail-aside"><h3>Development workflow</h3>{(item.process || ['Discovery','Documentation','Design','Development','Testing','Deployment']).map((x, i) => <div key={x}><b>{String(i + 1).padStart(2, '0')}</b><span>{x}</span></div>)}</aside>
        </div>
      </section>
    </>
  );
}
