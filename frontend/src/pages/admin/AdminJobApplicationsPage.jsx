import { useEffect, useState } from 'react';
import api from '../../services/api';

const statuses = ['received', 'shortlisted', 'interview', 'selected', 'rejected'];

export default function AdminJobApplicationsPage() {
  const [items, setItems] = useState([]);
  const [filter, setFilter] = useState('');
  const [selected, setSelected] = useState(null);
  const [status, setStatus] = useState('');

  const load = async () => {
    try {
      const { data } = await api.get('/admin/job-applications', { params: filter ? { status: filter } : {} });
      setItems(data.data || data);
    } catch (error) { setStatus(error.response?.data?.message || 'Unable to load job applications.'); }
  };
  useEffect(() => { load(); /* eslint-disable-next-line react-hooks/exhaustive-deps */ }, [filter]);

  const save = async (event) => {
    event.preventDefault(); setStatus('Saving...');
    try {
      const { data } = await api.put(`/admin/job-applications/${selected.id}`, { status: selected.status, internal_notes: selected.internal_notes || null });
      setSelected(data); setStatus('Application updated successfully.'); await load();
    } catch (error) { setStatus(error.response?.data?.message || 'Unable to update application.'); }
  };

  const downloadResume = async (item) => {
    try {
      const response = await api.get(`/admin/job-applications/${item.id}/resume`, { responseType: 'blob' });
      const href = URL.createObjectURL(response.data);
      const anchor = document.createElement('a'); anchor.href = href; anchor.download = `${item.name.replaceAll(' ', '-')}-resume`; anchor.click(); URL.revokeObjectURL(href);
    } catch { setStatus('Unable to download this resume.'); }
  };

  return (
    <>
      <div className="admin-page-heading"><div><span>RECRUITMENT</span><h1>Job applications</h1><p>Review candidates, download resumes and update recruitment status.</p></div></div>
      {status && status !== 'Saving...' && <div className={`admin-alert ${status.includes('success') ? 'admin-alert--success' : ''}`}>{status}</div>}
      <section className="admin-panel-card"><div className="admin-list-toolbar"><div><strong>{items.length}</strong><span>Applications</span></div><select value={filter} onChange={(e) => setFilter(e.target.value)}><option value="">All statuses</option>{statuses.map((item) => <option key={item}>{item}</option>)}</select></div>
        <div className="admin-table-wrap"><table className="admin-table"><thead><tr><th>Candidate</th><th>Job vacancy</th><th>Experience</th><th>Status</th><th>Actions</th></tr></thead><tbody>
          {!items.length && <tr><td colSpan="5" className="admin-empty">No applications found.</td></tr>}
          {items.map((item) => <tr key={item.id}><td><strong>{item.name}</strong><small>{item.email}<br />{item.mobile}</small></td><td>{item.job?.title || 'Vacancy removed'}</td><td>{item.experience || 'Not specified'}</td><td><span className={`admin-status admin-status--${item.status}`}>{item.status}</span></td><td><div className="admin-row-actions"><button onClick={() => setSelected(item)}>Review</button><button onClick={() => downloadResume(item)}>Resume</button></div></td></tr>)}
        </tbody></table></div>
      </section>
      {selected && <div className="admin-modal-backdrop" onMouseDown={() => setSelected(null)}><form className="admin-modal" onSubmit={save} onMouseDown={(e) => e.stopPropagation()}>
        <div className="admin-form-head"><div><span>CANDIDATE #{String(selected.id).padStart(6, '0')}</span><h2>{selected.name}</h2></div><button type="button" onClick={() => setSelected(null)}>×</button></div>
        <div className="admin-lead-summary"><div><span>Job</span><strong>{selected.job?.title || '—'}</strong></div><div><span>Qualification</span><strong>{selected.qualification}</strong></div><div><span>Experience</span><strong>{selected.experience || '—'}</strong></div><div><span>Location</span><strong>{selected.location || '—'}</strong></div></div>
        <div className="admin-message-box"><span>SKILLS / COVER LETTER</span><p>{selected.skills || 'No skills summary'}<br /><br />{selected.cover_letter || 'No cover letter'}</p></div>
        <label className="admin-field">Recruitment status<select value={selected.status} onChange={(e) => setSelected({ ...selected, status: e.target.value })}>{statuses.map((item) => <option key={item}>{item}</option>)}</select></label>
        <label className="admin-field">Internal notes<textarea rows="5" value={selected.internal_notes || ''} onChange={(e) => setSelected({ ...selected, internal_notes: e.target.value })} /></label>
        <div className="admin-form-actions"><button type="button" className="button button--ghost" onClick={() => downloadResume(selected)}>Download resume</button><button className="button" disabled={status === 'Saving...'}>Save changes</button></div>
      </form></div>}
    </>
  );
}
