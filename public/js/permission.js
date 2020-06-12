var BASE_URL = "http://localhost/PBO-Perizinan-Piket/";

$(document).ready(function() {

    $.blockUI.defaults.css = {};

    function startBlockingPermission() {
      $("#permission-section").block({
        message: $("#throbber")
      });
    }

    function stopBlockingPermission() {
      $("#permission-section").unblock();
    }

    $("#permission-form").change(function() {
      $("#update-permission-button").prop("disabled", false);
    });

    $("#permission-alert-close").click(function() {
      $("#permission-alert").fadeOut("fast");
    });

    function startLoadingButton() {
      $("#permission-loader").show();
      $("#permission-icon").hide();
      $("#permission-button").prop("disabled", true);
    }

    function stopLoadingButton() {
      $("#permission-loader").hide();
      $("#permission-icon").show();
      $("#permission-button").prop("disabled", false);
    }

    $("#permission-button").click(function() {
        $.ajax({
            url: BASE_URL + '/users/addPermission',
            type: 'POST',
            data: {
                index: $(this).data('index')
            },
            beforeSend: function() {
                startLoadingButton();
            },
            complete: function() {
                var timer;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    stopLoadingButton();
                }, 500);
            },
            success: function(data) {
                $('#permissionItems').html(" " + data);
            }
        });
    });

    $('#update-permission-button').click(function(e) {
        e.preventDefault();
        startBlockingPermission();
        $.ajax({
            url: BASE_URL + '/users/updatePermission',
            type: 'POST',
            data: $('#permission-form').serializeArray(),
            beforeSend: function() {
                startBlockingPermission();
            },
            complete: function() {
                var timer;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    stopBlockingPermission();
                    $("#update-permission-button").prop('disabled', true);
                    $('#permission-alert').fadeIn('fast');
                    $('#permission-message').html("Permission updated");
                }, 800);
            },
            success: function(data) {
                var updatedPermission = JSON.parse(data);                
                $('#permissionItems').html(" " + updatedPermission.totalItems);
            }
        });
    });

    $('.permission-delete-button').click(function(e) {
        var teacherRowId = $(this).data('index');
        e.preventDefault();
        startBlockingPermission();
        var data = { 'teacherRowId': teacherRowId };
        $.ajax({
            url: BASE_URL + '/users/deletePermission',
            type: 'POST',
            data: $('#permission-form').serialize() + '&' + $.param(data),
            beforeSend: function() {
                startBlockingPermission();
            },
            complete: function() {
                var timer;
                clearTimeout(timer);
                timer = setTimeout(function() {
                    stopBlockingPermission();
                    $('#teacherRowId_' + teacherRowId).hide('fast', function () { $('#teacherRowId_' + teacherRowId).remove(); });
                    $('#permission-alert').fadeIn('fast');
                    $('#permission-message').html("teacher removed from permission.");
                }, 800);
            },
            success: function(data) {                
                var updatedPermission = JSON.parse(data);
                if (updatedPermission.permissionEmpty == false) {                    
                    $('#permissionItems').html(" " + updatedPermission.totalItems);
                } else {
                    $('#permissionItems').html("0");
                    $("#permission-button").prop("disabled", true);
                    $('#permission-update-footer').fadeOut(800);
                }
            }
        });
    });

    $('a.back').click(function(){
        if(document.referrer.indexOf(window.location.hostname) > 1){
            parent.history.back();
            return false;
        } else {
            window.location.href = BASE_URL + "/teachers";
            return false;
        }
    });

    $('.carousel').carousel({
        interval: 3000
    })

})