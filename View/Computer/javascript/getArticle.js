function getArticle (genres, success, fail) {
    if (typeof(Storage)) {
        if (jQuery.isArray(genres)) {
            for (var genre of genres) {
                sendMessage(
                    genre,
                    false,
                    function (data, genre) {
                        if (data) {
                            var arr = [];
                            arr.push(data);
                            localStorage[genre] = JSON.stringify(arr);
                        }
                        else {
                            if(fail)fail();
                        }
                    }
                );
            }
        }
        else {
            var arr = JSON.parse(localStorage[genres]);
            sendMessage(
                genres,
                arr,
                function (data, genre, arr) {
                    if (data) {
                        if (genre in localStorage) {
                            arr.push(data);
                            localStorage[genres] = JSON.stringify(arr);
                            if(success)success();
                        }
                    }
                    else {
                        if(fail)fail();
                    }
                }
            );
        }
    }
}

function sendMessage (genre, cursor, callback) {
    if (jQuery.isArray(cursor)) {
        var childArr = cursor[cursor.length - 1];
        cursor = childArr[childArr.length - 1].aid;
    }
    else {
        cursor = '';
    }
    jQuery.post(
        "http://127.0.0.1:8080/Controller/Recommend/featuredGoods.php",
        {
            "genre": genre,
            'cursor': cursor
        },
        function (data) {
            if(callback)callback(data, genre, cursor);
        },
        'json'
    );
}
