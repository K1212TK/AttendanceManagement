$(function(){
    //ここにjQueryの処理を記述
    $(".punch_out").on('click', function () {
        if ($("input[name='punch_in_time']").val() == '') {
            console.log(1);
            alert("出勤時刻が打刻されていません。");
        }
        if ($("input[name='punch_out_time']").val() != '') {
            console.log(2);
            alert("既に退勤時刻を打刻しています。");
        }
    });
    $(".punch_in").on('click', function () {
        if ($("input[name='punch_in_time']").val() !== '') {
            console.log(3);
            alert("既に出勤時刻を打刻しています。");
        }
    });
});


