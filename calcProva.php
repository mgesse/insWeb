
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>
<head>
	<title>Calculadora sencilla</title>
	
<script> 
function calcula(operacion){ 
    var operando1 = document.calc.operando1.value 
    var operando2 = document.calc.operando2.value 
    var result = eval(operando1 + operacion + operando2) 
    document.calc.resultado.value = result 
} 
</script> 

	
</head>

<body>

<h1>Calculadora sencilla</h1>
<br>

<form name="calc"> 
<input type="Text" name="operando1" value="0" size="12"> 
<br> 
<input type="Text" name="operando2" value="0" size="12"> 
<br> 
<input type="Button" name="" value=" + " onclick="calcula('+')"> 
<input type="Button" name="" value=" - " onclick="calcula('-')"> 
<input type="Button" name="" value=" X " onclick="calcula('*')"> 
<input type="Button" name="" value=" / " onclick="calcula('/')"> 
<br> 
<input type="Text" name="resultado" value="0" size="12"> 
</form> 


</body>
</html>
