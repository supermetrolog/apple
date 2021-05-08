function getApples() {
    let url = "http://backend.apple/apple/generate";
    $.get(
        url,
        includeApplesList
    );
}

function dropApple(btn) {
    let url = "http://backend.apple/apple/drop";
    let _csrf = $('meta[name="csrf-token"]').attr("content");
    let id = $(btn).attr('data-apple-id');
    let data = {
        _csrf: _csrf,
        id: id,
    };
    $.post(
        url,
        data,
        includeApplesList
    );
}

function validateEatenPercent(eatenPercent) {
    if (eatenPercent == '') {
        alert('Заполните поле!');
        return false;
    }
    if (!parseInt(eatenPercent)) {
        alert('Допустимо только числовое значение!');
        return false;
    }
    return true;
}

function eatApple(btn) {
    let url = "http://backend.apple/apple/eat";
    let _csrf = $('meta[name="csrf-token"]').attr("content");
    let id = $(btn).attr('data-apple-id');
    let eatenPercent = $(btn).siblings('.eaten-percent').val();
    if (!validateEatenPercent(eatenPercent)) {
        return;
    }
    let data = {
        _csrf: _csrf,
        id,
        eaten: eatenPercent
    };
    $.post(
        url,
        data,
        includeApplesList
    );
}

function isJson(data) {
    if (typeof data !== "string") {
        return false;
    }
    try {
        JSON.parse(data);
        return true;
    } catch (error) {
        return false;
    }
}

function includeApplesList(data) {
    if (isJson(data)) {
        let json = JSON.parse(data)
        alert(json.error);
        return;
    }
    $('.main-apple').html(data);
}
$(document).ready(function() {
    $(document).on('click', '#generateApples', function() {
        getApples();
    });
    $(document).on('click', '.drop-apple', function() {
        dropApple(this);
    })
    $(document).on('click', '.eat-apple', function() {
        eatApple(this);
    })
})