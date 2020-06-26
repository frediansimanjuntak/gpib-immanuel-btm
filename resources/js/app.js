/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});

import $ from 'jquery';
window.$ = window.jQuery = $;

import 'jquery-ui/ui/widgets/datepicker.js';


$(document).ready(function(){

    function change_activity_schedule(){
        var activity_id = $('#activity_id').val();
        var url = 'activity/' + activity_id + '/schedule/';    
        $.get(url, function(data) {
            var select = $('form select[name=activity_schedule_id]');    
            select.empty();    
            if (data.length > 0) {
                if (data.length == 1) {
                    select.append('<option value="'+ data[0].id +'" selected>' + data[0].name + '</option>');
                    change_ticket_registration();
                } else {
                    $.each(data,function(key, value) {
                        select.append('<option value="'+ value.id +'">' + value.name + '</option>');
                    });
                }
            }
            else {
                select.append('<option value="">-- Pilih Jadwal Ibadah --</option>');
            }
        });
    }

    function change_ticket_registration() {
        var activity_id = $('#activity_id').val();
        var activity_schedule_id = $('#activity_schedule_id').val();
        var url = 'ticket/'+ activity_id +'/' + activity_schedule_id;    
        $.get(url, function(data) {
            var select = $('form select[name=ticket_registration_id]');    
            select.empty();   
            if (data.length > 0) { 
                $.each(data,function(key, value) {
                    select.append('<option value=' + value.id + '>' + value.date + '</option>');
                });
            } else {
                select.append('<option value="">-- Pilih Tanggal Ibadah --</option>');
            }
        });
    }

    // Setup date only sunday endabled
    $(".datepicker").datepicker(
        {
        beforeShowDay: function (date) {

        if (date.getDay() == 0) {
            return [true, ''];
        }
        return [false, ''];
    }
    });

    $('#activity_id').change(function() {
        if ($(this).val() != '') {
            change_activity_schedule();
        } else {
            var select = $('form select[name=activity_schedule_id]'); 
            select.empty();
            select.append('<option value="">-- Pilih Jadwal Ibadah --</option>');
        }
    });

    $('#activity_schedule_id').change(function() {
        console.log($('#activity_id').val());
        if ($(this).val() != '') {
            change_ticket_registration();
        } else {
            var select = $('form select[name=ticket_registration_id]'); 
            select.empty();
            select.append('<option value="">-- Pilih Tanggal Ibadah --</option>');
        }
    });
});

