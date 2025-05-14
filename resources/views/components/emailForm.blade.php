<style>
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f6f6f6;
    }

    .container {
        width: 100%;
        max-width: 600px;
        margin: 0 auto;
        background-color: #1E293B;
        padding: 20px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .header {
        text-align: center;
        padding: 10px 0;
    }

    .header img {
        max-width: 150px;
    }

    .content {
        padding: 20px;
        text-align: center;
    }

    .content h1 {
        color: #ffffff;
    }

    .content p {
        color: #ffffff;
        line-height: 1.6;
    }

    .verify-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        margin-top: 20px;
    }

    .footer {
        text-align: center;
        padding: 10px 0;
        color: #989797;
        font-size: 12px;
        border-top: 1px solid #dddddd;
        margin-top: 20px;
    }
</style>
<div class="container">
    <div class="header">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
    <div class="content">
       {{-- contents here  --}}
       
    </div>
    <div class="footer">
        <p>&copy; 2024 You Hear Us. All rights reserved.</p>
    </div>
</div>
