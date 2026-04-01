<?php 
session_start();
include("../server/connection.php");
include("../auth/session.php");

?>

<!DOCTYPE html>
<html lang="en">

    <?php
        $pageTitle = "Course List";
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
                        <h1 class="h3 mb-2 text-gray-800">Courses List</h1>
                        <p class="mb-4">Add, Edit, and Delete available courses in university.</p>

                        <!-- DataTables Course -->
                            <div class="card shadow mb-4">   
                                <div class="card-header py-3">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createCourseModal" >Add a Course</button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="fetching_course_table" style="font-size: 13px !important;">
                                            <thead>
                                                <tr>
                                                    <th>Course Name</th>
                                                    <th>Course Code</th>
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
                        <!-- DataTables Course -->
                    </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

        <!-- Course Modals -->
            <!-- Create Modal -->
                <div class="modal fade" id="createCourseModal" tabindex="-1" role="dialog" aria-labelledby="createLabel" 
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="createLabel">Add a Course</h2>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            
                            <form action="../process/create_course.php" method="POST" id="createCourseValidation">
                                <div class="modal-body">
                                    <div class = "container">
                                        <div class="row mb-3">
                                            <label for="course" class="form-label">Course Name</label>
                                            <input type="text" name="course" class="form-control" id="course" placeholder="Name of the Course" required>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="course_code" class="form-label">Course Code</label>
                                            <input type="text" style="text-transform: uppercase;" name="course_code" class="form-control" id="course_code" placeholder="Code of the Course" required>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="college_code" class="form-label">College Code</label>
                                            <select name="college" class="form-control" id="college" required>
                                                <option value="">Choose the college where this course belongs</option>
                                                    <?php
                                                        $sql = "SELECT * FROM college WHERE is_active = 1";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='{$row['id']}'>{$row['college']}</option>";
                                                        } 
                                                    ?>
                                            </select>
                                        </div>
                                    </div>     
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="create_course" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <!-- Create Modal -->             

            <!-- Edit Modal -->
                <div class="modal fade" id="editCourseModal" tabindex="-1" role="dialog" aria-labelledby="editLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="editLabel">Edit Course</h2>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div> 
                            <form action="../process/edit_course.php" method="POST" id="editCourseValidation">
                                <div class="modal-body">
                                    <div class = "container">
                                        <div class="row mb-3">
                                            <input type="hidden" id='update_course_id' name="course_id">
                                            <label for="course" class="form-label">Course Name</label>
                                            <input type="text" id='update_course' name="course" class="form-control" required >
                                        </div>
                                        <div class="row mb-3">
                                            <label for="Course_code" class="form-label">Course Code</label>
                                            <input type="text" style="text-transform: uppercase;" id='update_course_code' name="course_code" class="form-control" required>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="college_code" class="form-label">College Code</label>
                                            <select name="college_id" class="form-control" id="update_college_id" required>
                                                <option value="">Choose the college where this course belongs</option>
                                                    <?php
                                                        $sql = "SELECT * FROM college WHERE is_active = 1";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='{$row['id']}'>{$row['college']}</option>";
                                                        } 
                                                    // ?>
                                            </select>
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
                <div class="modal fade" id="disableCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="disable_name" >Are you sure you want to disable this Course?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div>
                            <form action="../process/disable_course.php" method="POST" id="disableCourseValidation">
                                <div class="modal-body">
                                    <input type="hidden" id='disable_course_id' name="course_id">
                                    Select "Disable" below if you are sure you want to disable the course.
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

            <!-- Enable Modal-->
                <div class="modal fade" id="enableCourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="enable_name" >Are you sure you want to enable this Course?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div>
                            <form action="../process/enable_course.php" method="POST" id="enableCourseValidation">
                                <div class="modal-body">
                                    <input type="hidden" id='enable_course_id' name="course_id">
                                    <input type="hidden" id='enable_college_id' name="college_id">
                                    Select "Enable" below if you are sure you want to enable this course.
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


        <!-- Course Modals -->

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

        //Courses Functions
            //Displaying of courses
                $('#fetching_course_table').DataTable({
                    scrollX: true,
                    processing: true,
                    destroy: true,
                    responsive: true,
                    autoWidth: false, // Prevent DataTables from setting column widths
                    order: [[0, 'desc']],
                    ajax: {
                        url: 'json_courses.php',
                        dataSrc: ""
                    },
                    columns: 
                    [   
                        {"data" :   "course"},
                        {"data" :   "course_code"},
                        {"data" :   "college_code"},
                        {"data" :   "status"},
                        {"data" :   "created_at"},
                        {"data" :   "updated_at"},
                        {"data" :   "action"}
                    ]
                });
            //Displaying of courses

            // Create Course
                $('#createCourseValidation').validate({
                    rules: {
                        course: {required: true,},
                        course_code: {required: true,},
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
                                    $('#createCourseModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_course_table').DataTable().ajax.reload();
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
            // Create Course

            // Edit College
                $('#fetching_course_table').on('click', '.edit_course', function(e) {
                    e.preventDefault();
                    var course_id = $(this).data('course_id');
                    console.log(course_id);


                    $.ajax({  
                        url: "fetch_courses_list.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            course_id : course_id,

                        },
                        dataType: "json",
                        success:function(response) {  
                            console.log(response);
                            $('#update_course_id').val(response.id);
                            $('#update_course').val(response.course);
                            $('#update_course_code').val(response.course_code);
                            $('#update_college_id').val(response.college_id);
                            $('#editCourseModal').modal('show');
                        }
                    }); 
                });

                $('#editCourseValidation').validate({
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
                                        $('#editCourseModal').modal('hide');
                                        Swal.fire({
                                            title: 'Success!',
                                            text: res.message,
                                            icon: 'success',
                                        }).then(() => {
                                            $('#fetching_course_table').DataTable().ajax.reload();
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

            // Enable Course 
                $('#fetching_course_table').on('click', '.enable_course', function(e) {
                    e.preventDefault();
                    var course_id = $(this).data('course_id');
                    console.log(course_id);


                    $.ajax({  
                        url: "get_course.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            course_id : course_id,
                            
                        },
                        dataType: "json",
                        success:function(response) {  
                            console.log(response);
                            // console.log(response.id);
                            $('#enable_course_id').val(response.id);
                            $('#enable_college_id').val(response.college_id);
                            $('#enableCourseModal').modal('show');
                        }
                    }); 
                });

        
                $('#enableCourseValidation').validate({
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
                                    $('#enableCourseModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_course_table').DataTable().ajax.reload();
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
            // Enable Course

            // Disable Course 
                $('#fetching_course_table').on('click', '.disable_course', function(e) {
                    e.preventDefault();
                    var course_id = $(this).data('course_id');
                    console.log(course_id);


                    $.ajax({  
                        url: "get_course.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            course_id : course_id,
                            
                        },
                        dataType: "json",
                        success:function(response) {  
                            console.log(response);
                            // console.log(response.id);
                            $('#disable_course_id').val(response.id);
                            $('#disableCourseModal').modal('show');
                        }
                    }); 
                });

        
                $('#disableCourseValidation').validate({
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
                                    $('#disableCourseModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_course_table').DataTable().ajax.reload();
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
            // Disable Course

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
        //Courses Functions
        });           
    </script>

    </body>

</html>
