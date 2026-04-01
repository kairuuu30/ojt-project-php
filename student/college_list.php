<?php 
session_start();
include("../server/connection.php");
include("../auth/session.php");

?>

<!DOCTYPE html>
<html lang="en">

    <?php
        $pageTitle = "College List";
        include '../components/head.php';
    ?>

    <body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include '../components/sidebar.php'; ?> 
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                     <?php include '../components/topbar.php'; ?> 

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                    <div class="container-fluid">

                        <!-- Page Heading -->
                        <h1 class="h3 mb-2 text-gray-800">Colleges List</h1>
                        <p class="mb-4">Add, Edit, and Delete available colleges in university.</p>
                        
                        <!-- DataTables College -->
                            <div class="card shadow mb-4">   
                                <div class="card-header py-3">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createCollegeModal" >Add a College</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="fetching_college_table" style="font-size: 13px !important;">
                                            <thead>
                                                <tr>
                                                    <th>College Name</th>
                                                    <th>College Code</th>
                                                    <th>Status</th>
                                                    <th>Created At</th>
                                                    <th>Updated At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <!-- DataTables College -->

                    </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        <!-- College Modals -->
            <!-- Create Modal -->
                <div class="modal fade" id="createCollegeModal" tabindex="-1" role="dialog" aria-labelledby="createLabel" 
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="createLabel">Add a College</h2>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <form action="../process/create_college.php" method="POST" id="createCollegeValidation">
                                <div class="modal-body">
                                    <div class = "container">
                                        <div class="row mb-3">
                                            <label for="college" class="form-label">College Name</label>
                                            <input type="text" name="college" class="form-control" id="college" placeholder="Name of the College" required>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="college_code" class="form-label">College Code</label>
                                            <input type="text" style="text-transform: uppercase;" name="college_code" class="form-control" id="college_code" placeholder="Three to Five Letter Code of the College" required>
                                        </div>
                                    </div>     
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="create_user" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!-- Create Modal -->             

            <!-- Edit Modal -->
                <div class="modal fade" id="editCollegeModal" tabindex="-1" role="dialog" aria-labelledby="editLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="editLabel">Edit College</h2>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div> 
                            <form action="../process/edit_college.php" method="POST" id="editCollegeValidation">
                                <div class="modal-body">
                                    <div class = "container">
                                        <div class="row mb-3">
                                            <input type="hidden" id='update_college_id' name="college_id">
                                            <label for="college" class="form-label">College Name</label>
                                            <input type="text" id='update_college' name="college" class="form-control" required >
                                        </div>
                                        <div class="row mb-3">
                                            <label for="college_code" class="form-label">College Code</label>
                                            <input type="text" style="text-transform: uppercase;" id='update_college_code' name="college_code" class="form-control" required>
                                        </div>
                                    </div>     
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!-- Edit Modal -->

            <!-- Disable Modal -->
                <div class="modal fade" id="disableCollegeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="disable_name" >Are you sure you want disable this College?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div>
                            <form action="../process/disable_college.php" method="POST" id="disableCollegeValidation">
                                <div class="modal-body">
                                    <input type="hidden" id='disable_college_id' name="college_id">
                                    Courses under this College will also be disabled. Select "Disable" below if you are sure you want to disable the college.
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button type="submit"  class="btn btn-danger">Disable</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            <!-- Disable Modal -->

            <!-- Enable Modal -->
                <div class="modal fade" id="enableCollegeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="enable_name" >Are you sure you want enable this College?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div>
                            <form action="../process/enable_college.php" method="POST" id="enableCollegeValidation">
                                <div class="modal-body">
                                    <input type="hidden" id='enable_college_id' name="college_id">
                                    Courses under this College will also be enabled. Select "Enable" below if you are sure you want to enable the college.
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button type="submit"  class="btn btn-success">Enable</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>  
            <!-- Enable Modal -->


        <!-- College Modals -->

            <!-- Footer -->
                <footer class="sticky-footer bg-white">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; Your Website 2020</span>
                        </div>
                    </div>
                </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>



    <?php include '../assets/scripts.php'; ?>

    <script>
        $(document).ready(function () {

        //Colleges Functions
            //Displaying of colleges
                $('#fetching_college_table').DataTable({
                    scrollX: true,
                    processing: true,
                    destroy: true,
                    responsive: true,
                    autoWidth: false, // Prevent DataTables from setting column widths
                    order: [[0, 'desc']],
                    ajax: {
                        url: 'json_colleges.php',
                        dataSrc: ""
                    },
                    columns: 
                    [   
                        {"data" :   "college"},
                        {"data" :   "college_code"},
                        {"data" :   "status"},
                        {"data" :   "created_at"},
                        {"data" :   "updated_at"},
                        {"data" :   "action"}
                    ]
                });
            //Displaying of colleges

            // Create College
                $('#createCollegeValidation').validate({
                    rules: {
                        college: {required: true,},
                        college_code: {required: true,}
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (typeof response === 'string') {
                                    var res = JSON.parse(response);
                                } else {
                                    var res = response; // If it's already an object
                                }

                                if (res.status === 'success') {
                                    $('#createCollegeModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_college_table').DataTable().ajax.reload();
                                        $(form)[0].reset(); // Reset form if applicable
                                    });
                                } else if (res.status === 'error') {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: res.message,
                                        icon: 'error',
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Error Occurred Please Try Again',
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = 'An error occurred. Please try again later.';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                });
                            }
                        });
                            
                    }
                });
            // Create College

            // Edit College
                $('#fetching_college_table').on('click', '.edit_college', function(e) {
                    e.preventDefault();
                    var college_id = $(this).data('college_id');
                    console.log(college_id);


                    $.ajax({  
                        url: "get_college.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            college_id : college_id,

                        },
                        dataType: "json",
                        success:function(response) {  
                            console.log(response);
                            $('#update_college_id').val(response.id);
                            $('#update_college').val(response.college);
                            $('#update_college_code').val(response.college_code);
                            $('#editCollegeModal').modal('show');
                        }
                    }); 
                });

                $('#editCollegeValidation').validate({
                        rules: {
                            id: {
                                required: true,
                            }
                        },
                        errorElement: 'span',
                        errorPlacement: function(error, element) {
                            error.addClass('invalid-feedback');
                            element.closest('.form-group').append(error);
                        },
                        highlight: function(element, errorClass, validClass) {
                            $(element).addClass('is-invalid');
                        },
                        unhighlight: function(element, errorClass, validClass) {
                            $(element).removeClass('is-invalid');
                        },
                        submitHandler: function(form) {
                            $.ajax({
                                url: form.action,
                                type: form.method,
                                data: $(form).serialize(),
                                success: function(response) {
                                    if (typeof response === 'string') {
                                        var res = JSON.parse(response);
                                    } else {
                                        var res = response; // If it's already an object
                                    }

                                    if (res.status === 'success') {
                                        $('#editCollegeModal').modal('hide');
                                        Swal.fire({
                                            title: 'Success!',
                                            text: res.message,
                                            icon: 'success',
                                        }).then(() => {
                                            $('#fetching_college_table').DataTable().ajax.reload();
                                            $(form)[0].reset(); // Reset form if applicable
                                        });
                                    } else if (res.status === 'error') {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: res.message,
                                            icon: 'error',
                                        });
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'Error Occurred Please Try Again',
                                            icon: 'error',
                                        });
                                    }
                                },
                                error: function(xhr, status, error) {
                                    var errorMessage = 'An error occurred. Please try again later.';
                                    if (xhr.responseJSON && xhr.responseJSON.error) {
                                        errorMessage = xhr.responseJSON.error;
                                    }
                                    Swal.fire({
                                        title: 'Error!',
                                        text: errorMessage,
                                        icon: 'error',
                                    });
                                }
                            });
                                
                        }
                    });
            // Edit College

            // Disable College 
                $('#fetching_college_table').on('click', '.disable_college', function(e) {
                    e.preventDefault();
                    var college_id = $(this).data('college_id');
                    console.log(college_id);


                    $.ajax({  
                        url: "get_college.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            college_id : college_id,
                            
                        },
                        dataType: "json",
                        success:function(response) {  
                            console.log(response);
                            // console.log(response.id);
                            // // console.log(response.name);
                            $('#disable_college_id').val(response.id);
                            $('#disableCollegeModal').modal('show');
                        }
                    }); 
                });

        
                $('#disableCollegeValidation').validate({
                    rules: {
                        id: {
                            required: true,
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (typeof response === 'string') {
                                    var res = JSON.parse(response);
                                } else {
                                    var res = response; // If it's already an object
                                }

                                if (res.status === 'success') {
                                    $('#disableCollegeModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_college_table').DataTable().ajax.reload();
                                        $(form)[0].reset(); // Reset form if applicable
                                    });
                                } else if (res.status === 'error') {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: res.message,
                                        icon: 'error',
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Error Occurred Please Try Again',
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = 'An error occurred. Please try again later.';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                });
                            }
                        });
                            
                    }
                });
            // Disable College

            // Enable College 
                $('#fetching_college_table').on('click', '.enable_college', function(e) {
                    e.preventDefault();
                    var college_id = $(this).data('college_id');
                    console.log(college_id);


                    $.ajax({  
                        url: "get_college.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            college_id : college_id,
                            
                        },
                        dataType: "json",
                        success:function(response) {  
                            console.log(response);
                            // console.log(response.id);
                            // // console.log(response.name);
                            $('#enable_college_id').val(response.id);
                            $('#enableCollegeModal').modal('show');
                        }
                    }); 
                });

        
                $('#enableCollegeValidation').validate({
                    rules: {
                        id: {
                            required: true,
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    },
                    submitHandler: function(form) {
                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: $(form).serialize(),
                            success: function(response) {
                                if (typeof response === 'string') {
                                    var res = JSON.parse(response);
                                } else {
                                    var res = response; // If it's already an object
                                }

                                if (res.status === 'success') {
                                    $('#enableCollegeModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_college_table').DataTable().ajax.reload();
                                        $(form)[0].reset(); // Reset form if applicable
                                    });
                                } else if (res.status === 'error') {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: res.message,
                                        icon: 'error',
                                    });
                                } else {
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Error Occurred Please Try Again',
                                        icon: 'error',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                var errorMessage = 'An error occurred. Please try again later.';
                                if (xhr.responseJSON && xhr.responseJSON.error) {
                                    errorMessage = xhr.responseJSON.error;
                                }
                                Swal.fire({
                                    title: 'Error!',
                                    text: errorMessage,
                                    icon: 'error',
                                });
                            }
                        });
                            
                    }
                });
            // Enable College
        //Colleges Functions

            // Validation
                // $('#editUserValidation').validate({
                //     rules: {
                //         id: {
                //             required: true,
                //         }
                //     },
                //     errorElement: 'span',
                //     errorPlacement: function(error, element) {
                //         error.addClass('invalid-feedback');
                //         element.closest('.form-group').append(error);
                //     },
                //     highlight: function(element, errorClass, validClass) {
                //         $(element).addClass('is-invalid');
                //     },
                //     unhighlight: function(element, errorClass, validClass) {
                //         $(element).removeClass('is-invalid');
                //     },
                //     submitHandler: function(form) {
                //         Swal.fire({
                //             title: 'Confirm Deletion',
                //             text: 'Do you want to submit a request for the selected municipality and barangay?',
                //             icon: 'question',
                //             showCancelButton: true,
                //             confirmButtonText: 'Submit',
                //             cancelButtonText: 'Cancel'
                //         }).then((result) => {
                //             if (result.isConfirmed) {
                //                 $.ajax({
                //                     url: form.action,
                //                     type: form.method,
                //                     data: $(form).serialize(),
                //                     success: function(response) {
                //                         if (typeof response === 'string') {
                //                             var res = JSON.parse(response);
                //                         } else {
                //                             var res = response; // If it's already an object
                //                         }

                //                         if (res.status === 'success') {
                //                             $('#deleteModal').modal('hide');
                //                             Swal.fire({
                //                                 title: 'Success!',
                //                                 text: res.message,
                //                                 icon: 'success',
                //                             }).then(() => {
                //                                 $('#fetching_data_table').DataTable().ajax.reload();
                //                                 $(form)[0].reset(); // Reset form if applicable
                //                             });
                //                         } else if (res.status === 'error') {
                //                             Swal.fire({
                //                                 title: 'Error!',
                //                                 text: res.message,
                //                                 icon: 'error',
                //                             });
                //                         } else {
                //                             Swal.fire({
                //                                 title: 'Error!',
                //                                 text: 'Error Occurred Please Try Again',
                //                                 icon: 'error',
                //                             });
                //                         }
                //                     },
                //                     error: function(xhr, status, error) {
                //                         var errorMessage = 'An error occurred. Please try again later.';
                //                         if (xhr.responseJSON && xhr.responseJSON.error) {
                //                             errorMessage = xhr.responseJSON.error;
                //                         }
                //                         Swal.fire({
                //                             title: 'Error!',
                //                             text: errorMessage,
                //                             icon: 'error',
                //                         });
                //                     }
                //                 });
                //             }
                //         });
                //     }
                // });
            // Validation
            
        });           
    </script>

    </body>

</html>
