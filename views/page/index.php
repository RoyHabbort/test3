<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Парсер html</title>
        
        <style>
            
            body{
                font-family: Arial, sans-serif;
            }
            
            
            .content-wrapper{
                display:flex; 
                flex-direction: row;
                justify-content:center;
            }
            
            .content{
                text-align: center;
            }
            
            
            .l1{
                display: inline-block;
                margin-bottom: 10px;
            }
            
            .error{
                font-size: 12px;
                color:#f00;
            }
            
        </style>  
        
    </head>
    
    <body>
        <div class="content-wrapper">
            <div class="content">
                <h1>Парсер HTML</h1>
                
                <form action="page/parser" method="post" name="urlForm">
                    <label class="l1">Введите url страницы для парсера:</label>
                    <div class="error"><?=  heretic::getFlash('error')?></div>
                    <input name="url" type="text" placeholder="Введите url"></input>
                    <button type="submit">Применить</button>
                </form>
            </div>
        </div>
    </body>
    
</html>