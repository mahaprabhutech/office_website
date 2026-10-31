/**
 * Public portfolio visibility policy.
 * Hide Fulawala by its slug, title or name without deleting the database record.
 * Reuse isFulawalaProject() when guarding ProjectDetailPage routes.
 */
export function isFulawalaProject(project) {
  if (!project || typeof project !== 'object') return false;

  const normalize = (value) =>
    String(value ?? '').toLowerCase().replace(/[^a-z0-9]/g, '');

  return [project.slug, project.title, project.name]
    .some((value) => normalize(value).includes('fulawala'));
}

export function visibleProjects(projects) {
  if (!Array.isArray(projects)) return [];

  return projects.filter(
    (project) =>
      project &&
      !isFulawalaProject(project) &&
      project.active !== false &&
      project.active !== 0 &&
      project.active !== '0'
  );
}
