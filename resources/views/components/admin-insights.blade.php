<div class="col-xxl-8 col-xl-10 col-lg-10 col-md-12 col-sm-12 col-12 admin__insights-body">
    <p>
        @foreach($adminInsights['menu'] as $key => $menu)
            <button
                class="btn btn-outline-primary"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#{{ $menu['key'] }}"
                aria-expanded="true"
                aria-controls="{{ $menu['key'] }}"
            >
                {{ $menu['label'] }}
            </button>
        @endforeach
    </p>
    <div class="collapse show" id="collapseContact">
        @include('components.admin-insights-contact')
    </div>
    <div class="collapse" id="collapseNewsletter">
        @include('components.admin-insights-newsletter')
    </div>
    <div class="collapse" id="collapseReview">
        @include('components.admin-insights-review')
    </div>
    <div class="collapse" id="collapseContent">
        @include('components.admin-insights-content')
    </div>
    <div class="collapse" id="collapseComment">
        @include('components.admin-insights-comment')
    </div>
    <div class="collapse" id="collapseAppreciation">
        @include('components.admin-insights-appreciation')
    </div>
</div>
<script>
    const collapseButtons = document.querySelectorAll('[data-bs-toggle="collapse"]');
    collapseButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetCollapse = document.querySelector(button.getAttribute('data-bs-target'));
            const currentlyExpanded = document.querySelector('.collapse.show');
            if (currentlyExpanded && currentlyExpanded !== targetCollapse) {
                currentlyExpanded.classList.remove('show');
            }
        });
    });
</script>
