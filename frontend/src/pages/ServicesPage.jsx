import { useEffect, useState } from 'react';
import api from '../services/api';
import { fallbackServices } from '../data/fallback';
import PageHero from '../components/PageHero';
import ServiceCard from '../components/ServiceCard';

export default function ServicesPage() {
  const [items, setItems] = useState(fallbackServices);
  useEffect(() => { api.get('/public/services').then((r) => setItems(r.data.data || r.data)).catch(() => {}); }, []);
  return (
    <>
      <PageHero eyebrow="Services" title="Complete technology support from planning to production." text="Choose one service or engage us for an end-to-end digital product." />
      <section className="section"><div className="container card-grid card-grid--three">{items.map((item) => <ServiceCard key={item.id} service={item} />)}</div></section>
    </>
  );
}
