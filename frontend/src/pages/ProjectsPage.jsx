import { useEffect, useState } from 'react';
import api from '../services/api';
import { fallbackProjects } from '../data/fallback';
import PageHero from '../components/PageHero';
import ProjectCard from '../components/ProjectCard';

export default function ProjectsPage() {
  const [items, setItems] = useState(fallbackProjects);
  useEffect(() => { api.get('/public/projects').then((r) => setItems(r.data.data || r.data)).catch(() => {}); }, []);
  return (
    <>
      <PageHero eyebrow="Innovation portfolio" title="Digital products designed for measurable impact." text="Explore our platforms, active products and solution concepts." />
      <section className="section section--dark"><div className="container project-grid">{items.map((item) => <ProjectCard key={item.id} project={item} />)}</div></section>
    </>
  );
}
