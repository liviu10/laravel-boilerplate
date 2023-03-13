@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">{{ __('Dashboard') }}</div>

            <div class="card-body">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                {{ __('You are logged in!') }}
            </div>

            <div>
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea class="ckeditor form-control" name="wysiwyg-editor"></textarea>
                    </div>
                </form>
                @push('scripts')
                    <script>
                        $(document).ready(function () {
                            $('.ckeditor').ckeditor();
                        });
                    </script>
                @endpush
            </div>
        </div>
    </div>
</div>
@endsection
