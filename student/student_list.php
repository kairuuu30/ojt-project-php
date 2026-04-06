<?php 
session_start();
include("../server/connection.php");
include("../auth/session.php");
?>

<!DOCTYPE html>
<html lang="en">
    
    <?php
    $pageTitle = "Students List";
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
                    <h1 class="h3 mb-2 text-gray-800">Student List</h1>
                    <p class="mb-4">Create, Edit, and Delete students users.</p>
                    
                    <!-- Student DataTables  -->
                        <div class="card shadow mb-4">   
                            <div class="card-header py-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#createModal" >Create Student User</button>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover" id="fetching_data_table" style="font-size: 13px !important;">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Birthday</th>
                                                <th>Phone Number</th>
                                                <th>TUP ID</th>
                                                <th>College</th>
                                                <th>Course</th>
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
                    <!-- Student DataTables  -->
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Create Modal -->
                <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createLabel" 
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="createLabel">Create Student User</h2>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <form action="../process/create_user.php" method="POST" id="createUserValidation" enctype="multipart/form-data">
                                <div class="modal-body">
                                    <div class = "container">
                                        <div class="text-center mb-4">
                                        <div class="fw-bold h5 text-primary text-uppercase mb-3 text-center">Profile Picture</div>
                                            <div class="profile-upload-wrapper mx-auto">
                                                <img id="image_release_preview" src="<?php echo '../img/no_profile_picture.png'; ?>" alt="Profile" class="img-fluid">
                                                <label for="imageReleaseUpload" class="edit-icon">
                                                    <i class="fas fa-pencil-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Profile"></i>
                                                </label>
                                                <input type="file" name="upload_file" id="imageReleaseUpload" accept=".jpg, .jpeg, .png" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-7">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="Student's Name (ex. Juan Dela Cruz)" required>
                                            </div>
                                            <div class="col-md-5">
                                                <label for="tup_id" class="form-label">TUP ID</label>
                                                <input type="text" name="tup_id" style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()" class="form-control" id="tup_id" placeholder="(ex. TUPM-22-1234)" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Username</label>
                                                <input type="text" name="username" class="form-control" id="username" placeholder="Student's Username" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Password</label>
                                                <input type="text" name="password" class="form-control" id="password" placeholder="Student's Password" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="bday" class="form-label">Birthday</label>
                                                <input type="date" name="bday" class="form-control" id="bday" placeholder="Student's Birthday" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="tel" name="phone" pattern="09[0-9]{9}" maxlength="11" minlength="11"  class="form-control" id="phone" placeholder="(ex. 09123456789)" required>
                                            </div>                              
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="course" class="form-label">College</label>
                                                <select name="college_id" class="form-control" id="college_id" required>
                                                    <option value="">Choose Student's College</option>
                                                        <?php
                                                            $sql = "SELECT * FROM college WHERE is_active = 1";
                                                            $result = mysqli_query($conn, $sql);
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                echo "<option value='{$row['id']}'>{$row['college']}</option>";
                                                            } 
                                                        ?>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="course" class="form-label" >Course</label>
                                                <select name="course_id" class="form-control" id="course_id" required disabled>
                                                    <option value="">Choose Student's Course</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>     
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="create_user" class="btn btn-primary">Create</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            <!-- Create Modal -->             

            <!-- Edit Modal -->
                <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h2 class="modal-title" id="editLabel">Edit Student User</h2>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div> 
                            <form action="../process/edit_user.php" method="POST" id="editUserValidation">
                                <div class="modal-body">
                                    <div class = "container">
                                        <div class="row mb-3"> 
                                            <div class="profile-upload-wrapper mx-auto">
                                                <img id="image_release_preview" src="<?php echo '../img/no_profile_picture.png'; ?>" alt="Profile" class="img-fluid">
                                                <label for="imageReleaseUpload" class="edit-icon">
                                                    <i class="fas fa-pencil-alt" data-bs-toggle="tooltip" data-bs-placement="top" title="Upload Profile"></i>
                                                </label>
                                                <input type="file" name="upload_file" id="imageReleaseUpload" accept=".jpg, .jpeg, .png" required>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <input type="hidden" id='update_id' name="id">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" id='update_name' name="name" class="form-control" required >
                                        </div>
                                        <div class="row mb-3">
                                            <label for="bday" class="form-label">Birthday</label>
                                            <input type="date" id='update_bday' name="bday" class="form-control" required>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="phone" class="form-label">Phone Number</label>
                                            <input type="text" id='update_phone' name="phone" class="form-control" required>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="tup_id" class="form-label">TUP ID</label>
                                            <input type="text"  style="text-transform: uppercase;" oninput="this.value = this.value.toUpperCase()" id='update_tup_id' name="tup_id" class="form-control"  required>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="college" class="form-label">College</label>
                                            <select name="college_id" class="form-control" id="update_college" required>
                                                <option value="">Choose Student's College</option>
                                                    <?php
                                                        $sql = "SELECT * FROM college WHERE is_active = 1";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='{$row['id']}'>{$row['college']}</option>";
                                                        } 
                                                    ?>
                                            </select>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="course" class="form-label" >Course</label>
                                            <select name="course_id" class="form-control" id="update_course" required>
                                                <option value="">Choose Student's Course</option>
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

            <!-- Delete Modal -->
                <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="delete_name" >Are you sure you want to delete the student user?</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                                </div>
                            <form action="../process/delete_user.php" method="POST" id="deleteUserValidation">
                                <div class="modal-body">
                                    <input type="hidden" id='delete_id' name="id">
                                    Select "Delete" below if you are sure you want to delete the user.
                                </div>
                                <div class="modal-footer">
                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                <button type="submit"  class="btn btn-danger">Delete</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>  
            <!-- Delete Modal -->

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
            //Displaying of students
                $('#fetching_data_table').DataTable({
                    scrollX: true,
                    processing: true,
                    destroy: true,
                    responsive: true,
                    autoWidth: false, // Prevent DataTables from setting column widths
                    order: [[0, 'desc']],
                    ajax: {
                        url: 'json_students.php',
                        dataSrc: ""
                    },
                    columns: 
                    [   
                        {"data" :   "name"},
                        {"data" :   "bday"},
                        {"data" :   "phone"},
                        {"data" :   "tup_id"},
                        {"data" :   "college_name"},
                        {"data" :   "course_name"},
                        // {"data" :   "college_id"},
                        // {"data" :   "course_id"},
                        {"data" :   "created_at"},
                        {"data" :   "updated_at"},
                        {"data" :   "action"},
                    ]
                });
            //Displaying of students

            // Create User
                $('#createUserValidation').validate({
                    rules: {
                        upload_file: {required: true,},
                        name: {required: true,},
                        bday: {required: true,}, 
                        phone: {required: true,},
                        tup_id: {required: true,},
                        college_id: {required: true,},
                        course_id: {required: true,}
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

                        var formData = new FormData(form);

                        $.ajax({
                            url: form.action,
                            type: form.method,
                            data: formData,
                            contentType: false,
                            processData: false, 
                            dataType: 'json',
                            success: function(response) {
                                if (typeof response === 'string') {
                                    var res = JSON.parse(response);
                                } else {
                                    var res = response; // If it's already an object
                                }

                                if (res.status === 'success') {
                                    $('#createModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_data_table').DataTable().ajax.reload();
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

                $(document).on('change', '#college_id', function () {
                    var college_id = $(this).val();
                    var $courseSelect = $('#course_id');
                    console.log(college_id);

                    $('#course_id').prop('disabled', false);

                    $.ajax({
                        url: 'get_course.php',
                        type: 'GET',
                        data: { college_id: college_id },
                        dataType: 'json',

                        success: function (response) {
                            console.log(response);
                            // var $courseSelect = $('#course_id');
                            $courseSelect.empty(); // clear first

                            if (response.length === 0) {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'No Course Found',
                                    icon: 'warning',
                                });
                                $courseSelect.append('<option value="" selected>Select Course</option>');
                                $courseSelect.prop("disabled", true);
                                
                                return;
                            }

                            $courseSelect.append('<option value="" disabled selected>Select Course</option>');

                            $.each(response, function (index, course) {
                                $courseSelect.append(
                                    `<option value="${course.id}">${course.course}</option>`
                                );
                            });

                            $courseSelect.prop("disabled", false).trigger('change');
                        },

                        error: function (xhr) {
                            Swal.fire("Error", "There no courses under this College", "error");

                            $courseSelect.empty().append('<option value="" selected>Select Course</option>').prop('disabled', true);
                        }
                    });
                });

                document.getElementById('imageReleaseUpload').addEventListener('change', async function (event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('image_release_preview');

                    // Reset preview if no file is selected
                    if (!file) {
                        preview.src = "<?php echo '../img/no_profile_picture.png'; ?>";
                        return;
                    }

                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Invalid file type',
                            text: 'Only JPG, JPEG, and PNG files are allowed.'
                        });
                        event.target.value = ''; // Clear the input
                        preview.src = "<?php echo '../img/no_profile_picture.png'; ?>"; // Reset preview
                        return;
                    }

                    // Show compression loading indicator
                    Swal.fire({
                        title: 'Compressing image...',
                        text: 'Please wait while the image is being optimized.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    try {
                        const options = {
                            maxSizeMB: 1, // Higher limit to allow initial compression
                            maxWidthOrHeight: 1920, // Maintain aspect ratio
                            useWebWorker: true,
                            maxIteration: 10,
                            initialQuality: 0.8
                        };

                        let compressedFile = await imageCompression(file, options);

                        // Further compress if the file size is still above 200KB
                        while (compressedFile.size > 200 * 1024) {
                            compressedFile = await imageCompression(compressedFile, {
                                maxSizeMB: compressedFile.size / 1024 / 1024 / 2, // Reduce size further
                                initialQuality: 0.7 // Reduce quality slightly
                            });
                        }

                        console.log('Final compressed file size:', (compressedFile.size / 1024).toFixed(2), 'KB');

                        // Close the loading indicator
                        Swal.close();

                        // Display preview
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.src = e.target.result;
                        };
                        reader.readAsDataURL(compressedFile);

                        // Create a new File object to replace the original input
                        const newFile = new File([compressedFile], file.name, { type: file.type });

                        // Create a DataTransfer object to update the input field
                        const dataTransfer = new DataTransfer();
                        dataTransfer.items.add(newFile);
                        document.getElementById('imageReleaseUpload').files = dataTransfer.files;

                    } catch (error) {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            title: 'Compression error',
                            text: 'An error occurred during image compression. Please try again.'
                        });
                    }
                });

                // const formData = new FormData();
                // formData.append('image_release_preview', compressedFile);

                // fetch('upload_image.php', {
                //     method: 'POST', 
                //     body: formData
                // })
                // .then(response => response.json())
                // .then(data => {
                //     if (data.success) {
                //         document.getElementById('image_release_preview').src = data.filePath;
                //     }
                // })
            // Create User

            // Edit User
                document.getElementById('imageReleaseUpload').addEventListener('change', function() {
                    const file = this.files[0];
                    if (!file) return;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('image_release_preview').src = e.target.result;
                    };
                    reader.readAsDataURL(file);
                });
                
                $('#fetching_data_table').on('click', '.edit_user', function(e) {
                    e.preventDefault();
                    var student_id = $(this).data('user_id');
                    console.log(student_id);


                    $.ajax({  
                        url: "get_student.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            student_id : student_id, 
                        },
                        dataType: "json",
                        success:function(response) {  
                            console.log(response);
                            $('#update_id').val(response.id);
                            $('#update_name').val(response.name);
                            $('#update_bday').val(response.bday);
                            $('#update_phone').val(response.phone);
                            $('#update_tup_id').val(response.tup_id);

                            if (!response.college_id || response.college_id === "0") {
                                $('#update_college').val('').trigger('change');
                            } else {
                                $('#update_college').val(response.college_id).data('selected-course', response.course_id).trigger('change');
                            }

                            $('#editModal').modal('show');
                        }
                    }); 
                });

                $(document).on('change', '#update_college', function () {
                    var college_id = $(this).val();
                    var $collegeSelect = $('#update_college');
                    var selectedCourse = $(this).data('selected-course');
                    var $courseSelect = $('#update_course');

                    $courseSelect.empty();
                    console.log(college_id);

                    if (!college_id || college_id === "") {
                        $courseSelect.append('<option value="" selected>Select Course</option>');
                        $courseSelect.prop('disabled', true);
                        return;
                    }

                    $courseSelect.prop('disabled', true);

                    $.ajax({
                        url: 'get_course.php',
                        type: 'GET',
                        data: { college_id: college_id },
                        dataType: 'json',

                        success: function (response) {
                            console.log(response);
                            $courseSelect.empty(); // clear first

                            if (response.length === 0) {
                                $courseSelect.append('<option value="" selected>Select Course</option>');
                                $courseSelect.prop('disabled', true);
                                Swal.fire({
                                    title: 'Error',
                                    text: 'No Course Found',
                                    icon: 'warning',
                                });
                                return;
                            }

                            $courseSelect.append('<option value="" disabled selected>Select Course</option>');

                            $.each(response, function (index, course) {
                                $courseSelect.append(
                                    '<option value="' + course.id + '">' + course.course + '</option>'
                                );
                            });

                            if(selectedCourse) {
                                $courseSelect.val(selectedCourse);

                                $('#update_college').removeData('selected-course');
                            }
                            
                            $courseSelect.prop('disabled', false);
                        },

                        error: function (xhr) {
                            // Swal.fire("Error", "There no courses under this College", "error");
                            $courseSelect.empty().append('<option value="" selected>Select Course</option>').prop('disabled', true);
                        }
                    });
                });

                $('#editUserValidation').validate({
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
                                        $('#editModal').modal('hide');
                                        Swal.fire({
                                            title: 'Success!',
                                            text: res.message,
                                            icon: 'success',
                                        }).then(() => {
                                            $('#fetching_data_table').DataTable().ajax.reload();
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
            // Edit User

            // Delete user 
                $('#fetching_data_table').on('click', '.delete_user', function(e) {
                    e.preventDefault();
                    var student_id = $(this).data('user_id');
                    // console.log(student_id);


                    $.ajax({  
                        url: "get_student.php",  
                        type: "GET",  
                        cache: false,  
                        data:{
                            student_id : student_id,
                            
                        },
                        dataType: "json",
                        success:function(response) {  
                            // console.log(response);
                            // console.log(response.id);
                            // console.log(response.name);
                            $('#delete_id').val(response.id);
                            $('#deleteModal').modal('show');
                        }
                    }); 
                });

        
                $('#deleteUserValidation').validate({
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
                                    $('#deleteModal').modal('hide');
                                    Swal.fire({
                                        title: 'Success!',
                                        text: res.message,
                                        icon: 'success',
                                    }).then(() => {
                                        $('#fetching_data_table').DataTable().ajax.reload();
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
            // Delete User

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
