@extends('admin.institution.add')
@section('editId', route('institution.update', [$id]))

@section('editMethod')
  {{method_field('PUT')}}
@endsection