<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdminInsights extends Component
{
    public array $adminInsights;

    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->adminInsights = [
            'menu' => $this->handleAdminInsightMenu(),
            'contact' => $this->handleAdminInsightContact(),
            'newsletter' => $this->handleAdminInsightNewsletter(),
            'review' => $this->handleAdminInsightReview(),
            'content' => $this->handleAdminInsightContent(),
            'appreciation' => $this->handleAdminInsightAppreciation(),
        ];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.admin.admin-insights')
            ->with('adminInsights', $this->adminInsights);
    }

    private function handleAdminInsightMenu(): array
    {
        return [
            [
                'id' => 1,
                'key' => 'collapseContact',
                'label' => __('Contact')
            ],
            [
                'id' => 2,
                'key' => 'collapseNewsletter',
                'label' => __('Newsletter')
            ],
            [
                'id' => 3,
                'key' => 'collapseReview',
                'label' => __('Review')
            ],
            [
                'id' => 4,
                'key' => 'collapseContent',
                'label' => __('Content')
            ],
        ];
    }

    private function handleAdminInsightContact(): array
    {
        return [];
    }

    private function handleAdminInsightNewsletter(): array
    {
        return [];
    }

    private function handleAdminInsightReview(): array
    {
        return [];
    }

    private function handleAdminInsightContent(): array
    {
        return [];
    }

    private function handleAdminInsightComment(): array
    {
        return [];
    }

    private function handleAdminInsightAppreciation(): array
    {
        return [];
    }
}
