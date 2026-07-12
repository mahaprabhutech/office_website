import { useState } from 'react';
import api from '../services/api';
import PageHero from '../components/PageHero';

const initial = { name: '', email: '', mobile: '', company: '', service: '', budget_range: '', message: '' };

export default function ContactPage() {
  const [form, setForm] = useState(initial);
  const [status, setStatus] = useState('');

  const submit = async (event) => {
    event.preventDefault();
    setStatus('sending');
    try {
      const { data } = await api.post('/contact', form);
      setStatus(data.message);
      setForm(initial);
    } catch (error) {
      setStatus(error.response?.data?.message || 'Unable to submit. Check the backend connection and form fields.');
    }
  };

  return (
    <>
      <PageHero eyebrow="Contact us" title="Tell us what you want to build or improve." text="Share your requirement and our team will contact you to understand the next practical step." />
      <section className="section">
        <div className="container contact-grid">
          <div className="contact-info">
            <h2>Company contact</h2>
            <div><span>Email</span><strong>info@mahaprabhutech.com</strong></div>
            <div><span>Phone</span><strong>+91 80181 98730</strong></div>
            <div><span>Location</span><strong>Odisha, India</strong></div>
            <p>For detailed project requirements, use the Request a Quote form.</p>
          </div>
          <form className="form-card" onSubmit={submit}>
            <div className="form-row">
              <label>Full name<input required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} /></label>
              <label>Email<input type="email" required value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} /></label>
            </div>
            <div className="form-row">
              <label>Mobile<input required value={form.mobile} onChange={(e) => setForm({ ...form, mobile: e.target.value })} /></label>
              <label>Company<input value={form.company} onChange={(e) => setForm({ ...form, company: e.target.value })} /></label>
            </div>
            <label>Service required
              <select value={form.service} onChange={(e) => setForm({ ...form, service: e.target.value })}>
                <option value="">Select a service</option>
                <option>Website Development</option><option>Mobile Application</option>
                <option>Custom Software</option><option>Technology Consulting</option>
              </select>
            </label>
            <label>Message<textarea required rows="6" value={form.message} onChange={(e) => setForm({ ...form, message: e.target.value })} /></label>
            <button className="button" disabled={status === 'sending'}>{status === 'sending' ? 'Submitting...' : 'Send Enquiry'}</button>
            {status && status !== 'sending' && <p className="form-status">{status}</p>}
          </form>
        </div>
      </section>
    </>
  );
}
