import { useEffect, useState } from 'react';
import { Link } from 'react-router-dom';
import api from '../services/api';
import { fallbackPosts } from '../data/fallback';
import PageHero from '../components/PageHero';

export default function BlogPage() {
  const [posts, setPosts] = useState(fallbackPosts);
  useEffect(() => { api.get('/public/posts').then((r) => setPosts(r.data.data || r.data)).catch(() => {}); }, []);

  return (
    <>
      <PageHero eyebrow="Insights and updates" title="Ideas, company news and practical technology guidance." text="Read about product planning, software development and digital innovation." />
      <section className="section section--soft">
        <div className="container blog-grid">
          {posts.map((post) => (
            <article className="blog-card" key={post.id}>
              <span>{post.category}</span><h3>{post.title}</h3><p>{post.excerpt}</p>
              <small>{post.published_at ? new Date(post.published_at).toLocaleDateString('en-IN') : ''}</small><Link className="text-link" to={`/blog/${post.slug}`}>Read article →</Link>
            </article>
          ))}
        </div>
      </section>
    </>
  );
}
