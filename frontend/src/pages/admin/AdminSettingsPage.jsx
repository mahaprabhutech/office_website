import { useEffect, useState } from 'react';
import api from '../../services/api';

const defaults = {
  hero_title: 'Technology that creates meaningful progress.',
  hero_subtitle: 'We develop secure websites, mobile applications and digital platforms for businesses, institutions and social-impact initiatives.',
  company_email: 'info@mahaprabhutech.com',
  support_email: 'support@mahaprabhutech.com',
  company_phone: '+91 80181 98730',
  company_location: 'Odisha, India',
  projects_count: '10+',
  solutions_count: '6+',
  linkedin_url: '', facebook_url: '', instagram_url: '', youtube_url: '',
};

export default function AdminSettingsPage() {
  const [form, setForm] = useState(defaults);
  const [status, setStatus] = useState('');

  useEffect(() => {
    api.get('/admin/settings').then(({ data }) => {
      const flattened = {};
      Object.values(data).flat().forEach((item) => { flattened[item.key] = item.value ?? ''; });
      setForm((current) => ({ ...current, ...flattened }));
    }).catch((error) => setStatus(error.response?.data?.message || 'Unable to load settings.'));
  }, []);

  const submit = async (event) => {
    event.preventDefault(); setStatus('Saving...');
    try { const { data } = await api.put('/admin/settings', { settings: form }); setStatus(data.message); }
    catch (error) { setStatus(error.response?.data?.message || 'Unable to update settings.'); }
  };

  const field = (key, label, type = 'text') => <label className={type === 'textarea' ? 'admin-field admin-field--wide' : 'admin-field'}>{label}{type === 'textarea' ? <textarea rows="4" value={form[key]} onChange={(e) => setForm({ ...form, [key]: e.target.value })} /> : <input type={type} value={form[key]} onChange={(e) => setForm({ ...form, [key]: e.target.value })} />}</label>;

  return (
    <>
      <div className="admin-page-heading"><div><span>SYSTEM CONFIGURATION</span><h1>Website settings</h1><p>Control public company details, home-page content and social links.</p></div></div>
      {status && status !== 'Saving...' && <div className={`admin-alert ${status.includes('success') ? 'admin-alert--success' : ''}`}>{status}</div>}
      <form className="admin-settings-stack" onSubmit={submit}>
        <section className="admin-form-card"><div className="admin-section-heading"><span>01</span><div><h2>Home-page hero</h2><p>Main message displayed at the top of the website.</p></div></div><div className="admin-form-grid">{field('hero_title', 'Hero title')}{field('hero_subtitle', 'Hero description', 'textarea')}{field('projects_count', 'Project count')}{field('solutions_count', 'Solution count')}</div></section>
        <section className="admin-form-card"><div className="admin-section-heading"><span>02</span><div><h2>Company contact</h2><p>Official information displayed on public pages and footer.</p></div></div><div className="admin-form-grid">{field('company_email', 'General email', 'email')}{field('support_email', 'Support email', 'email')}{field('company_phone', 'Phone number')}{field('company_location', 'Office location')}</div></section>
        <section className="admin-form-card"><div className="admin-section-heading"><span>03</span><div><h2>Social-media links</h2><p>Leave an unused platform blank.</p></div></div><div className="admin-form-grid">{field('linkedin_url', 'LinkedIn URL', 'url')}{field('facebook_url', 'Facebook URL', 'url')}{field('instagram_url', 'Instagram URL', 'url')}{field('youtube_url', 'YouTube URL', 'url')}</div></section>
        <div className="admin-sticky-save"><span>Changes update the public website after saving.</span><button className="button" disabled={status === 'Saving...'}>{status === 'Saving...' ? 'Saving...' : 'Save all settings'}</button></div>
      </form>
    </>
  );
}
