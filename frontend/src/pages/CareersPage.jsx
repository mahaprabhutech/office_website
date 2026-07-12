import { useEffect, useState } from 'react';
import api from '../services/api';
import PageHero from '../components/PageHero';

const fallback = [{
  id: 1,
  title: 'React / React Native Developer',
  department: 'Engineering',
  employment_type: 'Full Time',
  location: 'Odisha / Hybrid',
  description: 'Build responsive React interfaces and mobile application features.',
}];

const initialApplication = { name: '', email: '', mobile: '', location: '', qualification: '', experience: '', skills: '', portfolio_url: '', cover_letter: '', resume: null };

export default function CareersPage() {
  const [jobs, setJobs] = useState(fallback);
  const [selected, setSelected] = useState(null);
  const [form, setForm] = useState(initialApplication);
  const [status, setStatus] = useState('');
  useEffect(() => { api.get('/public/jobs').then((r) => setJobs(r.data)).catch(() => {}); }, []);

  const apply = async (event) => {
    event.preventDefault();
    if (!selected?.id || !form.resume) { setStatus('Please select a resume file.'); return; }
    setStatus('Submitting...');
    const payload = new FormData();
    Object.entries(form).forEach(([key, value]) => { if (value !== '' && value !== null) payload.append(key, value); });
    try {
      const { data } = await api.post(`/jobs/${selected.id}/apply`, payload, { headers: { 'Content-Type': 'multipart/form-data' } });
      setStatus(data.message); setForm(initialApplication);
    } catch (error) {
      const errors = error.response?.data?.errors;
      setStatus(errors ? Object.values(errors).flat().join(' ') : error.response?.data?.message || 'Unable to submit the application.');
    }
  };

  return (
    <>
      <PageHero eyebrow="Careers" title="Build meaningful digital products with us." text="We value learning, ownership, clear communication and responsible engineering." />
      <section className="section">
        <div className="container jobs-list">
          {jobs.map((job) => (
            <article key={job.id}>
              <div><span>{job.department}</span><h3>{job.title}</h3><p>{job.description}</p></div>
              <div><b>{job.employment_type}</b><span>{job.location}</span><button className="button button--small" onClick={() => { setSelected(job); setForm(initialApplication); setStatus(''); }}>Apply</button></div>
            </article>
          ))}
        </div>
      </section>

      {selected && <div className="career-modal-backdrop" onMouseDown={() => setSelected(null)}><form className="career-modal" onSubmit={apply} onMouseDown={(event) => event.stopPropagation()}>
        <div className="career-modal__head"><div><span>{selected.department}</span><h2>Apply for {selected.title}</h2><p>{selected.location} · {selected.employment_type}</p></div><button type="button" onClick={() => setSelected(null)}>×</button></div>
        <div className="form-row">
          <label>Full name<input required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} /></label>
          <label>Email<input required type="email" value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} /></label>
        </div>
        <div className="form-row">
          <label>Mobile<input required value={form.mobile} onChange={(e) => setForm({ ...form, mobile: e.target.value })} /></label>
          <label>Current location<input value={form.location} onChange={(e) => setForm({ ...form, location: e.target.value })} /></label>
        </div>
        <div className="form-row">
          <label>Qualification<input required value={form.qualification} onChange={(e) => setForm({ ...form, qualification: e.target.value })} /></label>
          <label>Experience<input value={form.experience} onChange={(e) => setForm({ ...form, experience: e.target.value })} /></label>
        </div>
        <label>Skills<textarea rows="3" value={form.skills} onChange={(e) => setForm({ ...form, skills: e.target.value })} /></label>
        <label>Portfolio or LinkedIn URL<input type="url" value={form.portfolio_url} onChange={(e) => setForm({ ...form, portfolio_url: e.target.value })} /></label>
        <label>Cover letter<textarea rows="4" value={form.cover_letter} onChange={(e) => setForm({ ...form, cover_letter: e.target.value })} /></label>
        <label>Resume (PDF/DOC/DOCX, maximum 5 MB)<input required type="file" accept=".pdf,.doc,.docx" onChange={(e) => setForm({ ...form, resume: e.target.files?.[0] || null })} /></label>
        <div className="career-modal__actions"><button type="button" className="button button--ghost" onClick={() => setSelected(null)}>Cancel</button><button className="button" disabled={status === 'Submitting...'}>{status === 'Submitting...' ? 'Submitting...' : 'Submit application'}</button></div>
        {status && status !== 'Submitting...' && <p className="form-status">{status}</p>}
      </form></div>}
    </>
  );
}
