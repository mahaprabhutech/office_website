import { Link } from 'react-router-dom';

export default function NotFoundPage() {
  return (
    <div className="not-found">
      <img src="/images/brand-symbol.png" alt="" />
      <h1>404</h1><p>The requested page could not be found.</p>
      <Link className="button" to="/">Return Home</Link>
    </div>
  );
}
