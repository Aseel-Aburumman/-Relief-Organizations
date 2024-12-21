<!DOCTYPE html>
<html>

<head>
    <title>Donations Report</title>
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
    <h1>Donations Report</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Need Name</th>
                <th>Donor Name</th>
                <th>Quantity</th>
                <th>Date Donated</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donations as $donation)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $donation->need->needDetail->first()?->item_name ?? 'N/A' }}</td>
                    <td>{{ $donation->user->userDetail->first()?->name ?? 'Anonymous' }}</td>
                    <td>{{ $donation->quantity }}</td>
                    <td>{{ $donation->created_at ? $donation->created_at->format('Y-m-d') : 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
