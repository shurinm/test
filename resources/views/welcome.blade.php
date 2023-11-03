<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Test</title>
    <style>
        body{
            display: flex;
            height: 60vh;
            width: 100vw;
            justify-content: center;
            align-items: center;
        }

        .wrapper{
            display: flex;
            padding: 45px;
            border-radius: 5px;
            border: 2px solid blueviolet;
            width: fit-content;
            justify-content: space-around;

        }

        button{
            color: #e5e7eb;
            background-color: blueviolet;
            border-radius: 10px;
            height: 50px;
            width: 200px;
            margin: 10px;

        }
        span{
            margin: 10px;

        }

        .bold{
            font-weight: 900;
        }
        #loader {
            display: none;
            border: 16px solid #f3f3f3;
            border-top: 16px solid blueviolet;
            border-radius: 50%;
            width: 120px;
            height: 120px;
            animation: spin 2s linear infinite;
            position: absolute;
            top: 5%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
<div class="wrapper">
<button onclick="handleClick()">импортировать пользователей</button>
<span>Всего:</span>
<span class="bold" id="all">@if(isset($countBefore)){{$countBefore}}@endif</span>
<span>Добавлено:</span>
<span class="bold" id="added">0</span>
<span>Обновлено:</span>
<span class="bold" id="updated">0</span></div>
<div id="loader"></div>

<script>
    function handleClick() {
        var loader = document.getElementById('loader');
        loader.style.display = 'block'; // Показываем лоадер

        fetch('{{ route("get_users") }}')
            .then(response => response.json())
            .then(arr => {
                document.querySelector('#all').innerHTML = arr['countAfter'];
                document.querySelector('#added').innerHTML = arr['addedCount'];
                document.querySelector('#updated').innerHTML = arr['updatedCount'];
                loader.style.display = 'none'; // Скрываем лоадер после загрузки данных
            })
            .catch(error => {
                console.log(error);
                loader.style.display = 'none'; // Скрываем лоадер в случае ошибки
            });
    }
</script>
</body>
</html>
