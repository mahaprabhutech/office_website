export default function Loading({ label = 'Loading content...' }) {
  return <div className="loading"><span className="spinner" />{label}</div>;
}
