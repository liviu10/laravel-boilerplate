@extends('layouts.admin')

@section('content')
    <div class="admin contact">
        @include('components.page-title', [
            'title' => __('contact.page_title')
        ])

        <div class="menu">
            <div class="table-responsive col-lg-8 col-md-8 col-sm-8">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" id="users_alert">
                        <p class="my-0">{{ $message }}</p>
                        <button type="button" class="btn btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (gettype($displayAllRecords) === 'string')
                    <div class="alert alert-danger" role="alert">
                        {{ $displayAllRecords }}
                    </div>
                @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">{{ __('contact.column_id') }}</th>
                            <th scope="col">{{ __('contact.column_contact_details') }}</th>
                            <th scope="col">{{ __('contact.column_message') }}</th>
                            <th scope="col">{{ __('contact.column_actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($displayAllRecords as $key => $data)
                        <tr>
                            <th scope="row">
                                {{ $data->id }}
                            </th>
                            <td>
                                <span>{{ __('contact.show_label_full_name') }}:</span>
                                {{ $data->full_name }}
                                <br>
                                <span>{{ __('contact.show_label_email') }}:</span>
                                <a href="mailto:{{ $data->email }}">
                                    {{ $data->email }}
                                </a>
                                <br>
                                <span>
                                    {{ __('contact.show_label_phone_number') }}:
                                </span>
                                {{ $data->phone }}
                                <br>
                                <span>
                                    {{ __('contact.show_label_privacy_policy.title') }}:
                                </span>
                                @if ($data->privacy_policy === 1)
                                    {{ __('contact.show_label_privacy_policy.yes') }}
                                @else
                                    {{ __('contact.show_label_privacy_policy.no') }}
                                @endif
                            </td>
                            <td>
                                @if (strlen($data->message) >= 100)
                                    {{ substr($data->message, 0, 100) . '...' }}
                                @else
                                    {{ $data->message }}
                                @endif
                            </td>
                            <td>
                                <div>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#showRecordModal{{ $key }}">
                                        <i class="fas fa-info"></i>
                                    </button>

                                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editRecordModal{{ $key }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                </div>
                            </td>
                            <!-- Show record modal -->
                            <div class="modal fade" id="showRecordModal{{ $key }}" tabindex="-1" aria-labelledby="showRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="showRecordModalLabel{{ $key }}">
                                                {{  __('contact.show_user_title') }}
                                            </h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>{{ __('contact.show_label_id') }}:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_full_name') }}:</span>
                                                {{ $data->full_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_email') }}:</span>
                                                <a href="mailto:{{ $data->email }}">
                                                    {{ $data->email }}
                                                </a>
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_phone_number') }}:</span>
                                                {{ $data->phone }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_message') }}:</span>
                                                {{ $data->message }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_created_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d.m.Y H:i a') }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_updated_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('d.m.Y H:i a') }}
                                            </p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">{{ __('contact.close_button') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Edit record modal -->
                            <div class="modal fade" id="editRecordModal{{ $key }}" tabindex="-1" aria-labelledby="editRecordModalLabel{{ $key }}" aria-hidden="true" data-bs-backdrop="static">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="editRecordModalLabel{{ $key }}">{{ __('contact.update_user_role_title') }}</h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p>
                                                <span>{{ __('contact.show_label_id') }}:</span>
                                                {{ $data->id }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_full_name') }}:</span>
                                                {{ $data->full_name }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_email') }}:</span>
                                                <a href="mailto:{{ $data->email }}">
                                                    {{ $data->email }}
                                                </a>
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_phone_number') }}:</span>
                                                {{ $data->phone }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_message') }}:</span>
                                                {{ $data->message }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_created_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('d.m.Y H:i a') }}
                                            </p>
                                            <p>
                                                <span>{{ __('contact.show_label_updated_at') }}:</span>
                                                {{ DateTime::createFromFormat('Y-m-d H:i:s', $data->updated_at)->format('d.m.Y H:i a') }}
                                            </p>
                                            <form method="POST" action="{{ route('contact.update', $data->id) }}">
                                                @csrf
                                                @method('PUT')

                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <div class="modal-actions">
                                                    <div class="d-flex justify-content-center">
                                                        <button type="submit" class="btn btn-primary">
                                                            {{ __('contact.update_button') }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $displayAllRecords->links('pagination::bootstrap-5') }}
                @endif
            </div>
        </div>
    </div>
@endsection
