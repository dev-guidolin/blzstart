@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <div class="container pt-5">
        <div class="row">
            <div class="col-12 text-break mb-3 p-2" id="sequencia" style="min-height: 75px; border: 1px solid #98dcff">
            </div>
            <div class="col-12 col-sm-4 color  bg-danger p-2 text-center" data-color="🔴">
                <span class="text-white">Red</span>
            </div>
            <div class="col-12 col-sm-4 color bg-dark  p-2 text-center" data-color="⚫">
                <span class="text-white">Black</span>
            </div>
            <div class="col-12 col-sm-4 color bg-success  p-2 text-center" data-color="⚪">
                <span class="text-danger"><b>Coringa</b></span>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12   p-2 text-center" >
                <div class="row">
                    <div class="col-6 text-white bg-primary py-1" id="erase">
                        APAGAR
                    </div>
                    <div class="col-6 text-white bg-danger py-1" id="eraseAll">
                        LIMPAR SEQUÊNCIA
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12 col-md-6 mt-3">
                <h6>Entrada</h6>
                <select class="form-control" id="entrada">
                    <option value="0" selected>🔴</option>
                    <option value="1">⚫</option>
                    <option value="2">⚪</option>
                </select>
            </div>
            <div class="col-md-6 col-12  mt-3">
                <h6>Nome da sequencia</h6>
                <input type="text" class="form-control" id="titulo">
            </div>
            <div class="col-12 mt-3">
                <label for="descricao" class="form-label">Descrição ( será enviado ao telegram ) </label>
                <textarea class="form-control" id="descricao" name="descricao" rows="5"></textarea>
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
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {

            $(".color").click(function(){
                let valor = $(this).data('color');
                $("#sequencia").append(valor)
            })

            $("#erase").click(function(){
                let string = $("#sequencia")
                    .text()
                    .split(/(?!$)/u)
                    .slice(0, -1)
                    .join('')
                $("#sequencia").text(string)
            })

            $("#eraseAll").click(function (){
                $("#sequencia").text('')
            })

            $("#salvar").click(function(e){

                e.preventDefault()

                let seq = $("#sequencia")
                    .text()
                    .replaceAll('🔴',0)
                    .replaceAll('⚫',1)
                    .replaceAll('⚪',2)
                let titulo = $("#titulo").val()
                let entrada = $('#entrada').val()
                let descript = $("#descricao").val()


                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url:"/ajax/criar-sequencia",
                    method:"POST",
                    data:{seq: seq,titulo:titulo,entrada:entrada,descricao:descript},
                    success:(resp)=>{

                        if(resp.success){
                            Swal.fire({
                                title: 'Sucesso!',
                                text: resp.message,
                                icon: 'success',
                                confirmButtonText: 'Fefchar'
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

                })


            })

        })
    </script>
@stop
