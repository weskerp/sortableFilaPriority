<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fila de Itens</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    


    <!-- Inclua os estilos e scripts necessários -->
    <style>
        #app{
            background-color: rgba(150,150,150,0.5);
            width: 100vw;
            min-height: 100vh;
        }
        .app-container{
            margin: 20px, 50px;
            padding: 200px;
            display: flex;
            flex-direction: row;
            gap: 50px;
        }
        .card{
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            background-color: white;
            box-shadow: 3px 3px red,-1em 0 0.4em olive;
            min-height: 30px;
            width: 450px;
            cursor: grab;
        }
    </style>
</head>
<body>
    <div id="app">
        <div class="app-container">
            <div class="card-colum">
                
                @foreach($itens->take(2) as $item)
                <div class="card">
                    <!-- Conteúdo do card -->
                    <h5> {{ $item->nome }} </h5>
                </div>
                @endforeach
                
            </div>
            <div class="card-colum" id="sortable-container">

                {{-- Restante dos itens (exceto os dois primeiros e o último) --}}
                @foreach($itens->slice(2, -1) as $item)
                <div name="{{ $item->cod }}" data-id="{{ $item->cod }}" class="card card-for-swap">
                    <!-- Conteúdo do card -->
                    <p>cod_ant {{ $item->ant }} </p>
                    <p>cod {{ $item->cod }} </p>
                    <p>id:  {{ $item->id }} </p>
                    <p> {{ $item->nome }} </p>
                    <p>cod_prox: {{ $item->prox }} </p>
                </div>
                @endforeach
                
            </div>
            <div class="card-colum">
                {{-- Último item --}}
                @foreach($itens->slice(-1) as $item)
                <div  class="card">
                    <!-- Conteúdo do card -->
                    <h5> {{ $item->nome }} </h5>
                </div>
                @endforeach
            </div>
        </div>
        <button type="button" onclick="updateOrder()">SAVE</button>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            const sortable = new Sortable(document.getElementById('sortable-container'), {
                animation: 150,
                onEnd: function (evt) {
                    // Aqui você pode acessar as propriedades data-id dos elementos
                    const itemId = evt.item.getAttribute('data-id');
                    const newIndex = evt.newIndex + 3;
                    // Atualize os data-id dos itens entre o data-id antigo e o novo
                    const items = document.querySelectorAll('.card-for-swap');
                    items.forEach(item => {
                        const currentId = parseInt(item.getAttribute('data-id'), 10);
                        
                        if (currentId > itemId && currentId <= newIndex) {
                            // Incremento para itens que estão agora abaixo do item movido
                            item.setAttribute('data-id', currentId - 1);
                        } else if (currentId < itemId && currentId >= newIndex) {
                            // Decremento para itens que estão agora acima do item movido
                            item.setAttribute('data-id', currentId + 1);
                        }
                    });
                    evt.item.setAttribute('data-id', newIndex);
                    // Implemente aqui a lógica para atualizar a ordem no backend (se necessário)
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
                
                data: { cardProperties }
            }, function (response) {
                console.log("response", response);
            });

        }
    </script>
</body>
</html>
