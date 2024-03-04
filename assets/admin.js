/*
 * Welcome to your admin's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/admin/admin.scss';
import $ from 'jquery';
import 'bootstrap';
import bsCustomFileInput from 'bs-custom-file-input';

bsCustomFileInput.init();


// or you can include specific pieces
// require('bootstrap/js/dist/tooltip');
// require('bootstrap/js/dist/popover');

$(function() {
console.log('admin');
let dataTable = $('#dataTable');
dataTable.DataTable();
console.log(dataTable);

});