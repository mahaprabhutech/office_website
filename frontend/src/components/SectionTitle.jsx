export default function SectionTitle({ eyebrow, title, text, align = 'left' }) {
  return (
    <div className={`section-title section-title--${align}`}>
      <span className="eyebrow">{eyebrow}</span>
      <h2>{title}</h2>
      {text && <p>{text}</p>}
    </div>
  );
}
