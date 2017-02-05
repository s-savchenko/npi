/**
 * Created by savchenko on 05.02.17.
 */

$('.start').on('click', function () {
    var conf = confirm('Are you sure you want to delete all data from DB and populate it from scratch?');
    if (conf) {
        $.ajax('site/launch-populating');
        window.setTimeout(updateLog, 1500);
    }
});

updateLog();
window.setInterval(updateLog, 10000);

function updateLog() {
    $.ajax('site/get-monthly-log').done(function (data) {
        if (data != '')
            data = '<pre>' + data + '</pre>';
        $('.result').html(data);
    });
}