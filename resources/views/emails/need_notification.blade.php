<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.8;
            color: #333;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            text-align: center;
            padding: 10px 0;
            border-bottom: 2px solid #28a745;
        }

        .header h1 {
            color: #28a745;
            font-size: 24px;
        }

        .content {
            margin: 20px 0;
        }

        .content h2 {
            font-size: 20px;
            color: #333;
        }

        .content p {
            font-size: 16px;
            color: #555;
        }

        .content ul {
            padding-left: 20px;
            margin: 10px 0;
        }

        .content ul li {
            margin-bottom: 10px;
        }

        .cta {
            text-align: center;
            margin-top: 20px;
        }

        .cta a {
            display: inline-block;
            padding: 12px 20px;
            background-color: #28a745;
            color: #ffffff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }

        .cta a:hover {
            background-color: #218838;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>{{ $needDetails['organization_name'] ?? 'Our Organization' }} Needs Your Help</h1>
        </div>
        <div class="content">
            <h2>A Call to Action: {{ $needDetails['item_name']['en'] ?? 'An Urgent Need' }}</h2>
            <p>
                At <strong>{{ $needDetails['organization_name'] ?? 'Our Organization' }}</strong>, we strive every day
                to make the world a better place, but we can’t do it without you. We are reaching out because we’ve
                identified a critical need that requires immediate action:
            </p>
            <ul>
                <li><strong>Item:</strong> {{ $needDetails['item_name']['en'] ?? 'N/A' }}</li>
                <li><strong>Description:</strong> {{ $needDetails['description']['en'] ?? 'N/A' }}</li>
                <li><strong>Category:</strong> {{ $needDetails['category'] ?? 'N/A' }}</li>
                <li><strong>Quantity Needed:</strong> {{ $needDetails['quantity_needed'] ?? 'N/A' }}</li>
            </ul>
            <p>
                This is more than just numbers and details—it’s an opportunity to make a tangible impact. Your
                contribution will help us bring hope and relief to those in need. With your support, we can fulfill this
                requirement and bring smiles, comfort, and hope to the lives of so many.
            </p>
            <p>
                Imagine the difference you could make. Each donation brings us closer to fulfilling this need and
                strengthening the mission of
                <strong>{{ $needDetails['organization_name'] ?? 'Our Organization' }}</strong>.
            </p>
        </div>
        <div class="cta">
            <a href="{{ $needDetails['link'] }}">Learn More and Fulfill This Need</a>
        </div>
        <div class="content">
            <h2>Why It Matters</h2>
            <p>
                When we come together as a community, we can achieve the impossible. Every item donated brings us closer
                to building a brighter future for those in need. Let’s make this possible—together.
            </p>
            <p>
                Thank you for believing in the work of
                <strong>{{ $needDetails['organization_name'] ?? 'Our Organization' }}</strong>. Your support makes all
                the difference!
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $needDetails['organization_name'] ?? 'Our Organization' }}. All Rights
            Reserved.
        </div>
    </div>
</body>

</html>
