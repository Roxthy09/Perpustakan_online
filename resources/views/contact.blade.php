@extends('layouts.admin.admin')

@section('content')
<div class="container">
    <h1>Form Kontak</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="/contact">
        @csrf
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Pesan</label>
            <textarea name="message" class="form-control" rows="4" required></textarea>
        </div>

        <button class="btn btn-primary" type="submit">Kirim</button>
    </form>
</div>
@endsection
