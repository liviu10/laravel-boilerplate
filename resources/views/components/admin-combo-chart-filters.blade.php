<div class="admin__combo-chart-filters">
    <div class="admin__combo-chart-filters-resource">
        @include('components.generic-select', $input = [
            'id' => 'resource_filter',
            'options' => [
                [
                    'id' => 1,
                    'value' => 'communication',
                    'label' => __('Communication'),
                ],
                [
                    'id' => 2,
                    'value' => 'management',
                    'label' => __('Management'),
                ],
                [
                    'id' => 3,
                    'value' => 'settings',
                    'label' => __('Settings'),
                ],
            ]
        ])
    </div>
    <div class="admin__combo-chart-filters-date">
        @include('components.generic-select', $input = [
            'id' => 'week_filter',
            'options' => [
                [
                    'id' => 1,
                    'value' => 'one',
                    'label' => __('One'),
                ],
                [
                    'id' => 2,
                    'value' => 'two',
                    'label' => __('Two'),
                ],
                [
                    'id' => 3,
                    'value' => 'three',
                    'label' => __('Three'),
                ],
            ]
        ])
        @include('components.generic-select', $input = [
            'id' => 'month_filter',
            'options' => [
                [
                    'id' => 1,
                    'value' => 'one',
                    'label' => __('One'),
                ],
                [
                    'id' => 2,
                    'value' => 'two',
                    'label' => __('Two'),
                ],
                [
                    'id' => 3,
                    'value' => 'three',
                    'label' => __('Three'),
                ],
            ]
        ])
        @include('components.generic-select', $input = [
            'id' => 'year_filter',
            'options' => [
                [
                    'id' => 1,
                    'value' => 'one',
                    'label' => __('One'),
                ],
                [
                    'id' => 2,
                    'value' => 'two',
                    'label' => __('Two'),
                ],
                [
                    'id' => 3,
                    'value' => 'three',
                    'label' => __('Three'),
                ],
            ]
        ])
    </div>
</div>
