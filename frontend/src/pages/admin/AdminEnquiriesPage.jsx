import { useEffect, useState } from 'react';
import api from '../../services/api';

const statuses = ['new', 'contacted', 'qualified', 'converted', 'closed'];

export default function AdminEnquiriesPage() {
  const [items, setItems] = useState([]);
  const [search, setSearch] = useState('');
  const [filter, setFilter] = useState('');
  const [selected, setSelected] = useState(null);
  const [status, setStatus] = useState('');

  const load = async () => {
    try {
      const params = {}; if (search) params.search = search; if (filter) params.status = filter;
      const { data } = await api.get('/admin/enquiries', { params });
      setItems(data.data || data);
    } catch (error) { setStatus(error.response?.data?.message || 'Unable to load enquiries.'); }
  };

  useEffect(() => { load(); /* eslint-disable-next-line react-hooks/exhaustive-deps */ }, [filter]);

  const update = async (event) => {
    event.preventDefault(); setStatus('Saving...');
    try {
      const { data } = await api.put(`/admin/enquiries/${selected.id}`, {
        status: selected.status,
        follow_up_at: selected.follow_up_at || null,
        internal_notes: selected.internal_notes || null,
      });
      setSelected(data); setStatus('Enquiry updated successfully.'); await load();
    } catch (error) { setStatus(error.response?.data?.message || 'Unable to update enquiry.'); }
  };

  return (
    <>
      <div className="admin-page-heading"><div><span>LEAD MANAGEMENT</span><h1>Enquiries</h1><p>Review website enquiries, plan follow-ups and monitor conversion.</p></div></div>
      {status && status !== 'Saving...' && <div className={`admin-alert ${status.includes('success') ? 'admin-alert--success' : ''}`}>{status}</div>}
      <section className="admin-panel-card">
        <div className="admin-list-toolbar admin-list-toolbar--filters">
          <form onSubmit={(e) => { e.preventDefault(); load(); }}><input placeholder="Search name, email or mobile..." value={search} onChange={(e) => setSearch(e.target.value)} /><button className="button button--small">Search</button></form>
          <select value={filter} onChange={(e) => setFilter(e.target.value)}><option value="">All statuses</option>{statuses.map((item) => <option key={item}>{item}</option>)}</select>
        </div>
        <div className="admin-table-wrap"><table className="admin-table"><thead><tr><th>Customer</th><th>Requirement</th><th>Status</th><th>Follow-up</th><th>Action</th></tr></thead><tbody>
          {!items.length && <tr><td colSpan="5" className="admin-empty">No enquiries found.</td></tr>}
          {items.map((item) => <tr key={item.id}><td><strong>{item.name}</strong><small>{item.email}<br />{item.mobile}</small></td><td><strong>{item.service || 'General'}</strong><small>{item.company || 'Individual'}</small></td><td><span className={`admin-status admin-status--${item.status}`}>{item.status}</span></td><td>{item.follow_up_at ? new Date(item.follow_up_at).toLocaleString('en-IN') : 'Not scheduled'}</td><td><button className="admin-link-button" onClick={() => setSelected(item)}>Open</button></td></tr>)}
        </tbody></table></div>
      </section>

      {selected && <div className="admin-modal-backdrop" onMouseDown={() => setSelected(null)}><form className="admin-modal" onSubmit={update} onMouseDown={(e) => e.stopPropagation()}>
        <div className="admin-form-head"><div><span>ENQUIRY #{String(selected.id).padStart(6, '0')}</span><h2>{selected.name}</h2></div><button type="button" onClick={() => setSelected(null)}>×</button></div>
        <div className="admin-lead-summary"><div><span>Email</span><strong>{selected.email}</strong></div><div><span>Mobile</span><strong>{selected.mobile}</strong></div><div><span>Company</span><strong>{selected.company || '—'}</strong></div><div><span>Service</span><strong>{selected.service || 'General'}</strong></div></div>
        <div className="admin-message-box"><span>CUSTOMER MESSAGE</span><p>{selected.message}</p></div>
        <label className="admin-field">Status<select value={selected.status} onChange={(e) => setSelected({ ...selected, status: e.target.value })}>{statuses.map((item) => <option key={item}>{item}</option>)}</select></label>
        <label className="admin-field">Follow-up date and time<input type="datetime-local" value={selected.follow_up_at ? selected.follow_up_at.slice(0, 16) : ''} onChange={(e) => setSelected({ ...selected, follow_up_at: e.target.value })} /></label>
        <label className="admin-field">Internal notes<textarea rows="5" value={selected.internal_notes || ''} onChange={(e) => setSelected({ ...selected, internal_notes: e.target.value })} /></label>
        <div className="admin-form-actions"><button type="button" className="button button--ghost" onClick={() => setSelected(null)}>Close</button><button className="button" disabled={status === 'Saving...'}>Save changes</button></div>
      </form></div>}
    </>
  );
}
