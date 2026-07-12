import { useEffect, useState } from 'react';
import api from '../../services/api';

const statuses = ['received', 'reviewing', 'proposal_sent', 'accepted', 'rejected', 'closed'];

export default function AdminQuotationsPage() {
  const [items, setItems] = useState([]);
  const [filter, setFilter] = useState('');
  const [selected, setSelected] = useState(null);
  const [status, setStatus] = useState('');

  const load = async () => {
    try {
      const { data } = await api.get('/admin/quotations', { params: filter ? { status: filter } : {} });
      setItems(data.data || data);
    } catch (error) { setStatus(error.response?.data?.message || 'Unable to load quotations.'); }
  };

  useEffect(() => { load(); /* eslint-disable-next-line react-hooks/exhaustive-deps */ }, [filter]);

  const save = async (event) => {
    event.preventDefault(); setStatus('Saving...');
    try {
      const { data } = await api.put(`/admin/quotations/${selected.id}`, {
        status: selected.status,
        estimated_amount: selected.estimated_amount || null,
        proposal: selected.proposal || null,
        internal_notes: selected.internal_notes || null,
      });
      setSelected(data); setStatus('Quotation updated successfully.'); await load();
    } catch (error) { setStatus(error.response?.data?.message || 'Unable to update quotation.'); }
  };

  return (
    <>
      <div className="admin-page-heading"><div><span>BUSINESS OPPORTUNITIES</span><h1>Quotation requests</h1><p>Review scope, record estimates and track proposal decisions.</p></div></div>
      {status && status !== 'Saving...' && <div className={`admin-alert ${status.includes('success') ? 'admin-alert--success' : ''}`}>{status}</div>}
      <section className="admin-panel-card">
        <div className="admin-list-toolbar"><div><strong>{items.length}</strong><span>Current records</span></div><select value={filter} onChange={(e) => setFilter(e.target.value)}><option value="">All statuses</option>{statuses.map((item) => <option key={item}>{item}</option>)}</select></div>
        <div className="admin-table-wrap"><table className="admin-table"><thead><tr><th>Customer</th><th>Project</th><th>Budget</th><th>Status</th><th>Action</th></tr></thead><tbody>
          {!items.length && <tr><td colSpan="5" className="admin-empty">No quotation requests found.</td></tr>}
          {items.map((item) => <tr key={item.id}><td><strong>{item.name}</strong><small>{item.company || 'Individual'}<br />{item.email}</small></td><td><strong>{item.project_type}</strong><small>{(item.platforms || []).join(', ') || 'Platform not specified'}</small></td><td>{item.budget || 'Not specified'}</td><td><span className={`admin-status admin-status--${item.status}`}>{item.status}</span></td><td><button className="admin-link-button" onClick={() => setSelected(item)}>Review</button></td></tr>)}
        </tbody></table></div>
      </section>

      {selected && <div className="admin-modal-backdrop" onMouseDown={() => setSelected(null)}><form className="admin-modal" onSubmit={save} onMouseDown={(e) => e.stopPropagation()}>
        <div className="admin-form-head"><div><span>QUOTATION #{String(selected.id).padStart(6, '0')}</span><h2>{selected.project_type}</h2></div><button type="button" onClick={() => setSelected(null)}>×</button></div>
        <div className="admin-lead-summary"><div><span>Customer</span><strong>{selected.name}</strong></div><div><span>Contact</span><strong>{selected.mobile}</strong></div><div><span>Budget</span><strong>{selected.budget || '—'}</strong></div><div><span>Expected date</span><strong>{selected.expected_date || '—'}</strong></div></div>
        <div className="admin-message-box"><span>PROJECT REQUIREMENT</span><p>{selected.description}</p></div>
        <label className="admin-field">Status<select value={selected.status} onChange={(e) => setSelected({ ...selected, status: e.target.value })}>{statuses.map((item) => <option key={item}>{item}</option>)}</select></label>
        <label className="admin-field">Estimated amount (₹)<input type="number" min="0" step="0.01" value={selected.estimated_amount || ''} onChange={(e) => setSelected({ ...selected, estimated_amount: e.target.value })} /></label>
        <label className="admin-field">Proposal file path or URL<input value={selected.proposal || ''} onChange={(e) => setSelected({ ...selected, proposal: e.target.value })} /></label>
        <label className="admin-field">Internal notes<textarea rows="5" value={selected.internal_notes || ''} onChange={(e) => setSelected({ ...selected, internal_notes: e.target.value })} /></label>
        <div className="admin-form-actions"><button type="button" className="button button--ghost" onClick={() => setSelected(null)}>Close</button><button className="button" disabled={status === 'Saving...'}>Save changes</button></div>
      </form></div>}
    </>
  );
}
