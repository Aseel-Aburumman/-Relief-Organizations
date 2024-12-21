<!DOCTYPE html>
<html>

<head>
    <title>Organizations Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <h1>Organizations Report</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Organization Name</th>
                <th>Needs Posted</th>
                <th>Post Posted</th>
                <th>Date Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orgnizations as $orgnization)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $orgnization->userDetail->first()?->name ?? 'N/A' }}</td>
                    <td>{{ $orgnization->need->count() }}</td>
                    <td>{{ $orgnization->post->count() }}</td>
                    <td>{{ $orgnization->created_at ? $orgnization->created_at->format('Y-m-d') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
