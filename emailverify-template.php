<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="shortcut icon" href="./images/logo.png" type="image/x-icon">
    
    <title>Account activation | Digipharm</title>
</head>
<body>
    <div class="logo">
        <img src="./images/logo-colored.png">
    </div>

    

    <p> Click on the button bellow to activate your account. </p>
    <div class="button"><a href="{{activation_link}}"><button>Activate</button></a></div>
    <p>or use the following link</p>
    <a href="{{activation_link}}">{{activation_link}}</a>
    

<style>
    body{
    background-color: #EBF1F4;
    
    font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
}
.logo{
    margin: 20px auto;
    width: fit-content;
    
}

.logo img{
    width: 120px;
}
p{
    text-align: center;
    font-size: 20px;
}


.inputs{
    width:90%;
    margin: 20px auto;
}


.button{
    width:170px;
    margin: 15px auto;
    margin-bottom: 60px;
    margin-top: 30px;
}
.button button{
    border: 1px solid #083C61;
    background-color: #083C61;
    color: white;
    border-radius: 5px;
    width: 100%;
    height: 50px;
}
a{
    text-align:center;
}





</style>
    

   

    
</body>
</html>