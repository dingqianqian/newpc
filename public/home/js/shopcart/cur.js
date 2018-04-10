$('.tjian').click(function () {
    var max = parseFloat($(this).attr('max')) > 99 ? 99 : max;
    var valu = $(this).parent().children('input').val(),
        a = parseFloat(valu) + 1;
    if (a > max) {
        $(this).parent().children('input').val(max);
    } else {
        $(this).parent().children('input').val(a);
    }
    var heji = (parseFloat($(this).parent().children('input').val()) * parseFloat($(this).parent().parent().find('em').text())).toFixed(2);
    $(this).parent().parent().find('.he').text(heji);
    if ($(this).parent().parent().find('.laj').prop('checked')) {
        var zong = 0;
        $('.lBu>label>input').each(function (m, n) {
            if ($(n).prop('checked')) {
                zong += parseFloat($(n).parent().parent().parent().find('.he').text());
            }
        });
        $('.lj,.rj').text(zong.toFixed(2));
    }
});
$('.bjian').click(function () {
    var min = parseFloat($(this).attr('min'));
    var valu = $(this).parent().children('input').val(),
        a = parseFloat(valu) - 1;
    if (a < min) {
        $(this).parent().children('input').val(min);
    } else {
        $(this).parent().children('input').val(a);
    }
    var heji = (parseFloat($(this).parent().children('input').val()) * parseFloat($(this).parent().parent().find('em').text())).toFixed(2);
    $(this).parent().parent().find('.he').text(heji);
    if ($(this).parent().parent().find('.laj').prop('checked')) {
        var zong = 0;
        $('.lBu>label>input').each(function (m, n) {
            if ($(n).prop('checked')) {
                zong += parseFloat($(n).parent().parent().parent().find('.he').text());
            }
        });
        $('.lj,.rj').text(zong.toFixed(2));
    }
});
//监听onkeyup事件
$('.mBu>input').keyup(function () {
    var max = parseFloat($(this).parent().children('.tjian').attr('max')) > 99 ? 99 : max,
        min = $(this).parent().children('.bjian').attr('min');
    var valu = parseFloat($(this).val());
    if (valu < min || isNaN(valu)) {
        $(this).val(min);
    } else if (valu > max) {
        $(this).val(max);
    } else {
        $(this).val(valu);
    }
    var heji = (parseFloat($(this).val()) * parseFloat($(this).parent().parent().find('em').text())).toFixed(2);
    $(this).parent().parent().find('.he').text(heji);
    if ($(this).parent().parent().find('.laj').prop('checked')) {
        var zong = 0;
        $('.lBu>input').each(function (m, n) {
            if ($(n).prop('checked')) {
                zong += parseFloat($(this).parent().parent().find('.he').text());
            }
        });
        $('.lj,.rj').text(zong.toFixed(2));
    }
});
//单选
$('.lBu>label').click(function () {
    var zong = num = 0;
    $('.lBu>label>input').each(function (m, n) {
        if ($(n).prop('checked')) {
            zong += parseFloat($(this).parent().parent().parent().find('.he').text());
        }
    });
    $('.lj,.rj').text(zong.toFixed(2));
    if ($(this).children('input').prop('checked')) {
        $('.lBu>label>input').each(function (k, v) {
            if (!$(v).prop('checked')) {
                num++;
            }
        })
    } else {
        num++;
    }
    if (num > 0) {
        $('#all').prop('checked', false);
    } else {
        $('#all').prop('checked', true);
    }
});
//全选
$('.tp').click(function () {
    var zong = 0;
    if ($(this).children('input').prop('checked')) {
        $('.lBu>label>input').each(function (j, o) {
            $(o).prop('checked', true);
            zong += parseFloat($(o).parent().parent().parent().find('.he').text());
        });
        $('.lj,.rj').text(zong.toFixed(2));
    } else {
        $('.lBu>label>input').each(function (j, o) {
            $(o).prop('checked', false);
        });
        $('.lj,.rj').text(zong.toFixed(2));
    }
});

