import { useEffect, useState } from 'react';
import api from '../../services/api';

const metricLabels = {
  services: ['Services', 'SV'],
  projects: ['Projects', 'PR'],
  new_enquiries: ['New enquiries', 'EN'],
  quotations: ['Quotation requests', 'QT'],
  job_applications: ['Job applications', 'JB'],
  published_posts: ['Published posts', 'BL'],
};

export default function AdminDashboardPage() {
  const [data, setData] = useState({ metrics: {}, recent_enquiries: [], recent_quotations: [] });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState('');

  useEffect(() => {
    api.get('/admin/dashboard')
      .then((response) => setData(response.data))
      .catch((requestError) => setError(requestError.response?.data?.message || 'Unable to load dashboard data.'))
      .finally(() => setLoading(false));
  }, []);

  return (
    <>
      <div className="admin-page-heading">
        <div><span>OVERVIEW</span><h1>Dashboard</h1><p>Monitor content, enquiries and business opportunities.</p></div>
        <div className="admin-date">{new Date().toLocaleDateString('en-IN', { day: '2-digit', month: 'long', year: 'numeric' })}</div>
      </div>

      {error && <div className="admin-alert admin-alert--error">{error}</div>}
      <div className="metric-grid">
        {Object.entries(metricLabels).map(([key, [label, icon]]) => (
          <article className="metric-card" key={key}>
            <div className="metric-card__icon">{icon}</div>
            <div><strong>{loading ? '—' : data.metrics?.[key] ?? 0}</strong><span>{label}</span></div>
          </article>
        ))}
      </div>

      <div className="admin-dashboard-grid">
        <section className="admin-panel-card">
          <div className="admin-panel-card__head"><div><span>LEADS</span><h2>Recent enquiries</h2></div><a href="/admin/enquiries">View all</a></div>
          <div className="admin-table-wrap">
            <table className="admin-table">
              <thead><tr><th>Name</th><th>Service</th><th>Status</th><th>Received</th></tr></thead>
              <tbody>
                {!data.recent_enquiries.length && <tr><td colSpan="4" className="admin-empty">No enquiries available.</td></tr>}
                {data.recent_enquiries.map((item) => (
                  <tr key={item.id}>
                    <td><strong>{item.name}</strong><small>{item.email}</small></td>
                    <td>{item.service || 'General enquiry'}</td>
                    <td><span className={`admin-status admin-status--${item.status}`}>{item.status}</span></td>
                    <td>{new Date(item.created_at).toLocaleDateString('en-IN')}</td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </section>

        <section className="admin-panel-card">
          <div className="admin-panel-card__head"><div><span>OPPORTUNITIES</span><h2>Recent quotations</h2></div></div>
          <div className="admin-activity-list">
            {!data.recent_quotations.length && <div className="admin-empty">No quotation requests available.</div>}
            {data.recent_quotations.map((item) => (
              <article key={item.id}>
                <div className="admin-activity-icon">Q</div>
                <div><strong>{item.project_type}</strong><span>{item.name} · {item.company || 'Individual'}</span></div>
                <span className={`admin-status admin-status--${item.status}`}>{item.status}</span>
              </article>
            ))}
          </div>
        </section>
      </div>

      <section className="admin-quick-section">
        <div className="admin-panel-card__head"><div><span>SHORTCUTS</span><h2>Quick content actions</h2></div></div>
        <div className="admin-quick-grid">
          <a href="/admin/services"><b>01</b><strong>Manage services</strong><span>Update service pages and benefits.</span></a>
          <a href="/admin/projects"><b>02</b><strong>Showcase a project</strong><span>Add projects, links and technologies.</span></a>
          <a href="/admin/blog"><b>03</b><strong>Publish an article</strong><span>Create company news and insights.</span></a>
          <a href="/admin/settings"><b>04</b><strong>Website settings</strong><span>Update public contact and hero content.</span></a>
        </div>
      </section>
    </>
  );
}
