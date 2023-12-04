<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fila de Itens</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body>
    <div id="app">
        <div class="app-container">
            <div class="app-header box ">
                <span class="eixo-x"></span>
                <span class="eixo-y"></span>
                <span class="eixo-x"></span>
                <span class="eixo-y"></span>
                <div class="content">
                    <h2>
                        Arraste e solte para alterar a ordem dos cards
                    </h2>
                </div>
            </div>
            <div class="app-content">
                <div class="card-colum">
                    @foreach($itens->take(2) as $item)
                    <div class="card card-no-swap">
                        <div class="card-begin">
                            <p>cod {{ $item->cod }} </p>
                        </div>
                        <div class="card-body">
                            <p> {{ $item->name }} </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-colum" id="sortable-container">
                    {{-- Restante dos itens (exceto os dois primeiros e o último) --}}
                    @foreach($itens->slice(2, -1) as $item)
                    <div name="{{ $item->cod }}" data-id="{{ $item->cod }}" class="card card-for-swap">
                        <div class="card-begin">
                            <p>cod {{ $item->cod }} </p>
                        </div>
                        <div class="card-body">
                            <p> {{ $item->name }} </p>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="card-colum">
                    {{-- Último item --}}
                    @foreach($itens->slice(-1) as $item)
                    <div class="card card-no-swap">
                        <div class="card-begin">
                            <p>cod {{ $item->cod }} </p>
                        </div>
                        <div class="card-body">
                            <p> {{ $item->name }} </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <button class="btn btn-primary" type="button" onclick="updateOrder()">SAVE</button>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const sortable = new Sortable(document.getElementById('sortable-container'), {
                animation: 150,
                onEnd: function(evt) {
                    const itemId = evt.item.getAttribute('data-id');
                    const newIndex = evt.newIndex + 3;
                    const items = document.querySelectorAll('.card-for-swap');
                    items.forEach(item => {
                        const currentId = parseInt(item.getAttribute('data-id'), 10);

                        if (currentId > itemId && currentId <= newIndex) {
                            item.setAttribute('data-id', currentId - 1);
                        } else if (currentId < itemId && currentId >= newIndex) {
                            item.setAttribute('data-id', currentId + 1);
                        }
                    });
                    evt.item.setAttribute('data-id', newIndex);
                    console.log(`Item ID: ${itemId}, Nova Posição: ${newIndex}`);
                },
            });
        });

        function updateOrder() {
            const items = document.querySelectorAll('.card-for-swap');
            const cardProperties = Array.from(items).map(card => {
                return {
                    newId: card.dataset.id,
                    id: card.getAttribute('name'),
                };
            });
            console.log(cardProperties);
            $.post('{{route("fila.update")}}', {

                data: {
                    cardProperties
                }
            }, function(response) {
                console.log("response", response);
                location.reload();
            });

        }
    </script>
</body>

</html>