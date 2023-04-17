@if (count($accordionItem))
    <div class="accordion" id="accordionExample">
        @foreach ($accordionItem as $item)
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#collapse{{ $item['id'] }}"
                        aria-expanded="true"
                        aria-controls="collapse{{ $item['id'] }}"
                    >
                        {{ $item['label'] }}
                    </button>
                </h2>
                <div
                    id="collapse{{ $item['id'] }}"
                    class="accordion-collapse collapse show"
                    aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample"
                >
                    <div class="accordion-body">
                        {{ $item['content'] }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
