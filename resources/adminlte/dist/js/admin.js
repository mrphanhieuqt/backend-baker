$(document).ready(function () {
    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
    var itemEventFlg = false;
    $('input[type="checkbox"][name="select_all"].minimal').on('ifClicked', function () {
        itemEventFlg = false;
    });
    $('input[type="checkbox"][name="select_all"].minimal').on('ifChecked', function (e) {
        if(!itemEventFlg) {
            $('input[type="checkbox"].select_item.minimal').iCheck('check');
            $('.btn-delete-selected').removeClass('disabled');
        }
        itemEventFlg = false;
    });
    $('input[type="checkbox"][name="select_all"].minimal').on('ifUnchecked', function() {
        if(!itemEventFlg) {
            $('input[type="checkbox"].select_item.minimal').iCheck('uncheck');
            $('.btn-delete-selected').addClass('disabled');
        }
        itemEventFlg = false;
    });
    $('input[type="checkbox"].select_item.minimal').on('ifChecked', function() {
        itemEventFlg = true;
        var numOfItems = $('input[type="checkbox"].select_item.minimal').length;
        var checkedItems = $('input[type="checkbox"].select_item.minimal:checked').length;
        $('input[type="checkbox"][name="select_all"].minimal').iCheck((numOfItems-checkedItems <= 0) ? 'check' : 'uncheck');
        if(checkedItems > 0) {
            $('.btn-delete-selected').removeClass('disabled');
        } else {
            $('.btn-delete-selected').addClass('disabled');
        }
    });
    $('input[type="checkbox"].select_item.minimal').on('ifUnchecked', function() {
        itemEventFlg = true;
        var numOfItems = $('input[type="checkbox"].select_item.minimal').length;
        var checkedItems = $('input[type="checkbox"].select_item.minimal:checked').length;
        $('input[type="checkbox"][name="select_all"].minimal').iCheck((numOfItems-checkedItems <= 0) ? 'check' : 'uncheck');
        if(checkedItems > 0) {
            $('.btn-delete-selected').removeClass('disabled');
        } else {
            $('.btn-delete-selected').addClass('disabled');
        }
    });

    $('.btn-delete').confirm({
        icon: 'fa fa-warning',
        title: MSG.DELETE,
        content: MSG.DELETE_CONFIRM,
        type: 'orange',
        typeAnimated: true,
        buttons: {
            yes: {
                text: MSG.YES,
                btnClass: 'btn-red',
                action: function () {
                    location.href = this.$target.attr('href');
                }
            },
            no: {
                text: MSG.NO,
                action: function () {
                    // do nothing
                }
            }
        }
    });

    $('.btn-delete-selected').on('click', function () {
        if($(this).hasClass('disabled')) {
            return false;
        }
        var $target = $(this);

        $.confirm({
            icon: 'fa fa-warning',
            title: MSG.DELETE,
            content: MSG.DELETE_CONFIRM,
            type: 'orange',
            typeAnimated: true,
            buttons: {
                yes: {
                    text: MSG.YES,
                    btnClass: 'btn-red',
                    action: function () {
                        $target.closest('form').submit();
                    }
                },
                no: {
                    text: MSG.NO,
                    action: function () {
                        // do nothing
                    }
                }
            }
        });
    });
});