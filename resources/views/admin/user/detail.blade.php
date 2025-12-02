@extends('layouts.backend.app')

@section('content')
    <div class="my-3 my-md-5">
        <div class="container">

            <form class="row justify-content-between"
                action="{{ !empty($user) ? route('account.user.update',$user->id) : route('account.user.store') }}"
                method="POST" enctype="multipart/form-data">

                @csrf
                @if (isset($user))
                    @method('PUT')
                @endif
                <div class="col-md-8 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{ $sub_title }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="col-lg-12">

                                {{-- TITLE --}}
                                <div class="form-group">
                                    <label for="name">Nama User</label>
                                    <input type="text" class="form-control @error('title') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name', $user->name ?? '') }}"
                                        placeholder="Nama Pengguna...">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email', $user->email ?? '') }}"
                                        placeholder="pengguna@ransum.com...">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Password --}}
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="password" name="password" placeholder="Password Pengguna...">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Role --}}
                                <div class="form-group">
                                    <label for="role">Hak Akses</label>
                                    @php
                                        $roles = ['Admin', 'Editor', 'Jurnalis', 'Pembaca', 'Staff'];
                                    @endphp

                                    <select class="form-control @error('role') is-invalid @enderror" id="role"
                                        name="role">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role }}"
                                                {{ old('role', $user->role ?? '') === $role ? 'selected' : '' }}>
                                                {{ $role }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <div class="card-footer text-right">
                                <button type="reset" class="btn btn-danger">
                                    Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($post) ? 'Perbarui' : 'Simpan' }}
                                </button>
                            </div>
                        </div>
                        <div class="card-footer">
                            {{ env('APP_NAME') }} - {{ $title }}
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">

                    <div class="card">
                        <div class="card-body">

                            {{-- IMAGE Preview --}}
                            <div class="mt-2 text-center mb-2">

                                @if (isset($post))
                                    <img id="preview-image"
                                        src="{{ file_exists(public_path('avatar/' . $post->avatar)) ? asset('avatar/' . $post->avatar) : asset('avatar/OawWpWlmNieu.jpg') }} "
                                        data-default="{{ file_exists(public_path('avatar/' . $post->avatar)) ? asset('avatar/' . $post->avatar) : asset('avatar/OawWpWlmNieu.jpg') }}"
                                        alt="Image Preview" class="img-thumbnail" width="200">
                                @else
                                    <img id="preview-image" src="{{ asset('avatar/OawWpWlmNieu.jpg') }}"
                                        data-default="{{ asset('avatar/OawWpWlmNieu.jpg') }}" alt="Image Preview"
                                        accept=".jpg,.jpeg,image/jpeg" class="img-thumbnail" width="200">
                                @endif
                            </div>
                            {{-- IMAGE --}}
                            <div class="form-group">
                                <label for="avatar">Avatar</label>
                                <input type="file" class="form-control-file @error('image') is-invalid @enderror"
                                    id="avatar" name="avatar">
                                @error('image')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="card-footer col-lg-12">
                            <button type="button" id="reset-avatar" class="btn btn-danger btn-reset-image form-control">
                                Reset
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        // Preview upload gambar
        document.getElementById('avatar').addEventListener('change', function(event) {
            const [file] = event.target.files;
            if (file) {
                const preview = document.getElementById('preview-image');
                preview.src = URL.createObjectURL(file);
            }
        });

        $('#reset-avatar').on('click', function() {
            const preview = $('#preview-image');
            const defaultImg = preview.data('default');

            // Reset input file
            $('#avatar').val('');

            // Reset preview ke default
            preview.attr('src', defaultImg);
        });
    </script>
@endsection
