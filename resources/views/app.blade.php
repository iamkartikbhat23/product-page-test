<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Product Page</title>

        <script defer src="{{ mix('js/app.js') }}"></script>
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <script src="https://cdn.tailwindcss.com"></script>

        <script>
            tailwind.config = {
                theme: {
                    screens: {
                        'xs': '375px',
                        'sm': '640px',
                        'md': '768px',
                        'lg': '1024px',
                        'xl': '1280px',
                        '2xl': '1440px',
                    },
                    extend: {
                        colors: {
                            'orangee': 'hsl(26, 100%, 55%)',
                            'pale-orangee': 'hsl(25, 100%, 94%)',
                            'very-dark-blue': ' hsl(220, 13%, 13%)',
                            'dark-gray-blue': 'hsl(219, 9%, 45%)',
                            'gray-blue': 'hsl(220, 14%, 75%)',
                            'light-gray-blue': 'hsl(223, 64%, 98%)',
                            'whitee': 'hsl(0, 0%, 100%)',
                            'blacky': 'hsla(0,0%,0%,0.75)'
                        },
                        fontFamily: {
                            montserrat: ["Montserrat", "sans-serif"],
                        },
                    }
                }
            } ;
        </script>
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        />

        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    </head>
    <body class="antialiased">
        <div id="app" class="h-screen w-full">
            <router-view></router-view>
        </div>
    </body>
</html>
