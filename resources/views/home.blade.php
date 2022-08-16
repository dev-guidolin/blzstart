@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Telegram</div>

                <div class="card-body">
                    <b>Token:</b> {{ $user->telegram_token }}
                    <br>
                    <b>ID:</b> {{ $user->telegram_id ?? "Sem cadastro" }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Chats</div>

                <div class="card-body">
                    <b>Total:</b> {{ count($user->chats) }}
                    <br>
                    <b>Grupos:</b> {{ count($user->chats) }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Chats</div>

                <div class="card-body">
                    <b>Total:</b> {{ count($user->chats) }}
                    <br>
                    <b>Grupos:</b> {{ count($user->chats) }}
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header bg-primary text-white">Chats</div>

                <div class="card-body">
                    <b>Mensalidade:</b> {{ count($user->chats) }}
                    <br>
                    <b>Vencimento:</b> {{ count($user->chats) }}
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-sm-6">
            <h3>Roleta</h3>

            <a href="/sequencia/roleta">
                <button class="btn btn-primary" type="submit">Criar Sequência</button>
            </a>
        </div>
        <div class="col-sm-6">
            <h3>Crash</h3>

            <button class="btn btn-primary" type="submit">Criar Sequência</button>
        </div>
    </div>
</div>
@endsection
