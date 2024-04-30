<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $course->name }}</title>
    <style>
        /* Estilos CSS para el PDF */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            counter-reset: page; /* Iniciar contador de páginas */
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            text-align: center;
        }

        .header-logo {
            width: 60px;
        }

        .header-title {
            font-size: 35px;
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
        }

        .footer-text {
            font-style: italic;
            color: #ccc;
        }

        /* Contador de paginas */
        .page-number:after {
            content: counter(page);
        }

        .course-title {
            text-align: center;
            margin-bottom: 20px;
        }

        .lesson-title {
            margin-bottom: 10px;
            color: #333;
        }

        .point-title {
            font-weight: bold;
        }

        .lesson-points {
            margin-left: 20px;
            margin-bottom: 20px;
            padding-left: 20px;
            border-left: 2px solid #ccc;
        }

        .lesson-points li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header class="header">
        <img class="header-logo" src="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/icon/logo.svg'))) }}" alt="EducaFree Logo">
        <h1 class="header-title">{{ $course->name }}</h1>
    </header>

    <h2>Index</h2>
    <ol>
        @foreach($course->lessons as $lesson)
            <li><a href="#lesson-{{ $loop->iteration }}">{{ $lesson->name }}</a></li>
        @endforeach
    </ol>

    @foreach($course->lessons as $lesson)
        <h2 id="lesson-{{ $loop->iteration }}" class="lesson-title">{{ $loop->iteration }}. {{ $lesson->name }}</h2>
        <ul class="lesson-points">
            @foreach($lesson->points as $point)
                <li>
                    <span class="point-title">{{ $point->name }}</span> - {!! $point->explanation !!}
                </li>
            @endforeach
        </ul>
        <div class="page-break"> </div>
    @endforeach

    <footer class="footer">
        <p class="footer-text">Downloaded from EducaFree - <span class="page-number"></span></p>
    </footer>
</body>
</html>
