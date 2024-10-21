<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Swagger UI</title>
    <style>
    html {
      box-sizing: border-box;
      overflow: -moz-scrollbars-vertical;
      overflow-y: scroll;
    }

    *,
    *:before,
    *:after {
      box-sizing: inherit;
    }

    body {
      margin: 0;
      background: #fafafa;
    }
  </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui.css" />
    <link rel="icon" type="image/x-icon" href="https://static-00.iconduck.com/assets.00/swagger-icon-2048x2048-563qbzey.png">
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui-bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/swagger-ui/4.15.5/swagger-ui-standalone-preset.js"></script>
    
    <script>
        window.onload = function() {
          const BASE_URL = window.location.origin;
          const PATH_BASE = window.location.pathname.replace(/\/[^/]+$/, '');
          const PROJECT_URL = BASE_URL + PATH_BASE;

            const ui = SwaggerUIBundle({
                url: PROJECT_URL+"/api.json", 
                dom_id: '#swagger-ui',
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                layout: "StandaloneLayout",
            });
        };
    </script>
</body>
</html>
