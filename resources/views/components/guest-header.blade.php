<div class="row guest guest--component" @if($headerId) id="{{ $headerId }}" @endif>
    <h1 class="col-12 guest__header">
        {{ $slot }}
    </h1>
</div>
