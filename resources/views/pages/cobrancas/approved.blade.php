@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h5>Pagamento aprovado</h5>
@stop

@section('content')
    <div class="row mt-5">
        <div class="col-sm-4 mx-auto">
            <x-adminlte-profile-widget name="Plano Mensal Ativado" desc="Thiago" theme="dark" img="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4ny_e9VwBLNxI51q8kZ4B-u5a-Wm6pD6m54hpwGxB1tVStyIIw9TaGztGZWavpuPduNg&usqp=CAU">
                <x-adminlte-profile-col-item class="text-success border-right"  title="Início" text="01-09-2022" size=6 badge="success p-2"/>
                <x-adminlte-profile-col-item class="text-danger"  title="Fim" text="01-10-2022" size=6 badge="danger p-2"/>
            </x-adminlte-profile-widget>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
@stop
