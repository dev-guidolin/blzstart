@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h5>Pagamento pendente</h5>
@stop

@section('content')
    <div class="row mt-5">
        <div class="col-sm-4 mx-auto">
            <x-adminlte-profile-widget name="Pagamento Pendente"  theme="warning" img="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcR4ny_e9VwBLNxI51q8kZ4B-u5a-Wm6pD6m54hpwGxB1tVStyIIw9TaGztGZWavpuPduNg&usqp=CAU">
                <x-adminlte-button label="Voltar para o painel adminitrativo" theme="warning" class="btn-block mt-3"  icon="fas fa-exclamation-triangle" title="Voltar para o painel administrativo"/>
            </x-adminlte-profile-widget>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(function(){
            $(".btn-block").click(function (){
                window.location.href = '/dashboard'
            })
        })

    </script>

@stop
