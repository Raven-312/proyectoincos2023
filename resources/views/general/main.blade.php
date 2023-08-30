@extends('general.base')
@if(session('accessSession') == 'root')
    @include('sidebar.admin')
@else
    @include('sidebar.vendedor')
@endif
@include('sidebar.admin')
@extends('general.topbar')

