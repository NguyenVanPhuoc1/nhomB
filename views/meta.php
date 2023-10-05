<link rel="stylesheet" type="text/css" href="public/css/styles.css">
<!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'"> -->
<link rel="stylesheet" type="text/css" href="public/css/bootstrap.min-3.3.7.css">
<link rel="stylesheet" type="text/css" href="public/css/font-awesome.min-4.6.3.css">

<script type="text/javascript" src="public/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="public/js/bootstrap.min-3.3.7.js"></script>
<!-- Bao gồm tệp validation.js -->
<script src=" ./public/js/inputvalidator.js"></script>
<script>
        // xss
        const validator = new InputValidator(/^([a-zA-Z0-9]+)$/);
        // const validator = new InputValidator(/^([a-zA-Z0-9]+)$/);
        function checkInputSearch(e) {
            if (!validator.checkInput('input-search', validator)) {
                alert("Invalid Input XSS")
                e.preventDefault()
            }
        }
    </script>