<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Previewing {{ $page }}</title>
    <style>
        article, header {
            margin: 0 auto;
            max-width: 800px;
            padding: 1rem;
        }
        header {
            border-bottom: 1px solid #ccc;
            clear: both;
            padding-left: 0;
            padding-right: 0;
        }
        header > table {
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }
        header h1 {
            margin-top: 0.25rem;
            margin-bottom: 0.25rem;
        }
        header th {
            text-align: left;
        }
        header td {
            text-align: right;
        }
    </style>
</head>
<body>
    <main>
        <header>
            <table>
                <thead>
                    <tr>
                        <th>
                            <h1>Previewing {{ $page }}</h1>
                        </th>
                        <td>
                            <button onclick="window.close()">Close window</button>
                        </td>
                    </tr>
                </thead>
            </table>
        </header>
        <article>
            {!! $markdown !!}
        </article>
    </main>
</body>
</html>
