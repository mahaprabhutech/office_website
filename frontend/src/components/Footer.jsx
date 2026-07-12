import { Link } from 'react-router-dom';
import Logo from './Logo';

export default function Footer() {
  return (
    <footer className="site-footer">
      <div className="container footer-grid">
        <div>
          <Logo />
          <p>Secure and meaningful digital solutions for businesses, institutions and social-impact initiatives.</p>
        </div>
        <div>
          <h4>Company</h4>
          <Link to="/about">About</Link><Link to="/team">Team</Link>
          <Link to="/careers">Careers</Link><Link to="/blog">Insights</Link>
        </div>
        <div>
          <h4>Solutions</h4>
          <Link to="/services">Services</Link><Link to="/projects">Projects</Link>
          <Link to="/request-quote">Request a Quote</Link><Link to="/contact">Contact</Link>
        </div>
        <div>
          <h4>Contact</h4>
          <p>Odisha, India</p><p>info@mahaprabhutech.com</p><p>+91 80181 98730</p>
        </div>
      </div>
      <div className="container footer-bottom">
        <span>© 2026 MAHAPRABHU TECH INNOVATION PRIVATE LIMITED</span>
        <span><Link to="/privacy-policy">Privacy</Link> · <Link to="/terms-and-conditions">Terms</Link></span>
      </div>
    </footer>
  );
}
