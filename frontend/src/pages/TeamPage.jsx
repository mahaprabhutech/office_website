import { useEffect, useState } from 'react';
import api from '../services/api';
import PageHero from '../components/PageHero';

const fallback = [
  { id: 1, name: 'Leadership Team', designation: 'Strategy & Management', bio: 'Guides company direction, client communication and product priorities.' },
  { id: 2, name: 'Engineering Team', designation: 'Web, Mobile & API', bio: 'Builds secure, scalable and maintainable applications.' },
  { id: 3, name: 'Design & Quality', designation: 'UI/UX & Testing', bio: 'Creates user-friendly interfaces and validates product quality.' },
];

export default function TeamPage() {
  const [members, setMembers] = useState(fallback);
  useEffect(() => { api.get('/public/team').then(({ data }) => { if (data.length) setMembers(data); }).catch(() => {}); }, []);

  return (
    <>
      <PageHero eyebrow="Our team" title="A multidisciplinary team working toward one clear outcome." text="Strategy, design, engineering and quality assurance work together throughout the project lifecycle." />
      <section className="section">
        <div className="container team-grid">
          {members.map((member, index) => (
            <article className="team-card" key={member.id || member.name}>
              {member.photo ? <img className="team-card__photo" src={member.photo} alt={member.name} /> : <div>{String(index + 1).padStart(2, '0')}</div>}
              <h3>{member.name}</h3><span>{member.designation}</span><p>{member.bio}</p>
              {member.skills?.length ? <div className="tech-tags">{member.skills.slice(0, 4).map((skill) => <span key={skill}>{skill}</span>)}</div> : null}
            </article>
          ))}
        </div>
      </section>
    </>
  );
}
