{{-- @extends('errors::minimal') --}}
@extends('errors::custom-layout2')

@section('title', __('No autorizado'))
@section('code', '401')
@section('message', __('Este usuario no autorizado para acceder a esta página.'))
