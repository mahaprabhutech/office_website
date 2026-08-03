import { Link } from 'react-router-dom';
import Logo from './Logo';
import '../styles/spiritual-purpose.css';

export default function Footer() {
  return (
    <footer className="site-footer purpose-footer">
      <div className="container footer-grid">
        <div className="footer-brand-column">
          <Logo />

          <p>
            A spiritual software company creating secure digital solutions
            for service, animal welfare, institutions, businesses and
            social-impact initiatives.
          </p>

          <div className="footer-purpose-tags">
            <span>Spiritual Technology</span>
            <span>Animal Welfare</span>
            <span>Responsible Innovation</span>
          </div>
        </div>

        <div>
          <h4>Company</h4>

          <Link to="/about">About</Link>
          <Link to="/team">Team</Link>
          <Link to="/careers">Careers</Link>
          <Link to="/blog">Insights</Link>
        </div>

        <div>
          <h4>Solutions</h4>

          <Link to="/services">Technology Services</Link>
          <Link to="/projects">Purpose-led Projects</Link>
          <Link to="/request-quote">Request a Quote</Link>
          <Link to="/contact">Contact</Link>
        </div>

        <div>
          <h4>Contact</h4>

          <p>
            Baulanga, Kujanga Block
            <br />
            Jagatsinghpur District
            <br />
            Odisha – 754141
          </p>

          <p>
            <a href="mailto:info@mahaprabhutech.com">
              info@mahaprabhutech.com
            </a>
          </p>

          <p>
            <a href="tel:+917735776060">+91 77357 76060</a>
          </p>
        </div>
      </div>

      <div className="container footer-purpose-line">
        <span>Technology for seva, compassion and meaningful progress.</span>
      </div>

      <div className="container footer-bottom">
        <span>
          © 2026 MAHAPRABHU TECH INNOVATION PRIVATE LIMITED
        </span>

        <span>
          <Link to="/privacy-policy">Privacy</Link>
          {' · '}
          <Link to="/terms-and-conditions">Terms</Link>
        </span>
      </div>
    </footer>
  );
}
