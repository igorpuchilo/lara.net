// MY JS
//
//
// /**
//  * First we will load all of this project's JavaScript dependencies which
//  * includes Vue and other libraries. It is a great starting point when
//  * building robust, powerful web applications using Vue and Laravel.
//  */
//
// require('./bootstrap');
//
// window.Vue = require('vue');
//
// /**
//  * The following block of code may be used to automatically register your
//  * Vue components. It will recursively scan this directory for the Vue
//  * components and automatically register them with their "basename".
//  *
//  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
//  */
//
// // const files = require.context('./', true, /\.vue$/i);
// // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
//
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
//
// /**
//  * Next, we will create a fresh Vue application instance and attach it to
//  * the page. Then, you may begin adding components to this application
//  * or customize the JavaScript scaffolding to fit your unique needs.
//  */
//
// const app = new Vue({
//     el: '#app',
// });
//
//
//
// Delete order confirm
$('.delete').click(function () {
    var res = confirm('Are u really want delete this item?');
    if (!res) return false;
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
//Search
var route = "http://lara.net/admin/autocomplete";
$('#search').typeahead({
    source: function (term, process) {
        return $.get(route, {term: term}, function (data) {
            return process(data);
        });
    },
    minLength: 1,
    items: 5,
    delay: 400,
    autoSelect: false,

});