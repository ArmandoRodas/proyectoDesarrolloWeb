@extends('adminlte::page')

@section('title', 'Clientes | Facturas por Cobrar')

@section('content_header')
    <h1>Historial de cobros</h1>
@stop

@section('content')
    <livewire:pagosCobros.cliente.historialCobros>
@stop
