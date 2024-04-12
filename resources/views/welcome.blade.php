@extends('layouts.index')
@section('title', 'Welcome Page')



<style>

body {
  /* background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab); */
  /* background-size: 400% 400%; */
  animation: gradient 15s ease infinite;
  background-color: black !important;
  min-height: 100vh;
  width: 100vw;
  overflow-y: hidden;
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }

  50% {
    background-position: 100% 50%;
  }

  100% {
    background-position: 0% 50%;
  }
}
.carousel{
    position: relative;
}
.logo{
    position: absolute;
    width: 150px !important;
    top: 10;
    left: 70;
    z-index: 999 !important;
}
 
  .carousel-item {
        object-fit: cover;
        width: 100%;
     
      
  }
  .carousel-item img,
.carousel-item video,
.carousel-item iframe {
    width: 100% !important;
    height: 100vh !important;
    object-fit: cover;
    /* opacity: 0.7; */
}

    .carousel-caption {
        box-shadow: rgba(0, 0, 0, 0.25) 0px 54px 55px, rgba(0, 0, 0, 0.12) 0px -12px 30px, rgba(0, 0, 0, 0.12) 0px 4px 6px, rgba(0, 0, 0, 0.17) 0px 12px 13px, rgba(0, 0, 0, 0.09) 0px -3px 5px;
        background-color: rgba(0, 0, 0, 0.601) !important;
        border-radius: 10px !important;
        text-align: left !important;
        padding:  20px !important;
        margin-bottom: 80px !important;
    }
    .carousel-caption  h1{
        font-size: 20px !important;
        color: #94d60a;
    }
    iframe{
      background-color: black !important;

    }

    
</style>

@section('content')
<div id="carouselExampleControls" class="carousel slide carousel-fade" data-ride="carousel" data-interval="3000" >
  <img class="logo" src="assets/wcmc_logo_1.png" alt="">
  <div class="carousel-inner " style="width:100%; height:100vh;">
    @foreach ($slides as $key => $slide)
        {{-- Determine the file type --}}
        @php
            $extension = pathinfo($slide->file, PATHINFO_EXTENSION);
        @endphp
        @if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png' || $extension == 'gif')
            <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                <img class="d-block w-100" src="{{ 'image_upload/' . $slide->file }}" alt="Slide {{$key + 1}}">
                <div class="carousel-caption d-none d-md-block">
                    <h1>{{$slide->title}}</h1>
                    <hr>
                    <h6>{{$slide->description}}</h6>
                </div>
            </div>
        @elseif ($extension == 'mp4' || $extension == 'avi' || $extension == 'mov' || $extension == 'wmv')
        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
          <video  class="d-block w-100" autoplay loop muted controls>
              <source src="{{ 'image_upload/' . $slide->file }}" type="video/mp4">
              Your browser does not support the video tag.
          </video>
      </div>
        @else
            {{-- Display a document --}}
            @if($key == 0)
              <div class="carousel-item active">
                    {{-- <iframe class="pdf" src="{{ 'image_upload/' . $slide->file.'#toolbar=0' }}" ></iframe> --}}

                    <embed src="{{ 'image_upload/' . $slide->file.'#toolbar=0' }}" width="800px" height="2100px" />
              </div>
            @else
            <div class="carousel-item" >
              {{-- <iframe frameborder="0" scrolling="no" class="pdf" src="{{ 'image_upload/' . $slide->file.'#toolbar=0' }}" style="height:735px;"></iframe> --}}
              {{-- <iframe   frameborder="0" scrolling="no" class="pdf" src="{{ 'image_upload/' . $slide->file.'#toolbar=0&autoplay=1' }}"></iframe> --}}
              <embed src="{{ 'image_upload/' . $slide->file.'#toolbar=0' }}" width="100%" height="2100px" />
          </div>
            @endif
        @endif
    @endforeach
</div>

  <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
      <span style="display:none" class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only" style="display:none">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
      <span style="display:none" class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only" >Next</span>
  </a>
</div>





<script>
  document.addEventListener('DOMContentLoaded', function () {
    var iframe = document.querySelector('.carousel-item.active iframe');
    var checkForVideoInterval = setInterval(function () {
      var iframeDocument = iframe.contentDocument || iframe.contentWindow.document;
      var video = iframeDocument.querySelector('video');
      if (video) {
        video.addEventListener('ended', function () {
          $('.carousel').carousel('next');
        });
        clearInterval(checkForVideoInterval); // Stop checking once video is found
      }
    }, 1000); // Check every second
  });
</script>






{{-- <script>
Function to reload the page every minute
function reloadPage() {
    setTimeout(function() {
        location.reload();
    }, 60000); 
}

Call the function initially to start reloading the page
reloadPage();

</script> --}}

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>





@endsection