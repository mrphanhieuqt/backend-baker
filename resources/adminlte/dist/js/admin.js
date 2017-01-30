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
        }
        itemEventFlg = false;
    });
    $('input[type="checkbox"][name="select_all"].minimal').on('ifUnchecked', function() {
        if(!itemEventFlg) {
            $('input[type="checkbox"].select_item.minimal').iCheck('uncheck');
        }
        itemEventFlg = false;
    });
    $('input[type="checkbox"].select_item.minimal').on('ifChecked', function() {
        itemEventFlg = true;
        var numOfItems = $('input[type="checkbox"].select_item.minimal').length;
        var checkedItems = $('input[type="checkbox"].select_item.minimal:checked').length;
        $('input[type="checkbox"][name="select_all"].minimal').iCheck((numOfItems-checkedItems <= 0) ? 'check' : 'uncheck');
    });
    $('input[type="checkbox"].select_item.minimal').on('ifUnchecked', function() {
        itemEventFlg = true;
        var numOfItems = $('input[type="checkbox"].select_item.minimal').length;
        var checkedItems = $('input[type="checkbox"].select_item.minimal:checked').length;
        $('input[type="checkbox"][name="select_all"].minimal').iCheck((numOfItems-checkedItems <= 0) ? 'check' : 'uncheck');
    });
});

function doDelete(_this) {
    if($(_this).hasClass('disabled')) {
        return false;
    }
    $(_this).closest('form').submit();
}