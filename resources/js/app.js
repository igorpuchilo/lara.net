

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
