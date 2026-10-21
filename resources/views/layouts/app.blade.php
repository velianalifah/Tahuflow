<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TahuFlow')</title>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg-page: #faf8f5;
            --bg-card: #ffffff;
            --yellow-main: #f59e0b;
            --yellow-light: #fef3c7;
            --yellow-hover: #eab308;
            --yellow-dark: #d97706;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-warm: #fef08a;
            --border-subtle: #e2e8f0;
        }

        *, *::before, *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-page);
            color: var(--text-main);
            min-height: 100vh;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 18px;
            border-radius: 12px;
            margin-bottom: 16px;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }

        .alert-success {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            color: #16a34a;
        }
    </style>
    @stack('styles')
</head>
<body>
    @yield('content')
    @stack('scripts')
</body>
</html>