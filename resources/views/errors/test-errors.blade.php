<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار صفحات الأيرور</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            max-width: 600px;
            width: 100%;
            padding: 40px;
        }

        h1 {
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
            text-align: center;
        }

        .subtitle {
            color: #666;
            text-align: center;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .errors-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .error-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            font-size: 16px;
            font-weight: 600;
            min-height: 120px;
        }

        .error-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .error-btn:active {
            transform: translateY(-1px);
        }

        .error-code {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .error-label {
            font-size: 12px;
            opacity: 0.9;
        }

        .info-box {
            background: #f0f4ff;
            border-right: 4px solid #667eea;
            padding: 15px;
            border-radius: 4px;
            margin-bottom: 30px;
            color: #333;
            font-size: 14px;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>🧪 اختبار صفحات الأيرور</h1>
        <p class="subtitle">Error Pages Testing</p>

        <div class="info-box">
            <strong>ℹ️ تعليمات:</strong> اضغط على أي زر لاختبار صفحة الأيرور المقابلة
        </div>

        <div class="errors-grid">
            @foreach ($errors as $code => $name)
                <a href="{{ url('test-errors/' . $code) }}" class="error-btn">
                    <div class="error-code">{{ $code }}</div>
                    <div class="error-label">{{ $name }}</div>
                </a>
            @endforeach
        </div>
    </div>
</body>

</html>
