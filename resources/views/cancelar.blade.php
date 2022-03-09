<!DOCTYPE html>
<html>
    <body>
        <h2>Cancelar e Salvar</h2>
        <form action="{{url('cancelar')}}" method="get">
            chNFe
            <input type="text" name="chNFe">
            tpAmb
            <input type="text" name="tpAmb">
            dhEvento
            <input type="text" name="dhEvento">
            nProt
            <input type="text" name="nProt">
            xJust
            <input type="text" name="xJust">
            <br>
            Modelo
            <input type="text" name="modelo">
            Salvar
            <input type="checkbox" name="salvar">
            <button type="submit">Submit</button>
        </form>
    </body>
</html>