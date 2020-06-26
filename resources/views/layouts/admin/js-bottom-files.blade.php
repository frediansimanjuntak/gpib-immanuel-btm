<!-- Theme Base, Components and Settings -->
<script src="{{asset('admin/js/theme.js')}}"></script>
		
<!-- Theme Custom -->
<script src="{{asset('admin/js/theme.custom.js')}}"></script>

<!-- Theme Initialization Files -->
<script src="{{asset('admin/js/theme.init.js')}}"></script>
<script src="{{asset('admin/vendor/summernote/summernote.js')}}"></script>


<!-- Examples -->
<script src="{{asset('admin/js/dashboard/examples.dashboard.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('select[name=activity_id]').change(function() {
            if ($(this).val() != '') {
                var base_url = window.location.origin;
                var url = base_url + '/admin/ticket_registrations/activity/' + $(this).val() + '/schedule/';    
                $.get(url, function(data) {
                    var select = $('form select[name= activity_schedule_id]');    
                    select.empty();
                    if (data.length > 0) {
                        $.each(data,function(key, value) {
                            select.append('<option value=' + value.id + '>' + value.name + '</option>');
                        });
                    } else {
                        select.append('<option value="">-- Pilih Jadwal Ibadah --</option>');
                    }
                });
            } else {
                var select = $('form select[name= activity_schedule_id]'); 
                select.empty();
                select.append('<option value="">-- Pilih Jadwal Ibadah --</option>');
            }
        });
    });
</script>