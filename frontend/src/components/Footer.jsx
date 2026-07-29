import { Link } from "react-router-dom";
import Logo from "./Logo";

export default function Footer() {
  return (
    <footer className="site-footer">
      <div className="container footer-grid">
        {/* Company Information */}
        <div>
          <Logo />

          <p>
            Secure and meaningful digital solutions for businesses,
            institutions and social-impact initiatives.
          </p>
        </div>

        {/* Company Links */}
        <div>
          <h4>Company</h4>

          <Link to="/about">About</Link>
          <Link to="/team">Team</Link>
          <Link to="/careers">Careers</Link>
          <Link to="/blog">Insights</Link>
        </div>

        {/* Solution Links */}
        <div>
          <h4>Solutions</h4>

          <Link to="/services">Services</Link>
          <Link to="/projects">Projects</Link>
          <Link to="/request-quote">Request a Quote</Link>
          <Link to="/contact">Contact</Link>
        </div>

        {/* Contact Details */}
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
            <a href="tel:+917735776060">
              +91 77357 76060
            </a>
          </p>
        </div>
      </div>

      {/* Footer Bottom */}
      <div className="container footer-bottom">
        <span>
          © 2026 MAHAPRABHU TECH INNOVATION PRIVATE LIMITED
        </span>

        <span>
          <Link to="/privacy-policy">Privacy</Link>
          {" · "}
          <Link to="/terms-and-conditions">Terms</Link>
        </span>
      </div>
    </footer>
  );
}