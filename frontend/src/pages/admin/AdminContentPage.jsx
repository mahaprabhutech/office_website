import { useEffect, useMemo, useState } from 'react';
import api from '../../services/api';

const configurations = {
  services: {
    singular: 'Service', titleField: 'title', subtitleField: 'summary',
    defaults: { title: '', summary: '', description: '', icon: '01', benefits: [], process: [], featured: false, active: true, sort_order: 0 },
    fields: [
      ['title', 'Service title', 'text', true], ['icon', 'Short icon/code', 'text'],
      ['summary', 'Short summary', 'textarea', true], ['description', 'Full description', 'textarea', true],
      ['benefits', 'Benefits (one per line)', 'list'], ['process', 'Process steps (one per line)', 'list'],
      ['sort_order', 'Display order', 'number'], ['featured', 'Featured on home page', 'checkbox'], ['active', 'Active', 'checkbox'],
    ],
  },
  projects: {
    singular: 'Project', titleField: 'title', subtitleField: 'category',
    defaults: { title: '', category: '', summary: '', description: '', features: [], technologies: [], project_status: 'In Development', website_url: '', android_url: '', ios_url: '', featured: false, active: true, sort_order: 0 },
    fields: [
      ['title', 'Project title', 'text', true], ['category', 'Category', 'text', true],
      ['summary', 'Short summary', 'textarea', true], ['description', 'Full description', 'textarea', true],
      ['features', 'Features (one per line)', 'list'], ['technologies', 'Technologies (one per line)', 'list'],
      ['project_status', 'Project status', 'select', true, ['Concept', 'In Development', 'Pilot', 'Live', 'Completed']],
      ['website_url', 'Website URL', 'url'], ['android_url', 'Android app URL', 'url'], ['ios_url', 'iOS app URL', 'url'],
      ['sort_order', 'Display order', 'number'], ['featured', 'Featured on home page', 'checkbox'], ['active', 'Active', 'checkbox'],
    ],
  },
  'team-members': {
    singular: 'Team member', titleField: 'name', subtitleField: 'designation',
    defaults: { name: '', designation: '', department: '', bio: '', skills: [], linkedin_url: '', email: '', active: true, sort_order: 0 },
    fields: [
      ['name', 'Full name', 'text', true], ['designation', 'Designation', 'text', true], ['department', 'Department', 'text'],
      ['bio', 'Professional summary', 'textarea'], ['skills', 'Skills (one per line)', 'list'],
      ['linkedin_url', 'LinkedIn URL', 'url'], ['email', 'Public email', 'email'], ['sort_order', 'Display order', 'number'], ['active', 'Active', 'checkbox'],
    ],
  },
  jobs: {
    singular: 'Job vacancy', titleField: 'title', subtitleField: 'department',
    defaults: { title: '', department: '', employment_type: 'Full Time', location: 'Odisha / Hybrid', experience: '', qualification: '', skills: [], responsibilities: [], description: '', salary_range: '', openings: 1, deadline: '', active: true },
    fields: [
      ['title', 'Job title', 'text', true], ['department', 'Department', 'text', true],
      ['employment_type', 'Employment type', 'select', true, ['Full Time', 'Part Time', 'Internship', 'Contract']], ['location', 'Location', 'text', true],
      ['experience', 'Experience', 'text'], ['qualification', 'Qualification', 'text', true],
      ['skills', 'Skills (one per line)', 'list'], ['responsibilities', 'Responsibilities (one per line)', 'list'],
      ['description', 'Job description', 'textarea', true], ['salary_range', 'Salary range', 'text'],
      ['openings', 'Number of openings', 'number'], ['deadline', 'Application deadline', 'date'], ['active', 'Active', 'checkbox'],
    ],
  },
  'blog-posts': {
    singular: 'Article', titleField: 'title', subtitleField: 'category',
    defaults: { title: '', category: 'Company News', excerpt: '', content: '', tags: [], status: 'draft', published_at: '', seo_title: '', seo_description: '' },
    fields: [
      ['title', 'Article title', 'text', true], ['category', 'Category', 'text', true],
      ['excerpt', 'Short excerpt', 'textarea', true], ['content', 'Article content', 'textarea', true],
      ['tags', 'Tags (one per line)', 'list'], ['status', 'Publishing status', 'select', true, ['draft', 'published']],
      ['published_at', 'Publish date and time', 'datetime-local'], ['seo_title', 'SEO title', 'text'], ['seo_description', 'SEO description', 'textarea'],
    ],
  },
  testimonials: {
    singular: 'Testimonial', titleField: 'name', subtitleField: 'organisation',
    defaults: { name: '', organisation: '', designation: '', review: '', rating: 5, active: true, sort_order: 0 },
    fields: [
      ['name', 'Customer name', 'text', true], ['organisation', 'Organisation', 'text'], ['designation', 'Designation', 'text'],
      ['review', 'Review', 'textarea', true], ['rating', 'Rating (1-5)', 'number'], ['sort_order', 'Display order', 'number'], ['active', 'Approved and visible', 'checkbox'],
    ],
  },
};

function normaliseForForm(item, config) {
  const value = { ...config.defaults, ...item };
  config.fields.forEach(([key, , type]) => {
    if (type === 'list' && !Array.isArray(value[key])) value[key] = value[key] ? String(value[key]).split('\n') : [];
    if (type === 'datetime-local' && value[key]) value[key] = String(value[key]).slice(0, 16);
  });
  return value;
}

export default function AdminContentPage({ type, title }) {
  const config = useMemo(() => configurations[type], [type]);
  const [items, setItems] = useState([]);
  const [form, setForm] = useState(() => ({ ...config.defaults }));
  const [editingId, setEditingId] = useState(null);
  const [showForm, setShowForm] = useState(false);
  const [search, setSearch] = useState('');
  const [status, setStatus] = useState('');
  const [loading, setLoading] = useState(true);

  const load = async () => {
    setLoading(true);
    try {
      const { data } = await api.get(`/admin/${type}`);
      setItems(data.data || data);
      setStatus('');
    } catch (error) {
      setStatus(error.response?.data?.message || `Unable to load ${title.toLowerCase()}.`);
    } finally { setLoading(false); }
  };

  useEffect(() => {
    setForm({ ...config.defaults }); setEditingId(null); setShowForm(false); load();
  // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [type]);

  const startCreate = () => { setEditingId(null); setForm({ ...config.defaults }); setShowForm(true); setStatus(''); };
  const startEdit = (item) => { setEditingId(item.id); setForm(normaliseForForm(item, config)); setShowForm(true); setStatus(''); window.scrollTo({ top: 0, behavior: 'smooth' }); };

  const submit = async (event) => {
    event.preventDefault();
    setStatus('Saving...');
    try {
      const payload = { ...form };
      config.fields.forEach(([key, , fieldType]) => {
        if (fieldType === 'list') payload[key] = Array.isArray(payload[key]) ? payload[key].filter(Boolean) : String(payload[key] || '').split('\n').map((x) => x.trim()).filter(Boolean);
        if (fieldType === 'number') payload[key] = Number(payload[key] || 0);
        if ((fieldType === 'date' || fieldType === 'datetime-local') && !payload[key]) payload[key] = null;
      });
      if (editingId) await api.put(`/admin/${type}/${editingId}`, payload);
      else await api.post(`/admin/${type}`, payload);
      setStatus(`${config.singular} saved successfully.`);
      setShowForm(false); setEditingId(null); setForm({ ...config.defaults }); await load();
    } catch (error) {
      const errors = error.response?.data?.errors;
      setStatus(errors ? Object.values(errors).flat().join(' ') : error.response?.data?.message || 'Unable to save this record.');
    }
  };

  const remove = async (item) => {
    if (!window.confirm(`Delete “${item[config.titleField]}”? This action cannot be undone.`)) return;
    try { await api.delete(`/admin/${type}/${item.id}`); await load(); }
    catch (error) { setStatus(error.response?.data?.message || 'Unable to delete this record.'); }
  };

  const visibleItems = items.filter((item) => `${item[config.titleField] || ''} ${item[config.subtitleField] || ''}`.toLowerCase().includes(search.toLowerCase()));

  const updateValue = (key, fieldType, value) => setForm((current) => ({
    ...current,
    [key]: fieldType === 'checkbox' ? value : fieldType === 'list' ? value.split('\n') : value,
  }));

  return (
    <>
      <div className="admin-page-heading">
        <div><span>CONTENT MANAGEMENT</span><h1>{title}</h1><p>Create, edit, organise and publish website content.</p></div>
        <button className="button button--small" onClick={startCreate}>+ Add {config.singular}</button>
      </div>

      {status && status !== 'Saving...' && <div className={`admin-alert ${status.includes('success') ? 'admin-alert--success' : ''}`}>{status}</div>}

      {showForm && (
        <form className="admin-form-card" onSubmit={submit}>
          <div className="admin-form-head"><div><span>{editingId ? 'EDIT RECORD' : 'NEW RECORD'}</span><h2>{editingId ? `Update ${config.singular}` : `Add ${config.singular}`}</h2></div><button type="button" onClick={() => setShowForm(false)}>×</button></div>
          <div className="admin-form-grid">
            {config.fields.map(([key, label, fieldType, required, options]) => {
              if (fieldType === 'checkbox') return (
                <label className="admin-switch-field" key={key}><input type="checkbox" checked={Boolean(form[key])} onChange={(e) => updateValue(key, fieldType, e.target.checked)} /><span /><b>{label}</b></label>
              );
              const common = { required: Boolean(required), value: fieldType === 'list' ? (form[key] || []).join('\n') : (form[key] ?? ''), onChange: (e) => updateValue(key, fieldType, e.target.value) };
              return (
                <label className={fieldType === 'textarea' || fieldType === 'list' ? 'admin-field admin-field--wide' : 'admin-field'} key={key}>{label}
                  {fieldType === 'textarea' || fieldType === 'list' ? <textarea rows={fieldType === 'list' ? 5 : 6} {...common} /> :
                    fieldType === 'select' ? <select {...common}>{options.map((option) => <option key={option} value={option}>{option}</option>)}</select> :
                    <input type={fieldType} {...common} />}
                </label>
              );
            })}
          </div>
          <div className="admin-form-actions"><button type="button" className="button button--ghost" onClick={() => setShowForm(false)}>Cancel</button><button className="button" disabled={status === 'Saving...'}>{status === 'Saving...' ? 'Saving...' : 'Save record'}</button></div>
        </form>
      )}

      <section className="admin-panel-card">
        <div className="admin-list-toolbar">
          <div><strong>{visibleItems.length}</strong><span>Total records</span></div>
          <input placeholder={`Search ${title.toLowerCase()}...`} value={search} onChange={(e) => setSearch(e.target.value)} />
        </div>
        <div className="admin-table-wrap">
          <table className="admin-table admin-table--content">
            <thead><tr><th>Content</th><th>Status</th><th>Updated</th><th>Actions</th></tr></thead>
            <tbody>
              {loading && <tr><td colSpan="4" className="admin-empty">Loading content...</td></tr>}
              {!loading && !visibleItems.length && <tr><td colSpan="4" className="admin-empty">No matching records found.</td></tr>}
              {!loading && visibleItems.map((item) => (
                <tr key={item.id}>
                  <td><strong>{item[config.titleField]}</strong><small>{item[config.subtitleField] || `Record #${item.id}`}</small></td>
                  <td><span className={`admin-status ${item.active === false || item.status === 'draft' ? 'admin-status--closed' : 'admin-status--qualified'}`}>{item.status || (item.active === false ? 'inactive' : 'active')}</span></td>
                  <td>{item.updated_at ? new Date(item.updated_at).toLocaleDateString('en-IN') : '—'}</td>
                  <td><div className="admin-row-actions"><button onClick={() => startEdit(item)}>Edit</button><button className="danger" onClick={() => remove(item)}>Delete</button></div></td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </section>
    </>
  );
}
