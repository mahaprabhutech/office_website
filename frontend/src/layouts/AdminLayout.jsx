import { NavLink, Outlet } from 'react-router-dom';
import Logo from '../components/Logo';
import { useAuth } from '../context/AuthContext';

const menu = [
  ['dashboard','Dashboard','all'], ['services','Services','content'], ['projects','Projects','content'],
  ['team','Team','content'], ['jobs','Careers','hr'], ['blog','Blog & News','content'],
  ['testimonials','Testimonials','content'], ['enquiries','Enquiries','sales'], ['quotations','Quotations','sales'],
  ['job-applications','Applications','hr'], ['users','Users & Roles','settings'], ['settings','Settings','settings'],
];

const roleModules = {
  super_admin: ['all','content','hr','sales','settings'],
  admin: ['all','content','hr','sales','settings'],
  editor: ['all','content'],
  hr: ['all','hr'],
  sales: ['all','sales'],
  viewer: ['all','content','hr','sales'],
};

export default function AdminLayout() {
  const { user, logout } = useAuth();

  return (
    <div className="admin-shell">
      <aside className="admin-sidebar">
        <Logo compact />
        <div className="admin-company">Mahaprabhu Tech<br /><span>Administration</span></div>
        <nav>{menu.filter(([, , module]) => (roleModules[user?.role] || ['all']).includes(module)).map(([to,label]) => <NavLink key={to} to={to}>{label}</NavLink>)}</nav>
        <button className="admin-logout" onClick={logout}>Sign out</button>
      </aside>
      <section className="admin-main">
        <header className="admin-topbar">
          <div><strong>Corporate Website Admin</strong><small>Manage public content and enquiries</small></div>
          <div className="admin-user"><span>{user?.name}</span><b>{user?.name?.slice(0,1)}</b></div>
        </header>
        <div className="admin-content"><Outlet /></div>
      </section>
    </div>
  );
}
