import PageHero from '../components/PageHero';
import SectionTitle from '../components/SectionTitle';

export default function AboutPage() {
  return (
    <>
      <PageHero eyebrow="About our company" title="Innovation grounded in responsibility and practical execution." text="MAHAPRABHU TECH INNOVATION PRIVATE LIMITED develops digital products for businesses, institutions and social-impact initiatives." />
      <section className="section">
        <div className="container split-content">
          <div>
            <SectionTitle eyebrow="Who we are" title="A technology company focused on useful outcomes." />
            <p>We combine business understanding, structured documentation, user-focused design and secure software engineering.</p>
            <p>Our work includes corporate websites, mobile applications, administration panels, APIs, cloud deployment and technology consulting.</p>
          </div>
          <div className="brand-panel">
            <img src="/images/brand-symbol.png" alt="Company brand symbol" />
            <strong>Think clearly.<br />Build responsibly.<br /><em>Innovate meaningfully.</em></strong>
          </div>
        </div>
      </section>
      <section className="section section--soft">
        <div className="container value-grid">
          <article><span>01</span><h3>Vision</h3><p>Accessible and reliable technology that improves business and community services.</p></article>
          <article><span>02</span><h3>Mission</h3><p>Secure, documented and user-friendly solutions through a transparent process.</p></article>
          <article><span>03</span><h3>Values</h3><p>Innovation, integrity, quality, transparency and social responsibility.</p></article>
        </div>
      </section>
    </>
  );
}
