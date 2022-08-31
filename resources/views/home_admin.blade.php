@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-sm-3">
            <x-adminlte-alert theme="info" icon="fab fa-lg fa-telegram" title="TELEGRAM">
                {{ $user->telegram_id ? "CHATS: ".$chats :"TOKEN: ".$telegram }}
            </x-adminlte-alert>
        </div>
        <div class="col-sm-3">
            @if(mensalidadeEmDia($mensalidade))
                <x-adminlte-alert theme="info" icon="fas fa-lg fa-thumbs-up" title="STATUS CONTA">
                    Conta Ativa
                </x-adminlte-alert>
            @else
                <x-adminlte-alert theme="danger" icon="fas fa-lg fa-exclamation" title="STATUS CONTA">
                    Ops, sua mensalidade está em aberto.
                </x-adminlte-alert>
            @endif
        </div>
        <div class="col-sm-3">
            <x-adminlte-alert theme="success" icon="fas fa-lg fa-check" title="ACERTOS">
                {{$totalAcertos}}
            </x-adminlte-alert>
        </div>
        <div class="col-sm-3">
            <x-adminlte-alert theme="info" icon="fas fa-lg fa-thumbs-up" title="SEQUÊNCIAS">
                {{$sequencias}}
            </x-adminlte-alert>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <x-adminlte-small-box title="" text="Sequencia Double" theme="teal" url="{{route('double.criar')}}" url-text="Criar"/>
        </div>
        <div class="col-sm-6">
            <div class="cho-container"></div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('TEST-3a9c7a06-05bb-452d-9e4f-414e9b340e27', {
            locale: 'pt-BR'
        });

        mp.checkout({
            preference: {
                id: '{{$mp_id}}'
            },
            render: {
                container: '.cho-container',
                label: 'Pagar',
            }
        });
    </script>
@stop
