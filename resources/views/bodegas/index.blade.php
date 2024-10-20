@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Bodega</h1>
@stop

@section('content')
    <livewire:bodega.BodegasInventario :bodegaId="$bodegaId">
@stop
