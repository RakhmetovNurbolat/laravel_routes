<form action="/number" method="POST">
    <input type="number" name = "number">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <button type = "submit">Send</button>
</form>
