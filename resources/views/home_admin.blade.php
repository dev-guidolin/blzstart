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

    </div>
    <div class="row">
        <div class="col-sm-3">
            <x-adminlte-small-box title="" text="Sequencia Double" theme="teal" url="{{route('double.criar')}}" url-text="Criar"/>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sequências cadastradas</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th style="width: 125px">Título</th>
                            <th>Sequência</th>
                            <th>Entrada</th>
                            <th class="text-center">Grupos</th>
                            <th class="text-center" style="width: 50%">Progresso</th>
                            <th class="text-center">Acertos</th>
                            <th class="text-center">Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($sequencias as $seq)
                            @php
                                $percentual = (int)percentualAcerto(['acertos' => $seq['data']->acertos,'erros' => $seq['data']->erros]);
                                if($percentual >= 75):
                                    $printAcertos = ['color' => 'success','valor' => $percentual];
                                elseif ($percentual <= 50 and $percentual >= 25 ):
                                    $printAcertos = ['color' => 'warning','valor' => $percentual];
                                else:
                                    $printAcertos = ['color' => 'danger','valor' => $percentual];
                                endif;
                            @endphp
                        <tr>
                            <td class="align-middle" style="text-transform: uppercase">{{ $seq['data']->titulo }}</td>
                            <td class="align-middle">{{ toEmoji($seq['data']->sequencia) }}</td>
                            <td class="align-middle text-center">{{ toEmoji(substr($seq['data']->entrada,-1)) }}</td>
                            <td class="align-middle text-center">
                                @foreach($seq['grupos'] as $grupo)
                                    {{$grupo}} <br>
                                @endforeach
                            </td>
                            <td class="align-middle">
                                <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-{{$printAcertos['color']}}" style="width: {{$printAcertos['valor']}}%"></div>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-{{$printAcertos['color']}}"> {{$percentual}}%</span>
                            </td>
                            <td class="text-center align-middle">
                                <x-adminlte-button theme="outline-danger" icon="fas fa-lg fa-trash" data-id="{{ $seq['data']->id }}" title="Apagar sequência" class="action" data-location="delete"/>
                                <x-adminlte-button theme="outline-info" icon="fas fa-lg fa-edit" data-id="{{ $seq['data']->id }}" title="Editar sequência" class="action" data-location="edit"/>
                            </td>
                        </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@stop

@section('css')
@stop

@section('js')
    <script>
        $(".action").click(function (){
            var location = $(this).data('location')
            var seqId = $(this).data('id')
            let url = location == 'edit' ? 'seq-edit/'+ seqId : 'seq-delete/' + seqId
            console.log(url)
        })
    </script>
@stop
