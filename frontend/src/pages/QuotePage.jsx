import { useState } from 'react';
import api from '../services/api';
import PageHero from '../components/PageHero';

const initial = {
  name: '', company: '', email: '', mobile: '', project_type: '',
  platforms: [], description: '', budget: '', expected_date: '', contact_method: 'Email',
};

export default function QuotePage() {
  const [form, setForm] = useState(initial);
  const [message, setMessage] = useState('');

  const toggle = (platform) => setForm({
    ...form,
    platforms: form.platforms.includes(platform)
      ? form.platforms.filter((item) => item !== platform)
      : [...form.platforms, platform],
  });

  const submit = async (event) => {
    event.preventDefault();
    setMessage('Submitting...');
    try {
      const { data } = await api.post('/quotations', form);
      setMessage(`${data.message} Reference: ${data.reference}`);
      setForm(initial);
    } catch (error) {
      setMessage(error.response?.data?.message || 'Unable to submit the quotation request.');
    }
  };

  return (
    <>
      <PageHero eyebrow="Project quotation" title="Share the scope, platform and expected timeline." text="This detailed form helps us prepare a more accurate discussion and initial estimate." />
      <section className="section">
        <div className="narrow">
          <form className="form-card form-card--large" onSubmit={submit}>
            <div className="form-row">
              <label>Full name<input required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} /></label>
              <label>Company<input value={form.company} onChange={(e) => setForm({ ...form, company: e.target.value })} /></label>
            </div>
            <div className="form-row">
              <label>Email<input type="email" required value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} /></label>
              <label>Mobile<input required value={form.mobile} onChange={(e) => setForm({ ...form, mobile: e.target.value })} /></label>
            </div>
            <label>Project type
              <select required value={form.project_type} onChange={(e) => setForm({ ...form, project_type: e.target.value })}>
                <option value="">Select project type</option>
                <option>Corporate Website</option><option>Mobile Application</option>
                <option>Web Application / Portal</option><option>Custom Business Software</option>
                <option>Technology Consulting</option>
              </select>
            </label>
            <fieldset>
              <legend>Required platforms</legend>
              <div className="choice-grid">
                {['Web','Android','iOS','Admin Panel','API'].map((item) => (
                  <label key={item}><input type="checkbox" checked={form.platforms.includes(item)} onChange={() => toggle(item)} />{item}</label>
                ))}
              </div>
            </fieldset>
            <label>Project description<textarea required rows="8" value={form.description} onChange={(e) => setForm({ ...form, description: e.target.value })} /></label>
            <div className="form-row">
              <label>Budget range
                <select value={form.budget} onChange={(e) => setForm({ ...form, budget: e.target.value })}>
                  <option value="">Select range</option><option>Below ₹1 lakh</option><option>₹1–3 lakh</option>
                  <option>₹3–7 lakh</option><option>₹7–15 lakh</option><option>Above ₹15 lakh</option>
                </select>
              </label>
              <label>Expected date<input type="date" value={form.expected_date} onChange={(e) => setForm({ ...form, expected_date: e.target.value })} /></label>
            </div>
            <button className="button">Submit Quotation Request</button>
            {message && <p className="form-status">{message}</p>}
          </form>
        </div>
      </section>
    </>
  );
}
