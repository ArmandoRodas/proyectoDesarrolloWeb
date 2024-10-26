@extends('adminlte::page')

@section('title', 'Clientes | Facturas por Cobrar')

@section('content_header')
    <h1>Facturas por Cobrar</h1>
@stop

@section('content')
    <livewire:pagosCobros.cliente.facturasCobrar>
@stop
