<!DOCTYPE html>
<html>
<head>
    <title>URL Shortener</title>
    <style>
        html, body{
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            background-color: blueviolet;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #container{
            width: 50%;
            height: 50%;
            display: flex;
            flex-direction: column;
            background-color: white;
            align-items: center;
            border-radius: 20px;
        }
        ul{
            width: 80%;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            flex-wrap: wrap;
        }
    </style>
</head>
<body>
    <div id="container">
        <h2>Shorten URL</h2>
        <form method="POST" action="/api/shorten" onsubmit="submitForm(event)">
            <input type="url" id="url" name="url" placeholder="Enter URL" required>
            <button type="submit">Shorten</button>
        </form>
        <h3>Stats</h3>
        <ul id="stats"></ul>
    </div>
    <script>
        function loadStats() {
            fetch('/stats')
                .then(response => response.json())
                .then(data => {
                    const statsList = document.getElementById('stats');
                    statsList.innerHTML = '';
                    data.forEach(item => {
                        const li = document.createElement('li');
                        li.textContent = `${item.short_code} → ${item.original_url} (Jumlah Akses: ${item.jumlah_akses})`;
                        statsList.appendChild(li);
                    });
                });
        }

        function submitForm(event) {
            event.preventDefault();
            fetch('/api/shorten', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ url: document.getElementById('url').value })
            })
            .then(res => res.json())
            .then(data => {
                alert('Shortened URL: ' + data.short_url);
                loadStats();
            });
        }

        loadStats();
    </script>
</body>
</html>
