<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminStats extends Component
{
    public array $adminStats;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->adminStats = [
            'stats' => $this->handleAdminStats()
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.admin-stats')
            ->with('adminStats', $this->adminStats);
    }

    private function handleAdminStats(): array
    {
        return [
            [
                'id' => 1,
                'title' => __('Communication'),
                'icon' => 'fa-solid fa-comments',
                'stats' => [
                    [
                        'id' => 1,
                        'title' => __('Contact'),
                        'value' => 0 . ' ' . __('messages')
                    ],
                    [
                        'id' => 2,
                        'title' => __('Newsletter'),
                        'value' => 0 . ' ' . __('subscribers')
                    ],
                    [
                        'id' => 3,
                        'title' => __('Reviews'),
                        'value' => 0 . ' / 5'
                    ]
                ]
            ],
            [
                'id' => 2,
                'title' => __('Management'),
                'icon' => 'fa-solid fa-newspaper',
                'stats' => [
                    [
                        'id' => 1,
                        'title' => __('Articles'),
                        'value' => 0 . ' ' . __('articles') . ' | ' . 0 . ' ' . __('views')
                    ],
                    [
                        'id' => 2,
                        'title' => __('Comments'),
                        'value' => 0 . ' ' . __('comments')
                    ],
                    [
                        'id' => 3,
                        'title' => __('Appreciations'),
                        'value' => 0 . ' ' . __('likes') . ' | ' . 0 . ' ' . __('dislikes')
                    ]
                ]
            ]
        ];
    }
}
