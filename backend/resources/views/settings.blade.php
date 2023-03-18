@extends('layouts.admin')

@section('content')
    <div class="admin settings">
        <h1>
            {{ __('Settings') }}
        </h1>

        <div class="menu">
            <div class="row">
                <div class="card col-lg-8 col-md-8 col-sm-8">
                    <div class="card-body">
                        @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <p class="my-0">{{ $message }}</p>
                                <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form method="POST" action="">
                            @csrf
                            @method('PUT')

                            <input type="hidden" name="id" value="">

                            <!-- Website language -->
                            <div>
                                <div class="row">
                                    <p class="lead">
                                        {{ __('Website\'s language') }}
                                    </p>
                                </div>

                                <!-- Guest language -->
                                <div class="row mb-3">
                                    <label for="guest_language" class="form-label">{{ __('Guest language') }}</label>

                                    <div>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>{{ __('Select guest language') }}</option>
                                            {{-- @foreach ($displayAllRecords['user_role_types'] as $key => $item) --}}
                                            {{-- <option value="{{ $item->id }}">{{ $item->id }} -> {{ $item->user_role_name }}</option> --}}
                                            {{-- @endforeach --}}
                                        </select>
                                        @error('guest_language')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Admin language -->
                                <div class="row mb-3">
                                    <label for="admin_language" class="form-label">{{ __('Admin language') }}</label>

                                    <div>
                                        <select class="form-select" aria-label="Default select example">
                                            <option selected>{{ __('Select admin language') }}</option>
                                            {{-- @foreach ($displayAllRecords['user_role_types'] as $key => $item) --}}
                                            {{-- <option value="{{ $item->id }}">{{ $item->id }} -> {{ $item->user_role_name }}</option> --}}
                                            {{-- @endforeach --}}
                                        </select>
                                        @error('admin_language')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="card-actions">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
