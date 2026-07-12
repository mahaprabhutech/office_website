import { Navigate, Route, Routes } from 'react-router-dom';
import PublicLayout from './layouts/PublicLayout';
import AdminLayout from './layouts/AdminLayout';
import ProtectedRoute from './components/ProtectedRoute';
import HomePage from './pages/HomePage';
import AboutPage from './pages/AboutPage';
import ServicesPage from './pages/ServicesPage';
import ServiceDetailPage from './pages/ServiceDetailPage';
import ProjectsPage from './pages/ProjectsPage';
import ProjectDetailPage from './pages/ProjectDetailPage';
import TeamPage from './pages/TeamPage';
import CareersPage from './pages/CareersPage';
import BlogPage from './pages/BlogPage';
import BlogDetailPage from './pages/BlogDetailPage';
import LegalPage from './pages/LegalPage';
import ContactPage from './pages/ContactPage';
import QuotePage from './pages/QuotePage';
import NotFoundPage from './pages/NotFoundPage';
import AdminLoginPage from './pages/admin/AdminLoginPage';
import AdminDashboardPage from './pages/admin/AdminDashboardPage';
import AdminContentPage from './pages/admin/AdminContentPage';
import AdminEnquiriesPage from './pages/admin/AdminEnquiriesPage';
import AdminQuotationsPage from './pages/admin/AdminQuotationsPage';
import AdminJobApplicationsPage from './pages/admin/AdminJobApplicationsPage';
import AdminUsersPage from './pages/admin/AdminUsersPage';
import AdminSettingsPage from './pages/admin/AdminSettingsPage';

export default function App() {
  return (
    <Routes>
      <Route element={<PublicLayout />}>
        <Route index element={<HomePage />} />
        <Route path="about" element={<AboutPage />} />
        <Route path="services" element={<ServicesPage />} />
        <Route path="services/:slug" element={<ServiceDetailPage />} />
        <Route path="projects" element={<ProjectsPage />} />
        <Route path="projects/:slug" element={<ProjectDetailPage />} />
        <Route path="team" element={<TeamPage />} />
        <Route path="careers" element={<CareersPage />} />
        <Route path="blog" element={<BlogPage />} />
        <Route path="blog/:slug" element={<BlogDetailPage />} />
        <Route path="privacy-policy" element={<LegalPage type="privacy" />} />
        <Route path="terms-and-conditions" element={<LegalPage type="terms" />} />
        <Route path="contact" element={<ContactPage />} />
        <Route path="request-quote" element={<QuotePage />} />
      </Route>

      <Route path="admin/login" element={<AdminLoginPage />} />
      <Route element={<ProtectedRoute />}>
        <Route path="admin" element={<AdminLayout />}>
          <Route index element={<Navigate to="dashboard" replace />} />
          <Route path="dashboard" element={<AdminDashboardPage />} />
          <Route path="services" element={<AdminContentPage type="services" title="Services" />} />
          <Route path="projects" element={<AdminContentPage type="projects" title="Projects" />} />
          <Route path="team" element={<AdminContentPage type="team-members" title="Team Members" />} />
          <Route path="jobs" element={<AdminContentPage type="jobs" title="Careers" />} />
          <Route path="blog" element={<AdminContentPage type="blog-posts" title="Blog & News" />} />
          <Route path="testimonials" element={<AdminContentPage type="testimonials" title="Testimonials" />} />
          <Route path="enquiries" element={<AdminEnquiriesPage />} />
          <Route path="quotations" element={<AdminQuotationsPage />} />
          <Route path="job-applications" element={<AdminJobApplicationsPage />} />
          <Route path="users" element={<AdminUsersPage />} />
          <Route path="settings" element={<AdminSettingsPage />} />
        </Route>
      </Route>

      <Route path="*" element={<NotFoundPage />} />
    </Routes>
  );
}
