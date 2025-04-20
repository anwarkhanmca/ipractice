$(document).ready(function() {
    $('.tasksTabOuter li').click(function(){
        $('.tasksTabOuter li').removeClass('active');
        $(this).addClass('active');

        var goto_url    = $(this).find('a').data('goto_url');
        var tab_no      = $(this).find('a').data('tab_no');
        var staff_id    = $(this).find('a').data('staff_id');
        var service_id  = $("#service_id").val();

        
        $.ajax({
            url : '/jobs/ajax-tasks-table-data',
            type : 'POST',
            dataType : 'html',
            data : {'service_id':service_id, 'tab_no':tab_no, 'staff_id':staff_id},
            beforeSend : function(){
                $("#tasks-tab-content").html('');
            },
            success : function(resp){
                $("#tasks-tab-content").html(resp);
            }
        });



    });
    







});//end document



