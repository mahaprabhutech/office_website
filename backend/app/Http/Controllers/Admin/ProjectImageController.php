<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminActivity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProjectImageController extends Controller
{
    public function store(Request $request, int $project): RedirectResponse
    {
        abort_unless(Schema::hasTable('projects') && Schema::hasTable('project_images'), 404);

        $request->validate([
            'gallery_images' => ['required', 'array', 'min:1', 'max:12'],
            'gallery_images.*' => ['required', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'max:5120'],
        ]);

        abort_unless(DB::table('projects')->where('id', $project)->exists(), 404);

        $columns = Schema::getColumnListing('project_images');
        $foreignKey = $this->first($columns, ['project_id', 'projectId']);
        $imageColumn = $this->first($columns, ['image', 'image_path', 'path', 'image_url']);

        abort_unless($foreignKey && $imageColumn, 422, 'project_images needs a project_id and image path column.');

        foreach ($request->file('gallery_images', []) as $file) {
            $data = [
                $foreignKey => $project,
                $imageColumn => $file->store('website/projects/gallery', 'public'),
            ];

            if (in_array('created_at', $columns, true)) {
                $data['created_at'] = now();
            }
            if (in_array('updated_at', $columns, true)) {
                $data['updated_at'] = now();
            }

            DB::table('project_images')->insert($data);
        }

        AdminActivity::record('upload', 'project-images', $project, 'Uploaded project gallery images.');

        return back()->with('success', 'Project gallery updated.');
    }

    public function destroy(int $project, int $image): RedirectResponse
    {
        abort_unless(Schema::hasTable('project_images'), 404);

        $columns = Schema::getColumnListing('project_images');
        $foreignKey = $this->first($columns, ['project_id', 'projectId']);
        $imageColumn = $this->first($columns, ['image', 'image_path', 'path', 'image_url']);

        abort_unless($foreignKey && $imageColumn, 422);

        $record = DB::table('project_images')
            ->where('id', $image)
            ->where($foreignKey, $project)
            ->first();

        abort_unless($record, 404);

        $path = $record->{$imageColumn} ?? null;
        if ($path && !Str::startsWith((string) $path, ['http://', 'https://'])) {
            Storage::disk('public')->delete(Str::replaceFirst('storage/', '', ltrim((string) $path, '/')));
        }

        DB::table('project_images')->where('id', $image)->delete();

        AdminActivity::record('delete', 'project-images', $image, 'Deleted a project gallery image.');

        return back()->with('success', 'Gallery image removed.');
    }

    private function first(array $columns, array $candidates): ?string
    {
        foreach ($candidates as $column) {
            if (in_array($column, $columns, true)) {
                return $column;
            }
        }

        return null;
    }
}
