<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5">
        <meta name="description" content="BlackCat Business Solutions en Santander | Expertos en desarrollo web y automatización de procesos para empresas en Cantabria. Soluciones tecnológicas a medida para optimizar tu negocio.">
        <meta name="keywords" content="BlackCat Business, desarrollo web Santander, software Cantabria, automatización procesos, transformación digital, aplicaciones empresariales, soluciones IT Santander">
        
        <!-- Metatags de geolocalización -->
        <meta name="geo.region" content="ES-CB">
        <meta name="geo.placename" content="Santander">
        <meta name="geo.position" content="43.462776;-3.805">
        <meta name="ICBM" content="43.462776, -3.805">
        

          <!-- Google Analytics -->
          <script async src="https://www.googletagmanager.com/gtag/js?id=G-7MEVWK53DP"></script>
          <script>
              window.dataLayer = window.dataLayer || [];
              function gtag(){dataLayer.push(arguments);}
              gtag('js', new Date());
              gtag('config', 'G-7MEVWK53DP');
          </script>

        
        <title>BlackCat Business | Desarrollo Web y Automatización en Santander, Cantabria</title>

        <!-- Scripts -->
        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.google.recaptcha.site_key') }}"></script>

        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead
        
        <!-- Schema.org Markup -->
        <script type="application/ld+json">
        {
          "@context": "https://schema.org",
          "@type": "ProfessionalService",
          "name": "BlackCat Business",
          "image": "{{ asset('img/logo.jpg') }}",
          "@id": "{{ url('/') }}",
          "url": "{{ url('/') }}",
          "telephone": "+34 XXX XXX XXX",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Tu dirección",
            "addressLocality": "Santander",
            "postalCode": "390XX",
            "addressRegion": "Cantabria",
            "addressCountry": "ES"
          },
          "geo": {
            "@type": "GeoCoordinates",
            "latitude": "43.462776",
            "longitude": "-3.805"
          },
          "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
              "Monday",
              "Tuesday",
              "Wednesday",
              "Thursday",
              "Friday"
            ],
            "opens": "09:00",
            "closes": "18:00"
          }
        }
        </script>
    </head>
    <body>
        @inertia
    </body>
</html>