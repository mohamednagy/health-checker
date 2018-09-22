$(document).ready(function () {
    var snippet = document.getElementById('snippet');
    //get all checkers
    $.ajax({
        'method': 'get',
        'url': '/health-check/checkers',
        'type': 'json',
        'async': false,
        'success': function (response) {
            var checkers = response.data;

            $.forEach(checkers, function (checker) {
                loadChecker(checker);
            });
        }
    });

    var loadChecker = function (checker) {
        $(snippet).attr('id', checker);
        $(snippet).find('#name').html(checker);
        $('.checkers-container').append(snippet);
        $.ajax({
            'method': 'get',
            'url': '/health-check/' + checker,
            'type': 'json',
            'async': true,
            'success': function (response) {
                var result = response.data;
                var level = result.type;
                var message = result.message;
                var trace = result.trace;

                $('#'+checker).find('#alert').addClass('alert-'+ level);
                $('#'+checker).find('#message').html(message);
            }
        });
    }
});
