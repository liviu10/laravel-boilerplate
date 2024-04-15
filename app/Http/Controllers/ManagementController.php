<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * @return View|Application|Factory
     */
    public function index(): View|Application|Factory
    {
        $data = [
            'resources' => [
                'content' => $this->handleContentResources(),
                'tags' => $this->handleTagResources(),
                'media' => $this->handleMediaResources(),
                'comments' => $this->handleCommentResources(),
                'appreciations' => $this->handleAppreciationResources(),
            ]
        ];

        return view('admin-management', compact('data'));
    }

    private function handleContentResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Content types',
                'url' => '/admin/management/contents/types'
            ],
            [
                'id' => 2,
                'title' => 'Content visibilities',
                'url' => '/admin/management/contents/visibilities'
            ],
            [
                'id' => 3,
                'title' => 'Content social',
                'url' => '/admin/management/contents/social'
            ],
            [
                'id' => 4,
                'title' => 'Content',
                'url' => '/admin/management/contents'
            ]
        ];
    }

    private function handleTagResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Tags',
                'url' => '/admin/management/tags'
            ],
        ];
    }

    private function handleMediaResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Media types',
                'url' => '/admin/management/media/types'
            ],
            [
                'id' => 2,
                'title' => 'Media',
                'url' => '/admin/management/media'
            ],
        ];
    }

    private function handleCommentResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Comment types',
                'url' => '/admin/management/comments/types'
            ],
            [
                'id' => 2,
                'title' => 'Comment statuses',
                'url' => '/admin/management/comments/statuses'
            ],
            [
                'id' => 3,
                'title' => 'Comments',
                'url' => '/admin/management/comments'
            ],
        ];
    }

    private function handleAppreciationResources(): array
    {
        return [
            [
                'id' => 1,
                'title' => 'Appreciation',
                'url' => '/admin/management/appreciations'
            ],
        ];
    }
}
