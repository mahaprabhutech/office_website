import { useEffect, useState } from 'react';
import api from '../../services/api';

const blank = { name: '', email: '', password: '', role: 'viewer', is_active: true };
const roles = ['super_admin', 'admin', 'editor', 'hr', 'sales', 'viewer'];

export default function AdminUsersPage() {
  const [items, setItems] = useState([]);
  const [form, setForm] = useState(blank);
  const [editingId, setEditingId] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const [status, setStatus] = useState('');

  const load = async () => {
    try { const { data } = await api.get('/admin/users'); setItems(data.data || data); }
    catch (error) { setStatus(error.response?.data?.message || 'Unable to load administrator accounts.'); }
  };
  useEffect(() => { load(); }, []);

  const submit = async (event) => {
    event.preventDefault(); setStatus('Saving...');
    try {
      if (editingId) await api.put(`/admin/users/${editingId}`, form); else await api.post('/admin/users', form);
      setShowForm(false); setEditingId(null); setForm(blank); setStatus('Administrator account saved successfully.'); await load();
    } catch (error) {
      const errors = error.response?.data?.errors;
      setStatus(errors ? Object.values(errors).flat().join(' ') : error.response?.data?.message || 'Unable to save account.');
    }
  };
  const edit = (item) => { setEditingId(item.id); setForm({ name: item.name, email: item.email, password: '', role: item.role, is_active: item.is_active }); setShowForm(true); };
  const remove = async (item) => { if (!window.confirm(`Delete ${item.name}'s account?`)) return; try { await api.delete(`/admin/users/${item.id}`); await load(); } catch (error) { setStatus(error.response?.data?.message || 'Unable to delete account.'); } };

  return (
    <>
      <div className="admin-page-heading"><div><span>ACCESS CONTROL</span><h1>Administrators and roles</h1><p>Create individual accounts and assign the correct website-management role.</p></div><button className="button button--small" onClick={() => { setEditingId(null); setForm(blank); setShowForm(true); }}>+ Add administrator</button></div>
      {status && status !== 'Saving...' && <div className={`admin-alert ${status.includes('success') ? 'admin-alert--success' : ''}`}>{status}</div>}
      {showForm && <form className="admin-form-card" onSubmit={submit}><div className="admin-form-head"><div><span>{editingId ? 'EDIT ACCOUNT' : 'NEW ACCOUNT'}</span><h2>{editingId ? 'Update administrator' : 'Add administrator'}</h2></div><button type="button" onClick={() => setShowForm(false)}>×</button></div><div className="admin-form-grid">
        <label className="admin-field">Full name<input required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} /></label>
        <label className="admin-field">Email address<input type="email" required value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} /></label>
        <label className="admin-field">{editingId ? 'New password (leave blank to keep current)' : 'Password'}<input type="password" required={!editingId} minLength="8" value={form.password} onChange={(e) => setForm({ ...form, password: e.target.value })} /></label>
        <label className="admin-field">Role<select value={form.role} onChange={(e) => setForm({ ...form, role: e.target.value })}>{roles.map((item) => <option key={item} value={item}>{item.replace('_', ' ')}</option>)}</select></label>
        <label className="admin-switch-field"><input type="checkbox" checked={form.is_active} onChange={(e) => setForm({ ...form, is_active: e.target.checked })} /><span /><b>Account active</b></label>
      </div><div className="admin-form-actions"><button type="button" className="button button--ghost" onClick={() => setShowForm(false)}>Cancel</button><button className="button" disabled={status === 'Saving...'}>Save account</button></div></form>}
      <section className="admin-panel-card"><div className="admin-table-wrap"><table className="admin-table"><thead><tr><th>Administrator</th><th>Role</th><th>Status</th><th>Created</th><th>Actions</th></tr></thead><tbody>
        {!items.length && <tr><td colSpan="5" className="admin-empty">No administrator accounts found.</td></tr>}
        {items.map((item) => <tr key={item.id}><td><strong>{item.name}</strong><small>{item.email}</small></td><td>{item.role.replace('_', ' ')}</td><td><span className={`admin-status ${item.is_active ? 'admin-status--qualified' : 'admin-status--closed'}`}>{item.is_active ? 'active' : 'inactive'}</span></td><td>{new Date(item.created_at).toLocaleDateString('en-IN')}</td><td><div className="admin-row-actions"><button onClick={() => edit(item)}>Edit</button><button className="danger" onClick={() => remove(item)}>Delete</button></div></td></tr>)}
      </tbody></table></div></section>
    </>
  );
}
