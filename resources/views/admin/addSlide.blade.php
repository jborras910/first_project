@extends('admin.index')
@section('title', 'Add Slide')

    <!-- include summernote css/js -->
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


<style>
    .form-group input, .form-group textarea{
        box-shadow: rgba(0, 0, 0, 0.02) 0px 1px 3px 0px, rgba(27, 31, 35, 0.15) 0px 0px 0px 1px;
    }
    #imagePreview{
        display: none; 
        max-width: 300px; 
        height: 300px; 
        margin-bottom: 20px;
        box-shadow: rgba(0, 0, 0, 0.16) 0px 3px 6px, rgba(0, 0, 0, 0.23) 0px 3px 6px;
    }
</style>

@section('content')
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between flex-wrap">
            <div class="d-flex align-items-end flex-wrap">
            </div>
            <div style="width:100%;" class="d-flex justify-content-between align-items-end flex-wrap ">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Add Slide
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="#" onclick="showSlide('add_Image_slide', 'Add Image Slide')">Add Image Slide</a>
                        <a class="dropdown-item" href="#" onclick="showSlide('add_video_slide', 'Add Video Slide')">Add Video Slide</a>
                        <a class="dropdown-item" href="#" onclick="showSlide('add_document_slide', 'Add Document Slide')">Add Document Slide</a>
                    </div>
                </div>
                <a href="{{route('admin.dashboard')}}" class="btn btn-danger text-light">Back</a>
            </div>
        </div>
        <div class="slide-container" id="add_Image_slide">
            <form class="mt-5" method="post" action="{{ route('addSlide.post') }}" enctype="multipart/form-data">
                @if ($errors->any())
                    <script>
                        @foreach ($errors->all() as $error)
                            swal({
                                title: "Error!",
                                text: "{{ $error == 'The file name must be an image.' ? 'Please upload an image file.' : $error }}",
                                icon: "error",
                            });
                        @endforeach
                    </script>
                @endif
        
                @csrf
                <img id="imagePreview" src="#" alt="Image Preview">
                <div class="row">
                    <div class="form-group col-md-6">
                        <input name="file_name" class="form-control" type="file" id="formFile"  accept="image/*,video/*" onchange="previewImage(event)" required>
                    </div>
                    <div class="form-group col-md-6">
                        <input name="title" type="text" class="form-control" placeholder="Enter Title..." required>
                    </div>
                    <div class="form-group col-md-12">
                        
                        <textarea   name="description" class="form-control" placeholder="Enter Description..." rows="3" required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary text-light">Submit</button>
        </form>
        </div>
        <div class="slide-container" id="add_video_slide" style="display: none;">
            <form class="mt-5" method="post" action="{{ route('addVideoslide.post') }}" enctype="multipart/form-data">
                @if ($errors->any())
                    <script>
                        @foreach ($errors->all() as $error)
                            swal({
                                title: "Error!",
                                text: "{{ $error == 'The file name must be an image.' ? 'Please upload an image file.' : $error }}",
                                icon: "error",
                            });
                        @endforeach
                    </script>
                @endif
        
                @csrf
                <img id="imagePreview" src="#" alt="Image Preview">
                <div class="row">
                    <label for="">Add Video Slide</label>
                    <div class="form-group col-md-12">
                        <input name="file_name" class="form-control" type="file" id="formFile"  accept="video/*"   required>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary text-light">Submit</button>
        </form>
        </div>
        <div class="slide-container" id="add_document_slide" style="display: none;">
            <form class="mt-5" method="post" action="{{ route('addDocumentslide.post') }}" enctype="multipart/form-data">
                @if ($errors->any())
                    <script>
                        @foreach ($errors->all() as $error)
                            swal({
                                title: "Error!",
                                text: "{{ $error == 'The file name must be an image.' ? 'Please upload an image file.' : $error }}",
                                icon: "error",
                            });
                        @endforeach
                    </script>
                @endif
        
                @csrf
                <img id="imagePreview" src="#" alt="Image Preview">
                <div class="row">
                    <label for="">Add document Slide</label>
                    <div class="form-group col-md-12">
<input name="file_name" class="form-control" type="file" id="formFile" accept="application/pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.csv,.zip" onchange="previewFile(event)" required>

                    </div>
                </div>
                <button type="submit" class="btn btn-primary text-light">Submit</button>
        </form>
        </div>
    </div>
</div>

<script>
    function previewImage(event) {
        var input = event.target;
        var preview = document.getElementById('imagePreview');
        
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }

                // Function to show the selected slide and hide others
                function showSlide(slideId, buttonText) {
                // Hide all slide containers
                var slideContainers = document.getElementsByClassName('slide-container');
                for (var i = 0; i < slideContainers.length; i++) {
                    slideContainers[i].style.display = 'none';
                }
        
                // Show the selected slide container
                document.getElementById(slideId).style.display = 'block';
        
                // Change the button text
                document.getElementById('dropdownMenuButton').innerText = buttonText;
            }
        
            // Show the default active slide on page load
            window.onload = function() {
                showSlide('add_Image_slide', 'Add Image Slide');
            };
    </script>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

@endsection