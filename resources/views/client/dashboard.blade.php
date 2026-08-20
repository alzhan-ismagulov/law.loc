@extends('client.layouts.app')

@section('content')
<div class="nova-card-table" style="padding: 25px;">
    <div class="table-header" style="margin-bottom: 15px;">Добро пожаловать, {{ $client->name }}!</div>
    <p style="color: #64748b; font-size: 14px; line-height: 1.5;">
        Это ваш личный кабинет в ТОО "Legal Core". Здесь вы можете отслеживать статусы ваших юридических и переводческих заказов, а также управлять своими данными.
    </p>
</div>
@endsection