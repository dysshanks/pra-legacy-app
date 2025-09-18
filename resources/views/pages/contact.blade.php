<!DOCTYPE html>
<html lang="en">
<head>
    <x-head/>
</head>
<body>

<x-navbar/>
<x-header/>
<form action="">
    <input type="text" name="name" id="name">
    <input type="email" name="email" id="email">
    <textarea name="message" id="message" cols="30" rows="10"></textarea>
    <input type="submit">
</form>
<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>//window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="{{ asset('/js/app.js') }}"></script>
<x-footer/>
</body>
</html>
