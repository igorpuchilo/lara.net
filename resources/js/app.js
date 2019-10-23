// MY JS

// Delete order confirm
$('.delete').click(function () {
    var res = confirm('Are u really want delete this item?');
    if (!res) return false;
});
// Edit order confirm
$('.editorder').click(function () {
    var res = confirm('You can change only comments');
    return false;
});
// Delete from DB order confirm
$('.deletedb').click(function () {
    var res = confirm('Are u really want delete this item from database?');
    if (!res){
        return false;
    }
});

//Menu Active

$('.sidebar-menu a').each(function () {
   var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
   var link = this.href;
   if(link === location){
       $(this).parent().addClass('active');
       $(this).closest('.treeview').addClass('active');
   }
});

//KCEditor
$('#editor1').ckeditor();

//Filter Reset
$('#reset-filter').click(function () {
   $('#filter input[type=radio]').prop('checked', false);
   return false;
});
//select category
$('#add').on('submit',function () {
    if(!isNum($('#parent_id').val())){
        alert('Choose category');
        return false;
    }
});
//Is number function
function isNum(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}
