@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<h4 class="mb-3">Tambah Berita</h4>

<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
            @include('admin.berita._form', ['berita' => $berita])
        </form>
    </div>
</div>
@endsection
