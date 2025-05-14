<!-- resources/views/emails/layout.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }
        .email-wrapper {
            width: 100%;
            background-color: #f4f4f4;
            padding: 20px 0;
        }
        .email-content {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #1E293B;
            border: 1px solid #dddddd;
            border-radius: 4px;
        }
        .email-header, .email-footer {
            
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 4px 4px 0 0;
        }
	    .email-header{
            background-color: #0c1425;
            
        }
        .email-body {
            padding: 20px;
            color: white;
        }
        .email-footer {
            padding: 10px 0;
            font-size: 12px;
	    background-color: #1E293B;
	    border-top: 1px solid #dddddd;

        }
        .email-body h1, .email-body h2, .email-body h3, .email-body p {
            margin: 0 0 15px;
        }

        /* .btn{
            border: 3px solid;
            padding: 3px 2px 3px 2px;
            color:#2fa4d8;
        } */
        a.btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            font-size: 16px;
            color: #ffffff;
            background-color: #2fa4d8;
            text-decoration: none;
            border-radius: 5px;
            
        }
        a.btn:hover {
            opacity: 0.8;
            color: #000;
        }
        .unsubscribe {
            font-size: 11px;
            margin-top: 10px;
            color: #cccccc;
        }
        .unsubscribe a {
            color: #cccccc;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <table class="email-wrapper" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <table class="email-content" cellpadding="0" cellspacing="0">
                    <!-- Header -->
                    <tr>
                        <td class="email-header">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo">
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td class="email-body" style="color:#fff">
                            @yield('content')
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td class="email-footer">
                            <p>&copy; {{ date('Y') }} You Hear Us. All rights reserved.</p>
                            @if(isset($unsubscribe_url))
                            <div class="unsubscribe">
                                <p>If you no longer wish to receive these emails, you can <a href="{{ $unsubscribe_url }}">unsubscribe here</a>.</p>
                            </div>
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
   
</body>
</html>