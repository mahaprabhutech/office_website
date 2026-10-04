import { useEffect, useMemo, useState } from 'react';
import api from '../services/api';
import { fallbackProjects } from '../data/fallback';
import PageHero from '../components/PageHero';
import ProjectCard from '../components/ProjectCard';
import '../styles/product-portfolio.css';

const priority = ['gaumitra', 'jeev-sathi'];

function mergePortfolio(apiItems = []) {
  const map = new Map();

  fallbackProjects.forEach((project) => map.set(project.slug, project));
  apiItems.forEach((project) => {
    const fallback = map.get(project.slug) || {};
    map.set(project.slug, { ...fallback, ...project });
  });

  return [...map.values()]
    .filter((project) => project.active !== false)
    .sort((a, b) => {
      const ai = priority.indexOf(a.slug);
      const bi = priority.indexOf(b.slug);
      if (ai !== -1 || bi !== -1) {
        if (ai === -1) return 1;
        if (bi === -1) return -1;
        return ai - bi;
      }
      return Number(a.sort_order || 99) - Number(b.sort_order || 99);
    });
}

export default function ProjectsPage() {
  const [items, setItems] = useState(() => mergePortfolio([]));

  useEffect(() => {
    api.get('/public/projects')
      .then((response) => setItems(mergePortfolio(response.data.data || response.data || [])))
      .catch(() => setItems(mergePortfolio([])));
  }, []);

  const flagship = useMemo(() => items.filter((item) => priority.includes(item.slug)), [items]);
  const other = useMemo(() => items.filter((item) => !priority.includes(item.slug)), [items]);

  return (
    <>
      <PageHero
        eyebrow="Products & innovation portfolio"
        title="Digital platforms built around real operational problems."
        text="Explore GauMitra, Jeev Sathi and our wider portfolio—products designed with practical workflows, responsible technology and scalable architecture."
      />

      <section className="section portfolio-intro">
        <div className="container portfolio-intro__grid">
          <div>
            <span className="eyebrow">Flagship products</span>
            <h2>Animal welfare and farmer-support technology with a clear end-to-end plan.</h2>
          </div>
          <p>
            Our flagship platforms connect field operations, animal-care records, location,
            veterinary support and responsible administration. Each product is presented below
            with its problem, solution, features, workflow, security approach and roadmap.
          </p>
        </div>

        <div className="container project-grid project-grid--portfolio">
          {flagship.map((item) => <ProjectCard key={item.slug} project={item} />)}
        </div>
      </section>

      {other.length > 0 && (
        <section className="section section--soft">
          <div className="container portfolio-section-head">
            <span className="eyebrow">More work</span>
            <h2>Additional products and client solutions.</h2>
          </div>
          <div className="container project-grid project-grid--portfolio">
            {other.map((item) => <ProjectCard key={item.slug || item.id} project={item} />)}
          </div>
        </section>
      )}
    </>
  );
}
