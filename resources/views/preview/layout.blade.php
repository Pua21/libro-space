@extends('layouts.' . $role)

@section('title', 'Pratinjau Layout ' . ucfirst($role))

@section('content')
    <h1>Pratinjau Layout {{ ucfirst($role) }}</h1>
    <p>Halaman ini menampilkan kerangka navigasi dan area konten.</p>
@endsection
