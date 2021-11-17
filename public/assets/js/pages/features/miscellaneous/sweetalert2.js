"use strict";

// Class definition
var KTSweetAlert2Demo = function () {
    var _init = function () {
        // Sweetalert Demo 1
        $('#kt_sweetalert_demo_1').click(function (e) {
            Swal.fire('Good job!');
        });

        // Sweetalert Demo 2
        $('#kt_sweetalert_demo_2').click(function (e) {
            Swal.fire("Here's the title!", "...and here's the text!");
        });

        // Sweetalert Demo 3
        $('#kt_sweetalert_demo_3_1').click(function (e) {
            Swal.fire("Good job!", "You clicked the button!", "warning");
        });

        $('#kt_sweetalert_demo_3_2').click(function (e) {
            Swal.fire("Good job!", "You clicked the button!", "error");
        });

        $('#kt_sweetalert_demo_3_3').click(function (e) {
            Swal.fire("Good job!", "You clicked the button!", "success");
        });

        $('#kt_sweetalert_demo_3_4').click(function (e) {
            Swal.fire("Good job!", "You clicked the button!", "info");
        });

        $('#kt_sweetalert_demo_3_5').click(function (e) {
            Swal.fire("Good job!", "You clicked the button!", "question");
        });

        // Sweetalert Demo 4
        $("#kt_sweetalert_demo_4").click(function (e) {
            Swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "Confirm me!",
                customClass: {
                    confirmButton: "btn btn-primary"
                }
            });
        });

        // Sweetalert Demo 5
        $("#kt_sweetalert_demo_5").click(function (e) {
            Swal.fire({
                title: "Good job!",
                text: "You clicked the button!",
                icon: "success",
                buttonsStyling: false,
                confirmButtonText: "<i class='la la-headphones'></i> I am game!",
                showCancelButton: true,
                cancelButtonText: "<i class='la la-thumbs-down'></i> No, thanks",
                customClass: {
                    confirmButton: "btn btn-danger",
                    cancelButton: "btn btn-default"
                }
            });
        });

        $('#kt_sweetalert_demo_6').click(function (e) {
            Swal.fire({
                position: 'top-right',
                icon: 'success',
                title: 'Your work has been saved',
                showConfirmButton: false,
                timer: 1500
            });
        });

        $('#kt_sweetalert_demo_7').click(function (e) {
            Swal.fire({
                title: 'jQuery HTML example',
                showClass: {
                    popup: 'animate__animated animate__wobble'
                },
                hideClass: {
                    popup: 'animate__animated animate__swing'
                }
            });
        });

        $(document).ready( function() {
            $('.active_form').on('click',function(e){

                if(confirm("Are you sure you want to active this background ?")){
                    $(".active_form").attr("href", "query.php?ACTION=delete&ID='1'");
                }
                else{
                    return false;
                }
            });
        });

        $(document).ready( function() {
            $('.delete_button').on('click',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    iconColor: '#f64e60',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    confirmButtonColor: '#3699FF',
                    cancelButtonText: 'No, cancel!',
                    cancelButtonColor: '#f64e60',
                    backdrop: `rgba(0,0,0,0.6)
                               url("https://lh3.googleusercontent.com/proxy/LESTgMOpyCOcM-Fkd6YgzKYz1aMX-AygTUpLeNwQK-lpoZ9AdrlQ0WK0NjLywCj44xKi2Ky0QMFgC0dm_HlvmfikEWnAq44")
                               right bottom
                               no-repeat`
                }).then(function (result) {

                    if (result.value) {
                        $('.delete'+id).submit();
                    }
                });
            });
        });


        $(document).ready( function() {
            $('.confirm_button').on('click',function(e){
                e.preventDefault();
                var id = $(this).data('id');
                console.log(id);
                Swal.fire({
                    title: 'Are you sure?',
                    // text: "You won't be able to revert this!",
                    // timer: 10000,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    confirmButtonColor: '#3699FF',
                    cancelButtonText: 'No, cancel!',
                    cancelButtonColor: '#f64e60',
                    backdrop: `rgba(0,0,0,0.6)
                               url("https://lh3.googleusercontent.com/proxy/LESTgMOpyCOcM-Fkd6YgzKYz1aMX-AygTUpLeNwQK-lpoZ9AdrlQ0WK0NjLywCj44xKi2Ky0QMFgC0dm_HlvmfikEWnAq44")
                               right bottom
                               no-repeat`
                }).then(function (result) {
                    if (result.value) {
                        $('.confirm'+id).submit();
                    }
                });
            });
        });

        $(document).ready( function() {
            $('.delete_form').on('click',function(e){

                if(confirm("Are you sure you want to delete this?")){
                    $(".delete_form").attr("href", "query.php?ACTION=delete&ID='1'");
                }
                else{
                    return false;
                }
            });
        });
        $(document).ready( function() {
            $('.push_form').on('click',function(e){

                if(confirm("Are you sure you want to push notification to all customer ?")){
                    $(".push_form").attr("href", "query.php?ACTION=delete&ID='1'");
                }
                else{
                    return false;
                }
            });
        });
        $(document).ready( function() {
            $('.reset_form').on('click',function(e){

                if(confirm("Are you sure you want to reset draw win?")){
                    $(".push_form").attr("href", "query.php?ACTION=delete&ID='1'");
                }
                else{
                    return false;
                }
            });
        });



        // $(window).bind('resize', function() {
        //     location.reload();
        // });

        $('#kt_sweetalert_demo_9').click(function (e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then(function (result) {
                if (result.value) {
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                    // result.dismiss can be 'cancel', 'overlay',
                    // 'close', and 'timer'
                } else if (result.dismiss === 'cancel') {
                    Swal.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            });
        });

        $('#kt_sweetalert_demo_10').click(function (e) {
            Swal.fire({
                title: 'Sweet!',
                text: 'Modal with a custom image.',
                imageUrl: 'https://unsplash.it/400/200',
                imageWidth: 400,
                imageHeight: 200,
                imageAlt: 'Custom image',
                animation: false
            });
        });

        // $(document).ready( function() {
        //     $('.push_form').on('click',function(e){
        //         e.preventDefault()
        //         Swal.fire({
        //             title: 'Are you sure?',
        //             text: "You want to push notification to all customer!",
        //             icon: 'info',
        //             showCancelButton: true,
        //             confirmButtonText: 'Yes'
        //
        //         }).then(function (result) {
        //             if (result.value) {
        //                 $('.push_form').submit();
        //             }
        //         });
        //     });
        // });

        $('#kt_sweetalert_demo_11').click(function (e) {
            Swal.fire({
                title: 'Auto close alert!',
                text: 'I will close in 5 seconds.',
                timer: 5000,
                onOpen: function () {
                    Swal.showLoading()
                }
            }).then(function (result) {
                if (result.dismiss === 'timer') {
                    console.log('I was closed by the timer')
                }
            })
        });
    };

    return {
        // Init
        init: function () {
            _init();
        },
    };
}();

// Class Initialization
jQuery(document).ready(function () {
    KTSweetAlert2Demo.init();
});
