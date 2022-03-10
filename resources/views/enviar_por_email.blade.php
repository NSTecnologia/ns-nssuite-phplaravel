<!DOCTYPE html>
<html>
    <body>
        <h2>Enviar por email</h2>
        <form action="{{url('enviar_email')}}" method="get">
            Modelo
            <input type="text" name="modelo">
            <button type="submit">Submit</button>
        </form>
    </body>
</html>