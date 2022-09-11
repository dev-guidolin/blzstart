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
            @if($user->status == 'novo' && mensalidadeEmDia($mensalidade))
                <x-adminlte-alert theme="" icon="fas fa-lg fa-thumbs-up" title="Conta Teste" style="background: #ff7c7c; color: white">
                   Teste até dia {{ \Carbon\Carbon::parse($user->mensalidade)->format('d-m-Y H:i')  }}
                </x-adminlte-alert>
            @elseif(mensalidadeEmDia($mensalidade))
                <x-adminlte-alert theme="success" icon="fas fa-lg fa-thumbs-up" title="STATUS CONTA">
                    Conta Ativa
                </x-adminlte-alert>
            @else
                <a href="">
                    <x-adminlte-alert theme="danger" icon="fas fa-lg fa-exclamation" title="STATUS CONTA">
                        SUSPENSA. Clique para regularizar.
                    </x-adminlte-alert>
                </a>
            @endif
        </div>

    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <span style=" font-size: 32px">Suas sequências</span>
                    <a href="{{route('double.criar')}}"><button type="button" class="btn btn-primary  float-sm-right ">CRIAR SEQUÊNCIA BLAZE</button></a>
                </div>

                <div class="card-body p-0">
                    <table class="table table-striped table-responsive-sm">
                        <thead>
                        <tr>
                            <th style="width: 125px">Título</th>
                            <th>Sequência</th>
                            <th>Entrada</th>
                            <th class="text-center">Grupos</th>
                            <th class="text-center" style="width: 50%">Progresso</th>
                            <th class="text-center">Acertos</th>
                            <th class="text-center">Tot. Entradas</th>
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
                            <td class="align-middle text-left text-uppercase">
                                @php
                                    if($seq['grupos'] == null or count($seq['grupos']) < 1){
                                        echo "Sequencia sem grupo";
                                    }else{
                                        foreach ($seq['grupos'] as $grupo){
                                            echo $grupo. "<br>";
                                        }
                                    }
                                @endphp
                            </td>
                            <td class="align-middle">
                                <div class="progress progress-xs">
                                    <div class="progress-bar progress-bar-{{$printAcertos['color']}}" style="width: {{$printAcertos['valor']}}%"></div>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                <span class="badge bg-{{$printAcertos['color']}}"> {{$percentual}}%</span>
                            </td>
                            <td class="align-middle text-center">
                               {{  $seq['data']->erros +  $seq['data']->acertos  }}
                            </td>
                            <td class="text-center align-middle">
                                <x-adminlte-button theme="outline-danger" icon="fas fa-lg fa-trash" data-id="{{ $seq['data']->id }}" title="Apagar sequência" class="action mb-3 mb-sm-3 mb-lg-0" data-location="delete"/>

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

            if($(this).data('location') === 'edit'){
                window.location.href = `editar-sequencia/${$(this).data('id')}`
                return false;
            }
            var seqId = $(this).data('id')
            $.ajax({
                url: "delete-sequencia",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data:{id: seqId},
                type:"post",
                method:"post",
                success:(resp)=>{

                    if(resp.success){
                        Swal.fire({
                            title: 'Sucesso!',
                            text: resp.message,
                            icon: 'success',
                            confirmButtonText: 'Fechar'
                        }).then(()=>{
                            window.location.reload()
                        })
                    }else{
                        Swal.fire({
                            title: 'Ops!',
                            text:  resp.message,
                            icon: 'error',
                            confirmButtonText: 'Fechar'
                        })
                        return false
                    }

                },
                error:(err)=>{

                }

            });
        })
    </script>
@stop
