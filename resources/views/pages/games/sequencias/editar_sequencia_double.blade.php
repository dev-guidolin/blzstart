@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

   <div class="container py-5 ">
    <div class="row">
        <div class="col-12">
            <h3>Sua sequencia</h3>
            <p>
                {{ toEmoji($sequencia->sequencia)  }}
            </p>
        </div>
        <div class="col-12">
            <h6>Escolhas os grupos para esta sequência</h6>
            <select class="form-control select2" id="chats" name="chats[]"  multiple="multiple">
                @foreach($chats as $chat)
                    <option value="{{ $chat['chat_id'] }}">{{ $chat['name'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <div class="d-grid gap-1 mt-2">
                <button id="salvar" class="btn btn-success" type="button">SALVAR</button>
            </div>
        </div>
    </div>
   </div>

@stop

@section('css')
@stop

@section('js')
    <script>
        $('.select2').select2({
            placeholder:"Grupos de Alerta",
            allowClear: true
        });
        $("#salvar").click(function(e){

            e.preventDefault()

            let chats = $("#chats").val()

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:"/edit-sequence",
                method:"POST",
                data:{chats:chats, seqid:{{ $sequencia->id }} },
                    success:(resp)=>{

                        if(resp.success){
                            Swal.fire({
                                title: 'Sucesso!',
                                text: resp.message,
                                icon: 'success',
                                confirmButtonText: 'Fechar'
                            }).then(()=>{
                                window.location.href = "/dashboard"
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

                })
        })
    </script>
@stop
