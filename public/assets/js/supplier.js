$(document).ready(function() {
    $("#form").validate({
	rules: {
	    // other rules
	},
	errorPlacement: function(error, element) {
	    if ($("#error").text() != "1つ以上選択して下さい。") {
		error.appendTo("#error");
	    }
	}
    });

    $('[name^="supplier"]').each(function() {
	let nameAttr = $(this).attr('name');
	let indexMatch = nameAttr.match(/\d+/);
	if (indexMatch) {
            let index = indexMatch[0];
            $(this).rules('add', {
		require_from_group: [1, $(`[class^="group${index}"]`)],
		messages: {
                    require_from_group: "1つ以上選択して下さい。"
		}
            });
	}
    });
});


$(function() {
    $(document).on('click', '.copy_clipboard', function() {
	var copy_id = $(this).attr('id');
	var copy_cnt = copy_id.match(/\[(.+)\]/)[1];
	var copy_cnt2 = Number(copy_cnt) - 1;
	var copy_txt = $('#memo\\[' + copy_cnt2 + '\\]').val();
	$('#memo\\[' + copy_cnt + '\\]').val(copy_txt);
	return false;
    });
});

$(function() {
    // 1. 「全選択」する
    $(document).on('click', '.allcheck', function() {
	var check_id = $(this).attr('class');
	var check_cnt = check_id.match(/\[(.+)\]/)[1];
	$('.sup\\[' + check_cnt + '\\]').prop('checked', this.checked);
    });

    // 2. 「全選択」以外のチェックボックスがクリックされたら、
    $(document).on('click', '.allcheck', function() {
	var check_id = $(this).attr('class');
	var check_cnt = check_id.match(/\[(.+)\]/)[1];
	if ($('.sup\\[' + check_cnt + '\\]:checked').length == $('.sup\\[' + check_cnt + '\\]:input').length) {
	    // 全てのチェックボックスにチェックが入っていたら、「全選択」 = checked
	    $('.sup\\[' + check_cnt + '\\]').prop('checked', true);
	} else {
	    // 1つでもチェックが入っていたら、「全選択」 = checked
	    $('.sup\\[' + check_cnt + '\\]').prop('checked', false);
	}

    });
});

$(function() {
    $('#kaijyo').click(function() {
	$('input').prop('disabled', false);
	return false;
    });
});
