<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Fila de Itens</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.14.0/Sortable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <style>
        @import url("https://fonts.googleapis.com/css?family=Lato:300");

        body {
            margin: 0;
            background-color: rgba(0, 0, 0, 0.2);
        }

        #app {
            width: 100vw;
            min-height: 95vh;
            display: flex;
            align-items: center;
            justify-content: center;

        }

        .app-container {
            padding: 50px;
            min-width: 80vw;
            height: 80vh;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
        }

        .app-header h5 {
            font-size: 2rem;
        }

        .app-content {
            margin-top: 250px;
            display: flex;
            flex-direction: row;
            gap: 50px;
        }

        .card-colum {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .card-begin {
            background-color: purple;
            color: white;
            display: flex;
            width: 25%;
            justify-content: center;
            align-items: center;
        }

        .card-body {
            width: 75%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card-for-swap {
            cursor: grab;
        }

        .card-for-swap::before {
            content: "";
            position: absolute;
            z-index: -1;
            top: -15px;
            right: -15px;
            background: #7952b3;
            height: 220px;
            width: 25px;
            border-radius: 32px;
        }

        .card {
            display: flex;
            flex-direction: row;
            background-color: white;
            box-shadow: rgba(0, 0, 0, 0.4) 0px 2px 4px, rgba(0, 0, 0, 0.3) 0px 7px 13px -3px, rgba(0, 0, 0, 0.2) 0px -3px 0px inset;
            min-height: 30px;
            width: 450px;
            border-radius: 10px;
            z-index: 0;
            filter: drop-shadow(0 5px 10px 0 #ffffff);
            /* position: relative; */
            transition: 0.6s ease-in;
            position: relative;
            overflow: hidden;
        }

        .card-no-swap::before {
            content: "";
            position: absolute;
            z-index: -1;
            top: -15px;
            right: -15px;
            background: #7952b3;
            height: 220px;
            width: 25px;
            border-radius: 32px;
            transform: scale(1);
            transform-origin: 50% 50%;
            transition: transform 0.25s ease-out;
        }

        .card-no-swap:hover::before {
            transition-delay: 0.2s;
            transform: scale(40);
        }

        .card-no-swap:hover {
            color: #ffffff;
        }

        .btn {
            border-radius: 10px;
            box-shadow: rgba(0, 0, 0, 0.17) 0px -23px 25px 0px inset, rgba(0, 0, 0, 0.15) 0px -36px 30px 0px inset, rgba(0, 0, 0, 0.1) 0px -79px 40px 0px inset, rgba(0, 0, 0, 0.06) 0px 2px 1px, rgba(0, 0, 0, 0.09) 0px 4px 2px, rgba(0, 0, 0, 0.09) 0px 8px 4px, rgba(0, 0, 0, 0.09) 0px 16px 8px, rgba(0, 0, 0, 0.09) 0px 32px 16px;
            min-height: 50px;
            min-width: 100px;
            cursor: pointer;
        }

        .btn-primary {
            background-color: rgba(0, 155, 255, 0.5);
            transition: background-color 0.5s;
        }

        .btn-primary:hover {
            background-color: rgba(0, 155, 255, 1);
        }

        .app-header {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 50px;
            width: 100%;
        }

        .box {
            position: absolute;
            top: 15%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 900px;
            height: 150px;
            background: #111845a6;
            box-sizing: border-box;
            overflow: hidden;
            box-shadow: 0 20px 50px rgb(23, 32, 90);
            border: 2px solid #2a3cad;
            color: white;
            padding: 20px;
        }

        .box:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.1);
            transition: 0.5s;
            pointer-events: none;
        }

        .box:hover:before {
            left: 0;
            transform: skewX(-5deg);
        }


        .box .content {
            position: absolute;
            top: 15px;
            left: 15px;
            right: 15px;
            bottom: 15px;
            border: 1px solid #f0a591;
            padding: 20px;
            text-align: center;
            box-shadow: 0 5px 10px rgba(9, 0, 0, 0.5);

        }

        .box span {
            position: absolute;
            display: block;
            box-sizing: border-box;
        }
        .eixo-x {
            width: 950px;
            height: 145px;
            top: 0;
            left: 0;
        }
        .eixo-y {
            width: 300px;
            height: 893px;
            top: auto;
            left: auto;
        }

        .box span:nth-child(1) {
            transform: rotate(0deg);
        }

        .box span:nth-child(2) {
            transform: rotate(90deg);
        }

        .box span:nth-child(3) {
            transform: rotate(180deg);
        }

        .box span:nth-child(4) {
            transform: rotate(270deg);
        }

        .box span:before {
            content: '';
            position: absolute;
            width: 100%;
            height: 2px;
            background: #50dfdb;
            animation: animate 4s linear infinite;
        }

        @keyframes animate {
            0% {
                transform: scaleX(0);
                transform-origin: left;
            }

            50% {
                transform: scaleX(1);
                transform-origin: left;
            }

            50.1% {
                transform: scaleX(1);
                transform-origin: right;

            }

            100% {
                transform: scaleX(0);
                transform-origin: right;

            }
        }
    </style>
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