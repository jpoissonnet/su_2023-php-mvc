<?php
echo "<h1>React</h1>";
header('Cache-Control: max-age=604800');
echo '
<head>
<script crossorigin src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
<script crossorigin src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
<script src="https://unpkg.com/@babel/standalone@7.10.3/babel.min.js"></script>
</head>

<body>
    <div id="root"></div>
    <script type="text/babel">
        const rootElement = document.getElementById("root");
        ReactDOM.render(<h1>Hello, world!</h1>, rootElement);
    </script>
</body>
';
