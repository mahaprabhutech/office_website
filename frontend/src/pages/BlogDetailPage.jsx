import { useEffect, useState } from 'react';
import { Link, useParams } from 'react-router-dom';
import api from '../services/api';
import { fallbackPosts } from '../data/fallback';
import Loading from '../components/Loading';

export default function BlogDetailPage() {
  const { slug } = useParams();
  const [post, setPost] = useState(fallbackPosts.find((item) => item.slug === slug));
  const [loading, setLoading] = useState(!post);

  useEffect(() => {
    api.get(`/public/posts/${slug}`).then(({ data }) => setPost(data)).catch(() => {}).finally(() => setLoading(false));
  }, [slug]);

  if (loading) return <Loading />;
  if (!post) return <div className="empty-state">Article not found.</div>;

  return <>
    <section className="page-hero"><div className="container"><span className="eyebrow">{post.category}</span><h1>{post.title}</h1><p>{post.excerpt}</p></div></section>
    <section className="section"><article className="container article-content"><div className="article-meta">Published {post.published_at ? new Date(post.published_at).toLocaleDateString('en-IN', { day: '2-digit', month: 'long', year: 'numeric' }) : 'recently'}</div>{String(post.content || post.excerpt).split('\n').filter(Boolean).map((paragraph) => <p key={paragraph}>{paragraph}</p>)}<Link className="text-link" to="/blog">← Back to all articles</Link></article></section>
  </>;
}
