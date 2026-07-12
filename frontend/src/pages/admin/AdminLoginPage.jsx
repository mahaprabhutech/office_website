import { useState } from 'react';
import { Navigate, useLocation, useNavigate } from 'react-router-dom';
import Logo from '../../components/Logo';
import { useAuth } from '../../context/AuthContext';

export default function AdminLoginPage() {
  const { login, isAuthenticated } = useAuth();
  const navigate = useNavigate();
  const location = useLocation();
  const [form, setForm] = useState({ email: 'admin@mahaprabhutech.com', password: 'ChangeMe@123' });
  const [status, setStatus] = useState('');

  if (isAuthenticated) return <Navigate to="/admin/dashboard" replace />;

  const submit = async (event) => {
    event.preventDefault();
    setStatus('Signing in...');
    try {
      await login(form.email, form.password);
      navigate(location.state?.from?.pathname || '/admin/dashboard', { replace: true });
    } catch (error) {
      setStatus(error.response?.data?.message || 'Login failed. Confirm the Laravel API is running and the credentials are correct.');
    }
  };

  return (
    <main className="admin-login-page">
      <section className="admin-login-brand">
        <Logo />
        <div>
          <span className="eyebrow">Secure administration</span>
          <h1>Manage your corporate website from one clear dashboard.</h1>
          <p>Publish services, showcase projects, review enquiries, update careers and control public company information.</p>
        </div>
        <ul>
          <li>Laravel API with Sanctum authentication</li>
          <li>Role-ready administrator access</li>
          <li>Red, black and white company branding</li>
        </ul>
      </section>
      <section className="admin-login-panel">
        <form className="admin-login-card" onSubmit={submit}>
          <img src="/images/brand-symbol.png" alt="Mahaprabhu Tech symbol" />
          <span>ADMIN PANEL</span>
          <h2>Welcome back</h2>
          <p>Sign in with your authorised administrator account.</p>
          <label>Email address
            <input type="email" required autoComplete="username" value={form.email} onChange={(e) => setForm({ ...form, email: e.target.value })} />
          </label>
          <label>Password
            <input type="password" required autoComplete="current-password" value={form.password} onChange={(e) => setForm({ ...form, password: e.target.value })} />
          </label>
          <button className="button" type="submit" disabled={status === 'Signing in...'}>Sign in securely</button>
          {status && <div className="admin-login-status">{status}</div>}
          <small>Default development credentials are prefilled. Change the password immediately after setup.</small>
        </form>
      </section>
    </main>
  );
}
