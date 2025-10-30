<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    <style>
      body {
        /* ✅ Achtergrondafbeelding */
        background-image: url("https://mecaluxnl.cdnwm.com/documents/20128/441291/Zona+expedicion-Almac%C3%A9n+empresa+distribuci%C3%B3n-es_ES.jpg/ca7e829b-1d94-ccaa-5dcb-72dfc21c4991?t=1563271123000&e=jpg");
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        margin: 0;
        font-family: 'Instrument Sans', sans-serif;
        color: #1b1b18;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        position: relative;
      }

      /* ✅ Overlay voor leesbaarheid */
      body::before {
        content: "";
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.45);
        backdrop-filter: blur(2px);
        z-index: 0;
      }

      header, main {
        position: relative;
        z-index: 1;
      }

      header {
        width: 100%;
        max-width: 800px;
        display: flex;
        justify-content: flex-end;
        padding: 1rem 2rem;
      }

      nav a {
        color: #fff;
        text-decoration: none;
        padding: 0.5rem 1.25rem;
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 6px;
        transition: all 0.3s ease;
        font-size: 0.95rem;
        margin-left: 0.5rem;
        backdrop-filter: blur(4px);
        background: rgba(255, 255, 255, 0.08);
      }

      nav a:hover {
        background: rgba(255, 255, 255, 0.2);
        border-color: rgba(255, 255, 255, 0.6);
      }

      main {
        background: rgba(255, 255, 255, 0.85);
        color: #1b1b18;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        padding: 2.5rem 3rem;
        text-align: center;
        max-width: 640px;
        width: 90%;
        margin-top: 2rem;
        backdrop-filter: blur(6px);
      }

      main h1 {
        font-size: 2rem;
        margin-bottom: 1rem;
        font-weight: 600;
      }

      main p {
        font-size: 1rem;
        color: #333;
        line-height: 1.6;
      }

      @media (prefers-color-scheme: dark) {
        body::before {
          background: rgba(0, 0, 0, 0.6);
        }

        main {
          background: rgba(30, 30, 30, 0.8);
          color: #f2f2f2;
        }

        nav a {
          color: #f2f2f2;
          border-color: rgba(255, 255, 255, 0.2);
        }

        nav a:hover {
          background: rgba(255, 255, 255, 0.15);
        }
      }
    </style>
  </head>
  <body>
    <header>
      @if (Route::has('login'))
        <nav>
          <a href="{{ route('allergeen.index') }}">Allergenen</a>
          <a href="{{ route('magazijn.index') }}">Magazijn</a>
          @auth
            <a href="{{ url('/dashboard') }}">Dashboard</a>
          @else
            <a href="{{ route('login') }}">Log in</a>
            @if (Route::has('register'))
              <a href="{{ route('register') }}">Register</a>
            @endif
          @endauth
        </nav>
      @endif
    </header>

    <main>
      <h1>Welkom bij het Magazijnportaal</h1>
      <p>
        Beheer eenvoudig je magazijn, allergenen en distributieprocessen vanuit één centrale omgeving.
        Gebruik de navigatie bovenaan om naar de gewenste sectie te gaan.
      </p>
    </main>
  </body>
</html>
