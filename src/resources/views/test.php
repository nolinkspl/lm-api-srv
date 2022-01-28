<?php

    echo 'test-load';
    ?>
<br><br>
<button class="js-start">Start test</button>
<button class="js-stop">Stop test</button>
<button class="js-refresh">Refresh</button>
<br><br>
<label>Counter: <input disabled class="js-counter" value="0"></label>
<br><br>
<table class="js-table">
    <thead>
        <tr>
            <th>Code</th>
            <th>Val</th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>
<br>
<button class="js-refresh-table">Refresh table</button>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script>
    const codes = [

    ];

    let counter = 0;
    let interval;

    setInterval(
        function() {
            $('.js-counter').val(counter);
        }, 1000
    )

    setInterval(getStats, 3000);

    $('.js-start').on('click', function () {
        interval = setInterval(
            function () {
                $.post('/', {code: 'ru'})
                    .success(function () {
                        counter++;
                    }).error(function(jqXHR, status, e) {
                        if (status === "timeout") {
                            console.log("Время ожидания ответа истекло!");
                        } else {
                            console.log(status); // Другая ошибка
                        }
                    });
            },
            20
        );
    });

    $('.js-stop').on('click', function () {
        clearInterval(interval);
    });

    $('.js-refresh').on('click', function () {
        counter = 0;
        $('.js-counter').val(counter);
    });

    $('.js-refresh-table').on('click', getStats);

    // setInterval(
    //     function () {
    //         getStats();
    //     },
    //     3000
    // );

    function getStats() {
        $.get('/stats').done(function (response) {
            let $tbody = $('.js-table tbody');
            $tbody.empty();

            $.each(response, function(i, val) {
                let $row = $(`<tr><td>${i}</td><td>${val}</td></tr>`);
                $tbody.append($row);
            });
        });
    }
</script>
