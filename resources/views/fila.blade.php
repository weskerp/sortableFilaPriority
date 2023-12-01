<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila de Itens</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>

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
            background-color: white;
            box-shadow: 3px 3px red,-1em 0 0.4em olive;
            min-height: 30px;
            width: 300px;
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
                <div data-id="{{ $item->cod }}" class="card">
                    <!-- Conteúdo do card -->
                    <h5> {{ $item->nome }} </h5>
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
            const sortable = new Sortable(document.getElementById('sortable-container'), {
                animation: 150,
                onEnd: function (evt) {
                    // Aqui você pode acessar as propriedades data-id dos elementos
                    const itemId = evt.item.getAttribute('data-id');
                    const newIndex = evt.newIndex +3;

                    
                    // Atualize os data-id dos itens entre o data-id antigo e o novo
                    const items = document.querySelectorAll('.card');
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
        function updateOrder(){
            const items = document.querySelectorAll('.card');

            console.log(items);
        };
    </script>
</body>
</html>