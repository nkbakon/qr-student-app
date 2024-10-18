<!DOCTYPE html>
<html>
<head>
<style>
     * { box-sizing: border-box; }
    body {
        font-family: Arial, sans-serif;
    }

    h2{
        font-size: 24px;
        text-align: center; 
        flex-direction: column;   
    }

    .image-container {
        display: flex;
        justify-content: space-between;
    }

    .header-image-small {
      max-width: 15%;
      height: auto;
    }

    .view-image {
      max-width: 50%;
      height: auto;
    }

    .text-black {
      color: #000000;
    }

    .m-2 {
      margin: 0.5rem;
    }

    .p-4 {
      padding: 1rem;
    }

    .qr-code {
        text-align: center;
        margin-top: 2em;
    }
    .qr-code img {
        display: inline-block;
        width: 400px;
        height: 400px;
    }

    .profile-pic {
        text-align: center;
        margin-top: 2em;
    }
    .profile-pic img {
        display: inline-block;
        width: 250px;
        height: 250px;
    }

</style>
</head>
<body>
<div class="image-container">
    <!-- <img src="{{ public_path('assets/home.png') }}" align="left" alt="Imagen 1" class="header-image-small"> -->
    <img src="{{ public_path('assets/logo.png') }}" align="right" alt="Imagen 2" class="header-image-small">
</div>
<br>
<h2>{{ $user->name }} </h2>
<br>
<div class="profile-pic">
    <img src="{{ public_path('storage') }}/{{ $user->profile_pic }}" alt="profile" class="center">
</div><br>
@if(isset($qrCodeBase64))
    <div class="qr-code">
        <img src="{{ $qrCodeBase64 }}" alt="QR Code" class="center">
    </div>
@endif
</body>
</html>