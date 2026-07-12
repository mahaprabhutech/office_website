import { Link } from 'react-router-dom';

export default function Logo({ compact = false }) {
  return (
    <Link className={`brand-logo ${compact ? 'brand-logo--compact' : ''}`} to="/" aria-label="Mahaprabhu Tech Innovation home">
      <img
        src={compact ? '/images/brand-symbol.png' : '/images/company-logo-transparent.png'}
        alt="MAHAPRABHU TECH INNOVATION PRIVATE LIMITED"
      />
    </Link>
  );
}
