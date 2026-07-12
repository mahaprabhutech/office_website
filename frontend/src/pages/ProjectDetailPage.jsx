import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import api from '../services/api';
import { fallbackProjects } from '../data/fallback';
import Loading from '../components/Loading';

export default function ProjectDetailPage() {
  const { slug } = useParams();
  const [project, setProject] = useState(fallbackProjects.find((x) => x.slug === slug));
  const [loading, setLoading] = useState(!project);

  useEffect(() => {
    api.get(`/public/projects/${slug}`).then((r) => setProject(r.data)).catch(() => {}).finally(() => setLoading(false));
  }, [slug]);

  if (loading) return <Loading />;
  if (!project) return <div className="empty-state">Project not found.</div>;

  return (
    <>
      <section className="project-detail-hero">
        <div className="container">
          <span className="status-pill">{project.category}</span>
          <h1>{project.title}</h1>
          <p>{project.summary}</p>
          <div className="tech-tags">{(project.technologies || []).map((x) => <span key={x}>{x}</span>)}</div>
        </div>
      </section>
      <section className="section">
        <div className="container detail-grid">
          <div>
            <h2>Project overview</h2>
            <p>{project.description || project.summary}</p>
            <h2>Main features</h2>
            <ul className="check-list">{(project.features || []).map((x) => <li key={x}>{x}</li>)}</ul>
          </div>
          <aside className="project-summary">
            <span>Project status</span><strong>{project.project_status}</strong>
            <span>Category</span><strong>{project.category}</strong>
            <Link className="button" to="/contact">Discuss a similar project</Link>
          </aside>
        </div>
      </section>
    </>
  );
}
