import { useState } from 'react';
import { NavLink } from 'react-router-dom';
import Logo from './Logo';

const links = [
  ['/', 'Home'], ['/about', 'About'], ['/services', 'Services'], ['/projects', 'Projects'],
  ['/team', 'Team'], ['/careers', 'Careers'], ['/blog', 'Insights'], ['/contact', 'Contact'],
];

export default function Header() {
  const [open, setOpen] = useState(false);

  return (
    <header className="site-header">
      <div className="container nav-shell">
        <Logo />
        <button className="menu-button" aria-label="Toggle navigation" onClick={() => setOpen(!open)}>
          <span /><span /><span />
        </button>
        <nav className={open ? 'main-nav main-nav--open' : 'main-nav'}>
          {links.map(([to, label]) => (
            <NavLink key={to} to={to} end={to === '/'} onClick={() => setOpen(false)}>{label}</NavLink>
          ))}
          <NavLink className="button button--small" to="/request-quote" onClick={() => setOpen(false)}>
            Request a Quote
          </NavLink>
        </nav>
      </div>
    </header>
  );
}
