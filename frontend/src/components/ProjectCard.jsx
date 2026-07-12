import { Link } from 'react-router-dom';

export default function ProjectCard({ project }) {
  return (
    <article className="project-card">
      <div className="project-card__visual">
        <span>{project.category}</span>
        <strong>{project.title.slice(0, 1)}</strong>
      </div>
      <div className="project-card__body">
        <div className="status-pill">{project.project_status}</div>
        <h3>{project.title}</h3>
        <p>{project.summary}</p>
        <Link to={`/projects/${project.slug}`}>View project →</Link>
      </div>
    </article>
  );
}
